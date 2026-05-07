<?php
$groups = [
    'Operations & Finance' => [
        'MilkProductionResource.php',
        'FeedAllocationResource.php',
        'ExpenseResource.php',
        'SalaryPaymentResource.php',
        'FeedPurchaseResource.php'
    ],
    'Health & Breeding' => [
        'TreatmentResource.php',
        'VaccinationResource.php',
        'InseminationResource.php',
        'SemenStockResource.php',
        'CryocanResource.php'
    ],
    'Personnel Management' => [
        'StaffResource.php',
        'VeterinarianResource.php'
    ],
    'Resources & Setup' => [
        'CowResource.php',
        'FeedResource.php',
        'ExpenseItemResource.php',
        'ExpenseCategoryResource.php',
        'BreedResource.php'
    ]
];

$dir = new RecursiveDirectoryIterator(__DIR__ . '/app/Filament/Resources');
$iterator = new RecursiveIteratorIterator($dir);

foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $filename = $file->getFilename();
        foreach ($groups as $groupName => $files) {
            if (in_array($filename, $files)) {
                $content = file_get_contents($file->getPathname());
                
                // If it doesn't already have navigationGroup, insert it after navigationIcon
                if (!str_contains($content, '$navigationGroup')) {
                    $insert = "\n    protected static ?string \$navigationGroup = '$groupName';\n";
                    $content = preg_replace('/(protected static string\|\\\\BackedEnum\|null \$navigationIcon = \'.*?\';)/s', "$1$insert", $content);
                    file_put_contents($file->getPathname(), $content);
                }
            }
        }
    }
}
