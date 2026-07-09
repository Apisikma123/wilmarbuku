<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\KatalogBuku;
use Illuminate\Support\Facades\Event;
use Illuminate\Http\UploadedFile;

class ProfileTest extends TestCase
{
    public function test_profile_operations()
    {
        $GLOBALS['deep_profile_data'] = [];

        // Global functions defined here
        if (!function_exists('\profiler_step_start')) {
            require_once __DIR__ . '/profiler_helpers.php';
        }


        // Register event listeners
        Event::listen(\Illuminate\Database\Events\QueryExecuted::class, function ($query) {
            $GLOBALS['deep_profile_data'][] = ['type' => 'Query', 'name' => substr($query->sql, 0, 50).'...', 'time' => $query->time];
        });
        Event::listen('eloquent.*', function ($event, $models) {
            $GLOBALS['deep_profile_data'][] = ['type' => 'Model Event', 'name' => $event, 'time' => 0.1];
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

        $user = User::where('role', '!=', 'admin')->first();
        $buku = KatalogBuku::first();

        // 1. Add Cart
        $start = microtime(true);
        $response = $this->actingAs($user)->post('/cart/add/' . $buku->id, ['qty' => 1]);
        echo "Add Cart Redirected to: " . $response->headers->get('Location') . "\n";
        $time = (microtime(true) - $start) * 1000;
        $GLOBALS['deep_profile_data'][] = ['type' => 'Total', 'name' => 'Add Cart', 'time' => $time];

        // 2. Update Quantity
        $start = microtime(true);
        $this->actingAs($user)->post('/cart/update', ['id' => $buku->id, 'qty' => 2]);
        $time = (microtime(true) - $start) * 1000;
        $GLOBALS['deep_profile_data'][] = ['type' => 'Total', 'name' => 'Update Cart', 'time' => $time];

        // 3. Checkout
        $start = microtime(true);
        $this->actingAs($user)->post('/checkout', [
            'type' => 'cart',
            'tipe_donatur' => 'publik',
            'nama_lengkap' => 'Test User',
            'email' => 'test@example.com'
        ]);
        $time = (microtime(true) - $start) * 1000;
        $GLOBALS['deep_profile_data'][] = ['type' => 'Total', 'name' => 'Checkout Process', 'time' => $time];

        // 4. Payment
        $transaksi = \App\Models\TransaksiCheckout::where('user_id', $user->id)->latest()->first();
        if ($transaksi) {
            $file = UploadedFile::fake()->image('bukti.jpg');
            $start = microtime(true);
            $this->actingAs($user)->post('/payment/upload', [
                'kode_tracking' => $transaksi->kode_tracking,
                'bukti_pembayaran' => $file
            ]);
            $time = (microtime(true) - $start) * 1000;
            $GLOBALS['deep_profile_data'][] = ['type' => 'Total', 'name' => 'Payment Upload', 'time' => $time];
        }

        // 5. Remove Cart
        $start = microtime(true);
        $this->actingAs($user)->post('/cart/remove', ['id' => $buku->id]);
        $time = (microtime(true) - $start) * 1000;
        $GLOBALS['deep_profile_data'][] = ['type' => 'Total', 'name' => 'Remove Cart', 'time' => $time];

        // debug removed
        file_put_contents(base_path('profile_output.json'), json_encode($GLOBALS['deep_profile_data'], JSON_PRETTY_PRINT | JSON_INVALID_UTF8_IGNORE));
        
        $this->assertTrue(true);
    }
}
