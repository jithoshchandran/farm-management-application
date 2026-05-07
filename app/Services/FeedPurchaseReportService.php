<?php

namespace App\Services;

use App\Models\Feed;
use App\Models\FeedPurchase;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Collection;
use OpenSpout\Common\Entity\Row;
use OpenSpout\Common\Entity\Style\Color;
use OpenSpout\Common\Entity\Style\Style;
use OpenSpout\Writer\XLSX\Writer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;

class FeedPurchaseReportService
{
    public function build(CarbonInterface|string|null $month = null, CarbonInterface|string|null $comparisonMonth = null): array
    {
        $selectedMonth = $this->normalizeMonth($month);
        $compareMonth = $this->normalizeMonth($comparisonMonth, $selectedMonth->copy()->subMonth());

        $selected = $this->monthData($selectedMonth);
        $comparison = $this->monthData($compareMonth);

        return [
            'selected' => $selected,
            'comparison_month' => $comparison,
            'overall' => $this->overallComparison($selected, $comparison),
            'category_comparison' => $this->compareAmountRows(
                $selected['categories'],
                $comparison['categories'],
                'category',
                'category'
            ),
            'feed_comparison' => $this->compareFeedRows($selected['feeds'], $comparison['feeds']),
            'unit_comparison' => $this->compareUnitRows($selected['units'], $comparison['units']),
            'generated_at' => now()->format('d M Y, h:i A'),
        ];
    }

    public function downloadExcel(CarbonInterface|string|null $month = null, CarbonInterface|string|null $comparisonMonth = null): StreamedResponse
    {
        $report = $this->build($month, $comparisonMonth);

        return response()->streamDownload(function () use ($report): void {
            $this->writeExcel($report, 'php://output');
        }, $this->filename($report, 'xlsx'), [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        ]);
    }

