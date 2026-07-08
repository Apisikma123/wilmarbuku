<?php
$checkoutControllerPath = 'd:/WILMARBOOKS/app/Http/Controllers/CheckoutController.php';
$content = file_get_contents($checkoutControllerPath);

// Inject top of class definition
$content = str_replace(
    'class CheckoutController extends Controller',
    'if (!function_exists("p_start")) { function p_start($n) { if (function_exists("profiler_step_start")) profiler_step_start($n); } } if (!function_exists("p_end")) { function p_end($n) { if (function_exists("profiler_step_end")) profiler_step_end($n); } } class CheckoutController extends Controller',
    $content
);

// Process method
$content = str_replace(
    'public function process(Request $request)
    {',
    'public function process(Request $request) { p_start("Checkout Controller: Process Method");',
    $content
);
$content = preg_replace(
    '/(return redirect\(\)->route\(\'payment\'\)->with\(\'kode_tracking\', \$kode_tracking\);\s*})/',
    'p_end("Checkout Controller: Process Method"); $1',
    $content
);

// Loops in process
$content = str_replace(
    'foreach ($cart as $id => $details) {
            $buku = \App\Models\KatalogBuku::find($id);',
    'p_start("Loop 1: Validate Cart"); foreach ($cart as $id => $details) { $buku = \App\Models\KatalogBuku::find($id);',
    $content
);
$content = str_replace(
    '    $checkoutCart[$id] = $details;
            }
        }',
    '    $checkoutCart[$id] = $details; } } p_end("Loop 1: Validate Cart");',
    $content
);

$content = str_replace(
    '\Illuminate\Support\Facades\DB::transaction(function () use ($checkoutCart, $user, $kode_tracking) {',
    'p_start("DB Transaction: Process Order"); \Illuminate\Support\Facades\DB::transaction(function () use ($checkoutCart, $user, $kode_tracking) {',
    $content
);
$content = str_replace(
    '        });',
    '        }); p_end("DB Transaction: Process Order");',
    $content
);

$content = str_replace(
    '// Re-fetch harga',
    'p_start("Loop 2: Calculate Total"); // Re-fetch harga',
    $content
);
$content = str_replace(
    '            }

            $transaksi',
    '            } p_end("Loop 2: Calculate Total"); $transaksi',
    $content
);

$content = str_replace(
    '            foreach ($checkoutCart as $id => $details) {
                $buku = \App\Models\KatalogBuku::where(\'id\', $id)->lockForUpdate()->first();',
    'p_start("Loop 3: Insert Details & Update Stock"); foreach ($checkoutCart as $id => $details) { $buku = \App\Models\KatalogBuku::where(\'id\', $id)->lockForUpdate()->first();',
    $content
);
$content = str_replace(
    '                    $buku->update($updateData);
                }
            }',
    '                    $buku->update($updateData); } } p_end("Loop 3: Insert Details & Update Stock");',
    $content
);

// Upload Proof (Payment)
$content = str_replace(
    'public function uploadProof(Request $request)
    {',
    'public function uploadProof(Request $request) { p_start("Checkout Controller: Upload Proof");',
    $content
);
$content = str_replace(
    '        return redirect()->route(\'success\')->with(\'kode_tracking\', $kode_tracking);
    }',
    'p_end("Checkout Controller: Upload Proof"); return redirect()->route(\'success\')->with(\'kode_tracking\', $kode_tracking); }',
    $content
);
$content = str_replace(
    '                // Kompresi: scale proportional max lebar 800px & konversi ke WebP kualitas 75%',
    'p_start("Image Processing & Storage"); // Kompresi: scale proportional max lebar 800px & konversi ke WebP kualitas 75%',
    $content
);
$content = str_replace(
    '                $transaksi->update([',
    'p_end("Image Processing & Storage"); p_start("Update Transaction"); $transaksi->update([',
    $content
);
$content = str_replace(
    '                ]);
            } catch (\Exception $e) {',
    '                ]); p_end("Update Transaction"); } catch (\Exception $e) {',
    $content
);
$content = str_replace(
    '            // Create notification',
    'p_start("Create Notification & Email"); // Create notification',
    $content
);
$content = str_replace(
    '                \'is_read\' => false,
            ]);
        }',
    '                \'is_read\' => false, ]); p_end("Create Notification & Email"); }',
    $content
);

file_put_contents($checkoutControllerPath, $content);

// Cart Controller
$cartControllerPath = 'd:/WILMARBOOKS/app/Http/Controllers/CartController.php';
$content = file_get_contents($cartControllerPath);
$content = str_replace(
    'class CartController extends Controller',
    'if (!function_exists("p_start")) { function p_start($n) { if (function_exists("profiler_step_start")) profiler_step_start($n); } } if (!function_exists("p_end")) { function p_end($n) { if (function_exists("profiler_step_end")) profiler_step_end($n); } } class CartController extends Controller',
    $content
);

$content = str_replace('public function add(Request $request, $id)', 'public function add(Request $request, $id) { p_start("Cart Controller: Add");', $content);
$content = preg_replace('/(return redirect\(\)->back\(\)->with\([^\)]+\);\s*})/', 'p_end("Cart Controller: Add"); $1', $content);
$content = preg_replace('/(return response\(\)->json\([^\)]+\);\s*})/', 'p_end("Cart Controller: Add"); $1', $content);

file_put_contents($cartControllerPath, $content);

echo "Injected!";
