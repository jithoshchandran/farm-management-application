<?php

namespace App\Services;

class SimplePdfDocument
{
    private const FONT_REGULAR = 'F1';

    private const FONT_BOLD = 'F2';

    private array $pages = [];

    private array $commands = [];

    private float $y;

    public function __construct(
        private readonly float $width = 841.89,
        private readonly float $height = 595.28,
        private readonly float $margin = 28.0,
    ) {
        $this->addPage();
    }

    public function addPage(): void
    {
        if ($this->commands !== []) {
            $this->pages[] = implode("\n", $this->commands);
        }

        $this->commands = [];
        $this->y = $this->margin;
    }

    public function ensureSpace(float $height): void
    {
        if (($this->y + $height) > ($this->height - $this->margin)) {
            $this->addPage();
        }
    }

    public function text(
        float $x,
        float $y,
        string $text,
        float $size = 10,
        bool $bold = false,
        string $color = '172026',
        string $align = 'left',
        ?float $width = null,
    ): void {
        $text = $this->cleanText($text);
        $font = $bold ? self::FONT_BOLD : self::FONT_REGULAR;

        if ($width !== null && $align !== 'left') {
            $textWidth = $this->estimateTextWidth($text, $size);

            if ($align === 'right') {
                $x += max(0, $width - $textWidth);
            } elseif ($align === 'center') {
                $x += max(0, ($width - $textWidth) / 2);
            }
        }

        [$r, $g, $b] = $this->rgb($color);
        $pdfY = $this->height - $y;

        $this->commands[] = sprintf(
            'BT /%s %.2F Tf %.3F %.3F %.3F rg %.2F %.2F Td (%s) Tj ET',
            $font,
            $size,
            $r,
            $g,
            $b,
            $x,
            $pdfY,
            $this->escapeText($text),
        );
    }

    public function rect(
        float $x,
        float $y,
        float $width,
        float $height,
        ?string $fill = null,
        string $stroke = 'D7DDE8',
    ): void {
        $pdfY = $this->height - $y - $height;

        if ($fill !== null) {
            [$r, $g, $b] = $this->rgb($fill);
            $this->commands[] = sprintf(
                'q %.3F %.3F %.3F rg %.2F %.2F %.2F %.2F re f Q',
                $r,
                $g,
                $b,
                $x,
                $pdfY,
                $width,
                $height,
            );
        }

        [$r, $g, $b] = $this->rgb($stroke);
        $this->commands[] = sprintf(
            'q %.3F %.3F %.3F RG %.2F %.2F %.2F %.2F re S Q',
            $r,
            $g,
            $b,
            $x,
            $pdfY,
            $width,
            $height,
        );
    }

    public function line(float $x1, float $y1, float $x2, float $y2, string $stroke = '2563EB', float $width = 1): void
    {
        [$r, $g, $b] = $this->rgb($stroke);
        $pdfY1 = $this->height - $y1;
        $pdfY2 = $this->height - $y2;

        $this->commands[] = sprintf(
            'q %.2F w %.3F %.3F %.3F RG %.2F %.2F m %.2F %.2F l S Q',
            $width,
            $r,
            $g,
            $b,
            $x1,
            $pdfY1,
            $x2,
            $pdfY2,
        );
    }

    public function wrapText(string $text, float $width, float $fontSize): array
    {
        $text = $this->cleanText($text);
        $maxCharacters = max(8, (int) floor($width / ($fontSize * 0.52)));
        $words = preg_split('/\s+/', $text, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        $lines = [];
        $line = '';

        foreach ($words as $word) {
            if ($line === '') {
                $line = $word;

                continue;
            }

            if (strlen($line.' '.$word) <= $maxCharacters) {
                $line .= ' '.$word;

                continue;
            }

            $lines[] = $line;
            $line = $word;
        }

        if ($line !== '') {
            $lines[] = $line;
        }

        return $lines === [] ? [''] : $lines;
    }

    public function output(): string
    {
        if ($this->commands !== []) {
            $this->pages[] = implode("\n", $this->commands);
            $this->commands = [];
        }

        $objects = [
            1 => '<< /Type /Catalog /Pages 2 0 R >>',
            3 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica >>',
            4 => '<< /Type /Font /Subtype /Type1 /BaseFont /Helvetica-Bold >>',
        ];

        $pageIds = [];

        foreach ($this->pages as $index => $content) {
            $contentId = 5 + ($index * 2);
            $pageId = $contentId + 1;
            $pageIds[] = $pageId.' 0 R';

            $objects[$contentId] = "<< /Length ".strlen($content)." >>\nstream\n{$content}\nendstream";
            $objects[$pageId] = sprintf(
                '<< /Type /Page /Parent 2 0 R /MediaBox [0 0 %.2F %.2F] /Resources << /Font << /F1 3 0 R /F2 4 0 R >> >> /Contents %d 0 R >>',
                $this->width,
                $this->height,
                $contentId,
            );
        }

        $objects[2] = '<< /Type /Pages /Kids ['.implode(' ', $pageIds).'] /Count '.count($pageIds).' >>';
        ksort($objects);

        $pdf = "%PDF-1.4\n";
        $offsets = [];

        foreach ($objects as $id => $body) {
            $offsets[$id] = strlen($pdf);
            $pdf .= "{$id} 0 obj\n{$body}\nendobj\n";
        }

        $xrefOffset = strlen($pdf);
        $size = max(array_keys($objects)) + 1;

        $pdf .= "xref\n0 {$size}\n";
        $pdf .= "0000000000 65535 f \n";

        for ($id = 1; $id < $size; $id++) {
            $pdf .= sprintf("%010d 00000 n \n", $offsets[$id]);
        }

        $pdf .= "trailer\n<< /Size {$size} /Root 1 0 R >>\n";
        $pdf .= "startxref\n{$xrefOffset}\n%%EOF";

        return $pdf;
    }

    public function y(): float
    {
        return $this->y;
    }

    public function setY(float $y): void
    {
        $this->y = $y;
    }

    public function moveDown(float $height): void
    {
        $this->y += $height;
    }

    public function margin(): float
    {
        return $this->margin;
    }

    public function contentWidth(): float
    {
        return $this->width - ($this->margin * 2);
    }

    private function rgb(string $hex): array
    {
        $hex = ltrim($hex, '#');

        return [
            hexdec(substr($hex, 0, 2)) / 255,
            hexdec(substr($hex, 2, 2)) / 255,
            hexdec(substr($hex, 4, 2)) / 255,
        ];
    }

    private function estimateTextWidth(string $text, float $size): float
    {
        return strlen($text) * $size * 0.52;
    }

    private function cleanText(string $text): string
    {
        return preg_replace('/[^\x09\x0A\x0D\x20-\x7E]/', '?', $text) ?? '';
    }

    private function escapeText(string $text): string
    {
        return str_replace(['\\', '(', ')', "\r", "\n"], ['\\\\', '\(', '\)', ' ', ' '], $text);
    }
}