    public function downloadPdf(CarbonInterface|string|null $month = null, CarbonInterface|string|null $comparisonMonth = null): Response
    {
        $report = $this->build($month, $comparisonMonth);
        $pdf = $this->writePdf($report);

        return response($pdf, 200, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'attachment; filename="'.$this->filename($report, 'pdf').'"',
        ]);
    }

    public function writeExcel(array $report, string $path): void
    {
        $writer = new Writer();
        $writer->openToFile($path);

        try {
            $titleStyle = (new Style())
                ->setFontBold()
                ->setFontSize(16)
                ->setFontColor(Color::WHITE)
                ->setBackgroundColor(Color::DARK_BLUE);

            $sectionStyle = (new Style())
                ->setFontBold()
                ->setFontColor(Color::WHITE)
                ->setBackgroundColor(Color::BLUE);

            $headerStyle = (new Style())
                ->setFontBold()
                ->setBackgroundColor('D9EAF7');

            $totalStyle = (new Style())
                ->setFontBold()
                ->setBackgroundColor('E2F0D9');

            $sheet = $writer->getCurrentSheet();
            $sheet->setName('Summary');
            $sheet->setColumnWidth(24, 1, 2, 3, 4, 5, 6, 7, 8);

            $this->writeSummarySheet($writer, $report, $titleStyle, $sectionStyle, $headerStyle, $totalStyle);

            $writer->addNewSheetAndMakeItCurrent()->setName('Report Month');
            $this->writeDetailsSheet($writer, $report['selected'], $titleStyle, $headerStyle);

            $writer->addNewSheetAndMakeItCurrent()->setName('Compare Month');
            $this->writeDetailsSheet($writer, $report['comparison_month'], $titleStyle, $headerStyle);
        } finally {
            $writer->close();
        }
    }

    public function writePdf(array $report): string
    {
        $pdf = new SimplePdfDocument();

        $this->writePdfHeader($pdf, $report);
        $this->writePdfKpis($pdf, $report);

        $this->writePdfTable(
            $pdf,
            'Quantity By Unit',
            ['Unit', $report['selected']['label'].' Qty', $report['comparison_month']['label'].' Qty', 'Qty Change', $report['selected']['label'].' Amount', $report['comparison_month']['label'].' Amount', 'Amount Change', 'Change %'],
            $this->pdfUnitRows($report),
            [90, 90, 90, 80, 105, 105, 105, 75],
            ['left', 'right', 'right', 'right', 'right', 'right', 'right', 'right'],
        );

        $this->writePdfTable(
            $pdf,
            'Category Amount Comparison',
            ['Category', $report['selected']['label'].' Amount', $report['comparison_month']['label'].' Amount', 'Amount Change', 'Change %', $report['selected']['label'].' Purchases', $report['comparison_month']['label'].' Purchases'],
            $this->pdfCategoryRows($report),
            [180, 110, 110, 110, 75, 95, 95],
            ['left', 'right', 'right', 'right', 'right', 'right', 'right'],
        );

        $this->writePdfTable(
            $pdf,
            'Feed Comparison',
            ['Category', 'Feed', 'Unit', $report['selected']['label'].' Qty', $report['comparison_month']['label'].' Qty', 'Qty Change', $report['selected']['label'].' Amount', $report['comparison_month']['label'].' Amount', 'Amount Change', 'Change %'],
            $this->pdfFeedRows($report),
            [105, 145, 45, 65, 65, 65, 80, 80, 80, 55],
            ['left', 'left', 'left', 'right', 'right', 'right', 'right', 'right', 'right', 'right'],
        );

        $pdf->addPage();

        $this->writePdfTable(
            $pdf,
            $report['selected']['label'].' Purchase Details',
            ['Date', 'Category', 'Feed', 'Unit', 'Unit Price', 'Quantity', 'Total'],
            $this->pdfDetailRows($report['selected']),
            [80, 140, 180, 55, 95, 80, 95],
            ['left', 'left', 'left', 'left', 'right', 'right', 'right'],
        );

        $this->writePdfTable(
            $pdf,
            $report['comparison_month']['label'].' Purchase Details',
            ['Date', 'Category', 'Feed', 'Unit', 'Unit Price', 'Quantity', 'Total'],
            $this->pdfDetailRows($report['comparison_month']),
            [80, 140, 180, 55, 95, 80, 95],
            ['left', 'left', 'left', 'left', 'right', 'right', 'right'],
        );

        return $pdf->output();
    }

    private function writePdfHeader(SimplePdfDocument $pdf, array $report): void
    {
        $x = $pdf->margin();
        $width = $pdf->contentWidth();

        $pdf->text($x, 44, 'Feed Purchase Monthly Report', 20, true, '0F172A');
        $pdf->text($x, 61, 'Generated at '.$report['generated_at'], 9, false, '475569');
        $pdf->text($x + 540, 43, $report['selected']['label'], 13, true, '0F172A', 'right', $width - 540);
        $pdf->text($x + 540, 59, 'Compared with '.$report['comparison_month']['label'], 9, false, '475569', 'right', $width - 540);
        $pdf->line($x, 70, $x + $width, 70, '2563EB', 2);
        $pdf->setY(84);
    }

    private function writePdfKpis(SimplePdfDocument $pdf, array $report): void
    {
        $overall = $report['overall'];
        $x = $pdf->margin();
        $y = $pdf->y();
        $gap = 8;
        $boxWidth = ($pdf->contentWidth() - ($gap * 2)) / 3;
        $boxHeight = 62;

        $cards = [
            [
                'label' => 'Total Amount',
                'value' => $this->formatMoney($overall['total_amount']['selected']),
                'compare' => 'Change: '.$this->formatMoney($overall['total_amount']['change']).' ('.$this->formatPercent($overall['total_amount']['change_percent']).')',
            ],
            [
                'label' => 'Purchase Count',
                'value' => $this->formatCount($overall['purchase_count']['selected']),
                'compare' => 'Change: '.$this->formatCount($overall['purchase_count']['change']).' ('.$this->formatPercent($overall['purchase_count']['change_percent']).')',
            ],
            [
                'label' => 'Average Purchase',
                'value' => $this->formatMoney($overall['average_purchase']['selected']),
                'compare' => 'Change: '.$this->formatMoney($overall['average_purchase']['change']).' ('.$this->formatPercent($overall['average_purchase']['change_percent']).')',
            ],
        ];

        foreach ($cards as $index => $card) {
            $left = $x + (($boxWidth + $gap) * $index);
            $pdf->rect($left, $y, $boxWidth, $boxHeight, 'F8FAFC', 'D7DDE8');
            $pdf->text($left + 8, $y + 16, $card['label'], 8, true, '64748B');
            $pdf->text($left + 8, $y + 38, $card['value'], 17, true, '0F172A');
            $pdf->text($left + 8, $y + 54, $card['compare'], 8, false, '475569');
        }

        $pdf->setY($y + $boxHeight + 16);
    }

    private function writePdfTable(
        SimplePdfDocument $pdf,
        string $title,
        array $headers,
        array $rows,
        array $widths,
        array $alignments,
    ): void {
        $pdf->ensureSpace(42);
        $this->drawPdfSectionTitle($pdf, $title);
        $this->drawPdfTableHeader($pdf, $headers, $widths, $alignments);

        foreach ($rows as $row) {
            $wrappedCells = [];
            $lineCount = 1;

            foreach ($row as $index => $cell) {
                $lines = $pdf->wrapText((string) $cell, $widths[$index] - 8, 8);
                $wrappedCells[] = $lines;
                $lineCount = max($lineCount, count($lines));
            }

            $rowHeight = max(18, ($lineCount * 9) + 8);
            $beforeY = $pdf->y();
            $pdf->ensureSpace($rowHeight);

            if ($pdf->y() < $beforeY) {
                $this->drawPdfSectionTitle($pdf, $title.' (continued)');
                $this->drawPdfTableHeader($pdf, $headers, $widths, $alignments);
            }

            $this->drawPdfTableRow($pdf, $wrappedCells, $widths, $alignments, $rowHeight);
        }

        $pdf->moveDown(12);
    }

    private function drawPdfSectionTitle(SimplePdfDocument $pdf, string $title): void
    {
        $x = $pdf->margin();
        $y = $pdf->y();
        $width = $pdf->contentWidth();

        $pdf->rect($x, $y, $width, 18, '1E40AF', '1E40AF');
        $pdf->text($x + 6, $y + 12, $title, 10, true, 'FFFFFF');
        $pdf->moveDown(18);
    }

    private function drawPdfTableHeader(SimplePdfDocument $pdf, array $headers, array $widths, array $alignments): void
    {
        $wrapped = array_map(fn (string $header, int $index): array => $pdf->wrapText($header, $widths[$index] - 8, 7.5), $headers, array_keys($headers));
        $height = max(18, (max(array_map('count', $wrapped)) * 8.5) + 8);

        $this->drawPdfTableRow($pdf, $wrapped, $widths, $alignments, $height, 'DBEAFE', true, 7.5);
    }

    private function drawPdfTableRow(
        SimplePdfDocument $pdf,
        array $wrappedCells,
        array $widths,
        array $alignments,
        float $height,
        string $fill = 'FFFFFF',
        bool $bold = false,
        float $fontSize = 8,
    ): void {
        $x = $pdf->margin();
        $y = $pdf->y();
        $lineHeight = $fontSize + 1.4;

        foreach ($wrappedCells as $index => $lines) {
            $width = $widths[$index];
            $align = $alignments[$index] ?? 'left';
            $pdf->rect($x, $y, $width, $height, $fill, 'D7DDE8');

            foreach ($lines as $lineIndex => $line) {
                $pdf->text(
                    $x + 4,
                    $y + 11 + ($lineIndex * $lineHeight),
                    (string) $line,
                    $fontSize,
                    $bold,
                    '172026',
                    $align,
                    $width - 8,
                );
            }

            $x += $width;
        }

        $pdf->moveDown($height);
    }

    private function pdfUnitRows(array $report): array
    {
        if ($report['unit_comparison'] === []) {
            return [['No purchases found in either month.', '', '', '', '', '', '', '']];
        }

        return array_map(fn (array $row): array => [
            $row['unit_label'],
            $this->formatNumber($row['selected_quantity']),
            $this->formatNumber($row['comparison_quantity']),
            $this->formatNumber($row['quantity_change']),
            $this->formatMoney($row['selected_amount']),
            $this->formatMoney($row['comparison_amount']),
            $this->formatMoney($row['amount_change']),
            $this->formatPercent($row['amount_change_percent']),
        ], $report['unit_comparison']);
    }

    private function pdfCategoryRows(array $report): array
    {
        if ($report['category_comparison'] === []) {
            return [['No category totals found in either month.', '', '', '', '', '', '']];
        }

        return array_map(fn (array $row): array => [
            $row['label'],
            $this->formatMoney($row['selected_amount']),
            $this->formatMoney($row['comparison_amount']),
            $this->formatMoney($row['amount_change']),
            $this->formatPercent($row['amount_change_percent']),
            $this->formatCount($row['selected_purchase_count']),
            $this->formatCount($row['comparison_purchase_count']),
        ], $report['category_comparison']);
    }

    private function pdfFeedRows(array $report): array
    {
        if ($report['feed_comparison'] === []) {
            return [['No feed totals found in either month.', '', '', '', '', '', '', '', '', '']];
        }

        return array_map(fn (array $row): array => [
            $row['category'],
            $row['feed'],
            $row['unit_label'],
            $this->formatNumber($row['selected_quantity']),
            $this->formatNumber($row['comparison_quantity']),
            $this->formatNumber($row['quantity_change']),
            $this->formatMoney($row['selected_amount']),
            $this->formatMoney($row['comparison_amount']),
            $this->formatMoney($row['amount_change']),
            $this->formatPercent($row['amount_change_percent']),
        ], $report['feed_comparison']);
    }

    private function pdfDetailRows(array $monthData): array
    {
        if ($monthData['rows'] === []) {
            return [['No purchases found for '.$monthData['label'].'.', '', '', '', '', '', '']];
        }

        return array_map(fn (array $row): array => [
            $row['date'],
            $row['category'],
            $row['feed'],
            $row['unit_label'],
            $this->formatMoney($row['unit_price']),
            $this->formatNumber($row['quantity']),
            $this->formatMoney($row['total']),
        ], $monthData['rows']);
    }

    private function normalizeMonth(CarbonInterface|string|null $month = null, CarbonInterface|string|null $fallback = null): Carbon
    {
        $value = $month ?? $fallback ?? now();

        if ($value instanceof CarbonInterface) {
            return Carbon::parse($value->format('Y-m-d'))->startOfMonth();
        }

        return Carbon::parse($value)->startOfMonth();
    }

    private function monthData(Carbon $month): array
    {
        $start = $month->copy()->startOfMonth();
        $end = $month->copy()->endOfMonth();

        $rows = FeedPurchase::query()
            ->with('feed')
            ->whereDate('purchase_date', '>=', $start->toDateString())
            ->whereDate('purchase_date', '<=', $end->toDateString())
            ->orderBy('purchase_date')
            ->orderBy('id')
            ->get()
            ->map(fn (FeedPurchase $purchase): array => $this->purchaseRow($purchase))
            ->values();

        $totalAmount = round((float) $rows->sum('total'), 2);
        $purchaseCount = $rows->count();

        return [
            'key' => $month->format('Y-m'),
            'label' => $month->format('F Y'),
            'start' => $start->toDateString(),
            'end' => $end->toDateString(),
            'rows' => $rows->all(),
            'summary' => [
                'purchase_count' => $purchaseCount,
                'total_amount' => $totalAmount,
                'average_purchase' => $purchaseCount > 0 ? round($totalAmount / $purchaseCount, 2) : 0.0,
            ],
            'categories' => $this->categoryTotals($rows),
            'feeds' => $this->feedTotals($rows),
            'units' => $this->unitTotals($rows),
        ];
    }

    private function purchaseRow(FeedPurchase $purchase): array
    {
        $unit = $purchase->unit ?: ($purchase->feed?->unit ?: 'kg');

        return [
            'id' => $purchase->id,
            'date' => $purchase->purchase_date?->format('d M Y') ?? '',
            'feed_id' => $purchase->feed_id,
            'feed' => $purchase->feed?->name ?? 'Deleted feed',
            'category' => $purchase->category ?: ($purchase->feed?->category ?: 'Uncategorized'),
            'unit' => $unit,
            'unit_label' => Feed::UNIT_OPTIONS[$unit] ?? ucfirst((string) $unit),
            'unit_price' => round((float) $purchase->unit_price, 2),
            'quantity' => round((float) $purchase->quantity, 2),
            'total' => round((float) $purchase->total, 2),
        ];
    }

    private function categoryTotals(Collection $rows): array
    {
        return $rows
            ->groupBy('category')
            ->map(fn (Collection $items, string $category): array => [
                'category' => $category,
                'purchase_count' => $items->count(),
                'total_amount' => round((float) $items->sum('total'), 2),
            ])
            ->sortByDesc('total_amount')
            ->values()
            ->all();
    }

    private function feedTotals(Collection $rows): array
    {
        return $rows
            ->groupBy(fn (array $row): string => (string) ($row['feed_id'] ?: $row['feed']))
            ->map(function (Collection $items, string $key): array {
                $first = $items->first();
                $quantity = round((float) $items->sum('quantity'), 2);
                $total = round((float) $items->sum('total'), 2);

                return [
                    'key' => $key,
                    'feed' => $first['feed'],
                    'category' => $first['category'],
                    'unit' => $first['unit'],
                    'unit_label' => $first['unit_label'],
                    'purchase_count' => $items->count(),
                    'quantity' => $quantity,
                    'average_unit_price' => $quantity > 0 ? round($total / $quantity, 2) : 0.0,
                    'total_amount' => $total,
                ];
            })
            ->sortByDesc('total_amount')
            ->values()
            ->all();
    }

    private function unitTotals(Collection $rows): array
    {
        return $rows
            ->groupBy('unit')
            ->map(fn (Collection $items, string $unit): array => [
                'unit' => $unit,
                'unit_label' => Feed::UNIT_OPTIONS[$unit] ?? ucfirst((string) $unit),
                'quantity' => round((float) $items->sum('quantity'), 2),
                'total_amount' => round((float) $items->sum('total'), 2),
            ])
            ->sortBy('unit_label')
            ->values()
            ->all();
    }

    private function overallComparison(array $selected, array $comparison): array
    {
        $selectedSummary = $selected['summary'];
        $comparisonSummary = $comparison['summary'];

        return [
            'total_amount' => $this->metricComparison(
                (float) $selectedSummary['total_amount'],
                (float) $comparisonSummary['total_amount']
            ),
            'purchase_count' => $this->metricComparison(
                (float) $selectedSummary['purchase_count'],
                (float) $comparisonSummary['purchase_count']
            ),
            'average_purchase' => $this->metricComparison(
                (float) $selectedSummary['average_purchase'],
                (float) $comparisonSummary['average_purchase']
            ),
        ];
    }

    private function compareAmountRows(array $selectedRows, array $comparisonRows, string $keyName, string $labelName): array
    {
        $selected = collect($selectedRows)->keyBy($keyName);
        $comparison = collect($comparisonRows)->keyBy($keyName);

        return $selected
            ->keys()
            ->merge($comparison->keys())
            ->unique()
            ->map(function ($key) use ($selected, $comparison, $labelName): array {
                $selectedRow = $selected->get($key, []);
                $comparisonRow = $comparison->get($key, []);
                $selectedAmount = (float) ($selectedRow['total_amount'] ?? 0);
                $comparisonAmount = (float) ($comparisonRow['total_amount'] ?? 0);

                return [
                    'label' => (string) ($selectedRow[$labelName] ?? $comparisonRow[$labelName] ?? $key),
                    'selected_amount' => $selectedAmount,
                    'comparison_amount' => $comparisonAmount,
                    'amount_change' => round($selectedAmount - $comparisonAmount, 2),
                    'amount_change_percent' => $this->percentChange($selectedAmount, $comparisonAmount),
                    'selected_purchase_count' => (int) ($selectedRow['purchase_count'] ?? 0),
                    'comparison_purchase_count' => (int) ($comparisonRow['purchase_count'] ?? 0),
                ];
            })
            ->sortByDesc(fn (array $row): float => max($row['selected_amount'], $row['comparison_amount'], abs($row['amount_change'])))
            ->values()
            ->all();
    }

    private function compareFeedRows(array $selectedRows, array $comparisonRows): array
    {
        $selected = collect($selectedRows)->keyBy('key');
        $comparison = collect($comparisonRows)->keyBy('key');

        return $selected
            ->keys()
            ->merge($comparison->keys())
            ->unique()
            ->map(function ($key) use ($selected, $comparison): array {
                $selectedRow = $selected->get($key, []);
                $comparisonRow = $comparison->get($key, []);
                $selectedQuantity = (float) ($selectedRow['quantity'] ?? 0);
                $comparisonQuantity = (float) ($comparisonRow['quantity'] ?? 0);
                $selectedAmount = (float) ($selectedRow['total_amount'] ?? 0);
                $comparisonAmount = (float) ($comparisonRow['total_amount'] ?? 0);

                return [
                    'feed' => (string) ($selectedRow['feed'] ?? $comparisonRow['feed'] ?? $key),
                    'category' => (string) ($selectedRow['category'] ?? $comparisonRow['category'] ?? ''),
                    'unit_label' => (string) ($selectedRow['unit_label'] ?? $comparisonRow['unit_label'] ?? ''),
                    'selected_quantity' => $selectedQuantity,
                    'comparison_quantity' => $comparisonQuantity,
                    'quantity_change' => round($selectedQuantity - $comparisonQuantity, 2),
                    'selected_amount' => $selectedAmount,
                    'comparison_amount' => $comparisonAmount,
                    'amount_change' => round($selectedAmount - $comparisonAmount, 2),
                    'amount_change_percent' => $this->percentChange($selectedAmount, $comparisonAmount),
                ];
            })
            ->sortByDesc(fn (array $row): float => max($row['selected_amount'], $row['comparison_amount'], abs($row['amount_change'])))
            ->values()
            ->all();
    }

    private function compareUnitRows(array $selectedRows, array $comparisonRows): array
    {
        $selected = collect($selectedRows)->keyBy('unit');
        $comparison = collect($comparisonRows)->keyBy('unit');

        return $selected
            ->keys()
            ->merge($comparison->keys())
            ->unique()
            ->map(function ($unit) use ($selected, $comparison): array {
                $selectedRow = $selected->get($unit, []);
                $comparisonRow = $comparison->get($unit, []);
                $selectedQuantity = (float) ($selectedRow['quantity'] ?? 0);
                $comparisonQuantity = (float) ($comparisonRow['quantity'] ?? 0);
                $selectedAmount = (float) ($selectedRow['total_amount'] ?? 0);
                $comparisonAmount = (float) ($comparisonRow['total_amount'] ?? 0);

                return [
                    'unit_label' => (string) ($selectedRow['unit_label'] ?? $comparisonRow['unit_label'] ?? $unit),
                    'selected_quantity' => $selectedQuantity,
                    'comparison_quantity' => $comparisonQuantity,
                    'quantity_change' => round($selectedQuantity - $comparisonQuantity, 2),
                    'selected_amount' => $selectedAmount,
                    'comparison_amount' => $comparisonAmount,
                    'amount_change' => round($selectedAmount - $comparisonAmount, 2),
                    'amount_change_percent' => $this->percentChange($selectedAmount, $comparisonAmount),
                ];
            })
            ->sortBy('unit_label')
            ->values()
            ->all();
    }

    private function metricComparison(float $selected, float $comparison): array
    {
        return [
            'selected' => $selected,
            'comparison' => $comparison,
            'change' => round($selected - $comparison, 2),
            'change_percent' => $this->percentChange($selected, $comparison),
        ];
    }

    private function percentChange(float $selected, float $comparison): ?float
    {
        if (abs($comparison) < 0.00001) {
            return abs($selected) < 0.00001 ? 0.0 : null;
        }

        return round((($selected - $comparison) / $comparison) * 100, 2);
    }

    private function writeSummarySheet(
        Writer $writer,
        array $report,
        Style $titleStyle,
        Style $sectionStyle,
        Style $headerStyle,
        Style $totalStyle
    ): void {
        $selectedLabel = $report['selected']['label'];
        $comparisonLabel = $report['comparison_month']['label'];

        $this->addRow($writer, ['Feed Purchase Monthly Report'], $titleStyle);
        $this->addRow($writer, ['Report Month', $selectedLabel]);
        $this->addRow($writer, ['Compare With', $comparisonLabel]);
        $this->addRow($writer, ['Generated At', $report['generated_at']]);
        $this->addBlankRow($writer);

        $this->addRow($writer, ['Overall Comparison'], $sectionStyle);
        $this->addRow($writer, ['Metric', $selectedLabel, $comparisonLabel, 'Change', 'Change %'], $headerStyle);
        $this->addRow($writer, [
            'Total amount (Rs)',
            $report['overall']['total_amount']['selected'],
            $report['overall']['total_amount']['comparison'],
            $report['overall']['total_amount']['change'],
            $this->formatPercent($report['overall']['total_amount']['change_percent']),
        ], $totalStyle);
        $this->addRow($writer, [
            'Purchase count',
            $report['overall']['purchase_count']['selected'],
            $report['overall']['purchase_count']['comparison'],
            $report['overall']['purchase_count']['change'],
            $this->formatPercent($report['overall']['purchase_count']['change_percent']),
        ]);
        $this->addRow($writer, [
            'Average purchase (Rs)',
            $report['overall']['average_purchase']['selected'],
            $report['overall']['average_purchase']['comparison'],
            $report['overall']['average_purchase']['change'],
            $this->formatPercent($report['overall']['average_purchase']['change_percent']),
        ]);
        $this->addBlankRow($writer);

        $this->addRow($writer, ['Quantity By Unit'], $sectionStyle);
        $this->addRow($writer, ['Unit', $selectedLabel.' Qty', $comparisonLabel.' Qty', 'Qty Change', $selectedLabel.' Amount (Rs)', $comparisonLabel.' Amount (Rs)', 'Amount Change (Rs)', 'Change %'], $headerStyle);
        foreach ($report['unit_comparison'] as $row) {
            $this->addRow($writer, [
                $row['unit_label'],
                $row['selected_quantity'],
                $row['comparison_quantity'],
                $row['quantity_change'],
                $row['selected_amount'],
                $row['comparison_amount'],
                $row['amount_change'],
                $this->formatPercent($row['amount_change_percent']),
            ]);
        }
        $this->addBlankRow($writer);

        $this->addRow($writer, ['Category Amount Comparison'], $sectionStyle);
        $this->addRow($writer, ['Category', $selectedLabel.' Amount (Rs)', $comparisonLabel.' Amount (Rs)', 'Amount Change (Rs)', 'Change %', $selectedLabel.' Purchases', $comparisonLabel.' Purchases'], $headerStyle);
        foreach ($report['category_comparison'] as $row) {
            $this->addRow($writer, [
                $row['label'],
                $row['selected_amount'],
                $row['comparison_amount'],
                $row['amount_change'],
                $this->formatPercent($row['amount_change_percent']),
                $row['selected_purchase_count'],
                $row['comparison_purchase_count'],
            ]);
        }
        $this->addBlankRow($writer);

        $this->addRow($writer, ['Feed Comparison'], $sectionStyle);
        $this->addRow($writer, ['Category', 'Feed', 'Unit', $selectedLabel.' Qty', $comparisonLabel.' Qty', 'Qty Change', $selectedLabel.' Amount (Rs)', $comparisonLabel.' Amount (Rs)', 'Amount Change (Rs)', 'Change %'], $headerStyle);
        foreach ($report['feed_comparison'] as $row) {
            $this->addRow($writer, [
                $row['category'],
                $row['feed'],
                $row['unit_label'],
                $row['selected_quantity'],
                $row['comparison_quantity'],
                $row['quantity_change'],
                $row['selected_amount'],
                $row['comparison_amount'],
                $row['amount_change'],
                $this->formatPercent($row['amount_change_percent']),
            ]);
        }
    }

    private function writeDetailsSheet(Writer $writer, array $monthData, Style $titleStyle, Style $headerStyle): void
    {
        $sheet = $writer->getCurrentSheet();
        $sheet->setColumnWidth(16, 1, 3, 4, 5, 6, 7);
        $sheet->setColumnWidth(28, 2);

        $this->addRow($writer, ['Feed Purchases - '.$monthData['label']], $titleStyle);
        $this->addRow($writer, ['Date Range', $monthData['start'].' to '.$monthData['end']]);
        $this->addRow($writer, ['Total Amount (Rs)', $monthData['summary']['total_amount']]);
        $this->addRow($writer, ['Purchase Count', $monthData['summary']['purchase_count']]);
        $this->addBlankRow($writer);

        $this->addRow($writer, ['Date', 'Category', 'Feed', 'Unit', 'Unit Price (Rs)', 'Quantity', 'Total (Rs)'], $headerStyle);

        if ($monthData['rows'] === []) {
            $this->addRow($writer, ['No feed purchases found for this month.']);

            return;
        }

        foreach ($monthData['rows'] as $row) {
            $this->addRow($writer, [
                $row['date'],
                $row['category'],
                $row['feed'],
                $row['unit_label'],
                $row['unit_price'],
                $row['quantity'],
                $row['total'],
            ]);
        }
    }

    private function addRow(Writer $writer, array $values, ?Style $style = null): void
    {
        $writer->addRow(Row::fromValues($values, $style));
    }

    private function addBlankRow(Writer $writer): void
    {
        $this->addRow($writer, []);
    }

    private function formatPercent(?float $value): string
    {
        return $value === null ? 'New' : number_format($value, 2).'%';
    }

    private function formatMoney(float|int|string|null $value): string
    {
        return 'Rs '.number_format((float) $value, 2);
    }

    private function formatNumber(float|int|string|null $value): string
    {
        return number_format((float) $value, 2);
    }

    private function formatCount(float|int|string|null $value): string
    {
        return number_format((int) $value);
    }

    private function filename(array $report, string $extension): string
    {
        return sprintf(
            'feed-purchases-%s-vs-%s.%s',
            $report['selected']['key'],
            $report['comparison_month']['key'],
            $extension
        );
    }
}
