<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

$layanans = App\Models\Layanan::latest()->take(5)->get();
foreach ($layanans as $layanan) {
    echo "ID: " . $layanan->id . "\n";
    echo "Kategori: " . $layanan->kategori . "\n";
    echo "Klasifikasi: " . $layanan->klasifikasi . "\n";
    echo "Detail: " . json_encode($layanan->detail_klasifikasi) . "\n";
    echo "--------------------------\n";
}
