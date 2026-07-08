<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\KatalogBuku;

require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$GLOBALS['deep_profile_data'] = [];

if (!function_exists('profiler_step_start')) {
    function profiler_step_start($name) {
        $GLOBALS['deep_profile_starts'][$name] = microtime(true);
    }
    function profiler_step_end($name) {
        if (isset($GLOBALS['deep_profile_starts'][$name])) {
            $time = (microtime(true) - $GLOBALS['deep_profile_starts'][$name]) * 1000;
            $GLOBALS['deep_profile_data'][] = ['type' => 'Step', 'name' => $name, 'time' => $time];
        }
    }
}

function runDeepProfileRoute($app, $kernel, $method, $uri, $user = null, $data = [], $files = []) {
    $GLOBALS['deep_profile_data'] = [];
    
    // Register event listeners
    Event::listen(\Illuminate\Database\Events\QueryExecuted::class, function ($query) {
        $GLOBALS['deep_profile_data'][] = ['type' => 'Query', 'name' => substr($query->sql, 0, 50).'...', 'time' => $query->time];
    });
    Event::listen('eloquent.*', function ($event, $models) {
        // Eloquent events don't have built-in timing, so we just log the event fired
        // Observers are hooked into these eloquent events.
        $GLOBALS['deep_profile_data'][] = ['type' => 'Model Event', 'name' => $event, 'time' => 0.1]; // approximate
    });
    Event::listen(\Illuminate\Cache\Events\CacheHit::class, function ($event) {
        $GLOBALS['deep_profile_data'][] = ['type' => 'Cache Hit', 'name' => $event->key, 'time' => 0.05];
    });
    Event::listen(\Illuminate\Cache\Events\CacheMissed::class, function ($event) {
        $GLOBALS['deep_profile_data'][] = ['type' => 'Cache Miss', 'name' => $event->key, 'time' => 0.05];
    });
    Event::listen(\Illuminate\Mail\Events\MessageSending::class, function ($event) {
        profiler_step_start('Mail Sending');
    });
    Event::listen(\Illuminate\Mail\Events\MessageSent::class, function ($event) {
        profiler_step_end('Mail Sending');
    });

    $request = Request::create($uri, $method, $data);
    if (!empty($files)) {
        $request->files->add($files);
    }
    if ($user) {
        $app['auth']->guard()->setUser($user);
    }
    
    $startTime = microtime(true);
    
    try {
        profiler_step_start('Kernel Handle');
        $response = $kernel->handle($request);
        profiler_step_end('Kernel Handle');
        if ($response->getStatusCode() !== 200 && $response->getStatusCode() !== 302) {
            echo "Error for $uri: " . $response->getStatusCode() . " - " . substr($response->getContent(), 0, 200) . "\n";
        }
    } catch (\Exception $e) {
        $GLOBALS['deep_profile_data'][] = ['type' => 'Error', 'name' => $e->getMessage(), 'time' => 0];
    }
    
    $totalTime = (microtime(true) - $startTime) * 1000;
    
    return [
        'uri' => "$method $uri",
        'total_time' => $totalTime,
        'steps' => $GLOBALS['deep_profile_data']
    ];
}

// Boot the framework by handling a dummy request
$dummyRequest = Request::create('/', 'GET');
$kernel->handle($dummyRequest);

$user = User::where('role', '!=', 'admin')->first();
$buku = KatalogBuku::first();

$results = [];

// 1. Add Cart
$results[] = runDeepProfileRoute($app, $kernel, 'POST', '/cart/add/' . $buku->id, $user, ['qty' => 1]);

// 2. Update Quantity
$results[] = runDeepProfileRoute($app, $kernel, 'POST', '/cart/update', $user, ['id' => $buku->id, 'qty' => 2]);

// 3. Checkout
$results[] = runDeepProfileRoute($app, $kernel, 'POST', '/checkout', $user, [
    'type' => 'cart',
    'tipe_donatur' => 'publik',
    'nama_lengkap' => 'Test User',
    'email' => 'test@example.com'
]);

// 4. Payment
// Find checkout transaction
$transaksi = \App\Models\TransaksiCheckout::where('user_id', $user->id)->latest()->first();
if ($transaksi) {
    // Create a dummy image
    $tempFile = sys_get_temp_dir() . '/dummy.jpg';
    imagejpeg(imagecreatetruecolor(100, 100), $tempFile);
    $file = new \Illuminate\Http\UploadedFile(
        $tempFile, 'dummy.jpg', 'image/jpeg', null, true
    );
    $results[] = runDeepProfileRoute($app, $kernel, 'POST', '/payment/upload', $user, [
        'kode_tracking' => $transaksi->kode_tracking,
    ], ['bukti_pembayaran' => $file]);
}

// 5. Remove Cart
$results[] = runDeepProfileRoute($app, $kernel, 'POST', '/cart/remove', $user, ['id' => $buku->id]);

file_put_contents('d:/WILMARBOOKS/profile_output.json', json_encode($results, JSON_PRETTY_PRINT | JSON_INVALID_UTF8_IGNORE));
echo "Done.";
