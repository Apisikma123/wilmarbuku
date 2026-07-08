<?php
$checkoutControllerPath = 'd:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php';
$content = file_get_contents($checkoutControllerPath);

$injection = <<<'PHP'
    if (!function_exists("my_log")) { function my_log($msg, $time) { 
        file_put_contents(base_path('my_prof.log'), $msg . ' - ' . round($time * 1000, 2) . " ms\n", FILE_APPEND); 
    } }
PHP;

$content = str_replace(
    'class CheckoutController extends Controller',
    $injection . ' class CheckoutController extends Controller',
    $content
);

// process
$content = str_replace(
    'public function process(Request $request)
    {',
    'public function process(Request $request) { $s0 = microtime(true);',
    $content
);

$content = str_replace(
    '$kode_tracking = \'WB\' . date(\'Ym\') . \'-\' . strtoupper(Str::random(5));',
    '$t1 = microtime(true) - $s0; my_log("Checkout: Validation & Init", $t1); $s1 = microtime(true); $kode_tracking = \'WB\' . date(\'Ym\') . \'-\' . strtoupper(Str::random(5));',
    $content
);

$content = str_replace(
    '\Illuminate\Support\Facades\DB::transaction(function () use ($checkoutCart, $user, $kode_tracking) {',
    '$t2 = microtime(true) - $s1; my_log("Checkout: Loop 1", $t2); $s2 = microtime(true); \Illuminate\Support\Facades\DB::transaction(function () use ($checkoutCart, $user, $kode_tracking) { $s_db = microtime(true);',
    $content
);

$content = str_replace(
    '        });',
    '            my_log("Checkout: Inside DB Transaction", microtime(true) - $s_db); }); $t3 = microtime(true) - $s2; my_log("Checkout: DB Transaction Total", $t3); $s3 = microtime(true);',
    $content
);

$content = str_replace(
    'return redirect()->route(\'payment\')->with(\'kode_tracking\', $kode_tracking);',
    '$t4 = microtime(true) - $s3; my_log("Checkout: Clean Cart", $t4); return redirect()->route(\'payment\')->with(\'kode_tracking\', $kode_tracking);',
    $content
);

file_put_contents($checkoutControllerPath, $content);
echo "Injected Checkout";
