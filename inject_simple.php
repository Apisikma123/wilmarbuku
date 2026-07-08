<?php
$cartControllerPath = 'd:/WILMARBOOKS/app/Http/Controllers/CartController.php';
$content = file_get_contents($cartControllerPath);

$content = str_replace(
    'class CartController extends Controller',
    'class CartController extends Controller',
    $content
);

// Inject simple microtime logger
$injection = <<<'PHP'
    if (!function_exists("my_log")) { function my_log($msg, $time) { 
        \Illuminate\Support\Facades\Log::info($msg . ' - ' . round($time * 1000, 2) . " ms"); 
    } }
PHP;

$content = str_replace(
    'class CartController extends Controller',
    $injection . ' class CartController extends Controller',
    $content
);

// Inside add
$content = str_replace(
    'public function add(Request $request, $id)',
    'public function add(Request $request, $id) { $s0 = microtime(true);',
    $content
);

$content = str_replace(
    '$cart = Auth::user()->cart_data ?? [];',
    '$t1 = microtime(true) - $s0; my_log("Add Cart: Init to get Cart", $t1); $s1 = microtime(true); $cart = Auth::user()->cart_data ?? [];',
    $content
);

$content = str_replace(
    'Auth::user()->update([\'cart_data\' => $cart]);',
    '$t2 = microtime(true) - $s1; my_log("Add Cart: Processing Cart", $t2); $s2 = microtime(true); Auth::user()->update([\'cart_data\' => $cart]); $t3 = microtime(true) - $s2; my_log("Add Cart: Save to DB", $t3);',
    $content
);

file_put_contents($cartControllerPath, $content);
echo "Injected Cart";
