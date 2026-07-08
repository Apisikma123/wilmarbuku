<?php
$json = file_get_contents('d:/WILMARBOOKS/profile_output.json');
$data = json_decode($json, true);
if ($data === null) {
    die("JSON Error: " . json_last_error_msg() . "\n");
}

$allOperations = $data; // Already flat from ProfileTest

usort($allOperations, function($a, $b) {
    return $b['time'] <=> $a['time'];
});

echo "=== TOP 20 SLOWEST OPERATIONS GLOBAL ===\n";
echo "=== ALL CUSTOM STEPS ===\n";
foreach ($allOperations as $op) {
    if ($op['type'] === 'Total') {
        echo sprintf("%s - %.2f ms\n", $op['name'], $op['time']);
    }
}

// Group by type for slowest categories
$slowestByType = [];
foreach ($allOperations as $op) {
    if (!isset($slowestByType[$op['type']])) {
        $slowestByType[$op['type']] = $op;
    }
}

echo "\n=== SLOWEST PER CATEGORY ===\n";
foreach ($slowestByType as $type => $op) {
    echo sprintf("%s Terlambat: %s (%.2f ms)\n", $type, $op['name'], $op['time']);
}
