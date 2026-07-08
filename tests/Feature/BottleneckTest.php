<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class BottleneckTest extends TestCase
{
    public function test_home_page()
    {
        DB::enableQueryLog();
        $start = microtime(true);
        $response = $this->get('/');
        $time = (microtime(true) - $start) * 1000;
        
        $queries = DB::getQueryLog();
        
        $kategoriCount = 0;
        $penerbitCount = 0;
        $totalDbTime = 0;
        
        foreach ($queries as $q) {
            $totalDbTime += $q['time'];
            if (strpos($q['query'], 'kategoris') !== false) $kategoriCount++;
            if (strpos($q['query'], 'penerbits') !== false) $penerbitCount++;
        }
        
        $html = $response->getContent();
        $imgCount = substr_count(strtolower($html), '<img');
        $jsCount = substr_count(strtolower($html), '<script');
        $cssCount = substr_count(strtolower($html), '<link rel="stylesheet"');
        
        $out = "\n\n=== HOME PAGE PROFILING ===\n";
        $out .= "Total Response Time: {$time} ms\n";
        $out .= "Total Queries: " . count($queries) . "\n";
        $out .= "Total DB Time: {$totalDbTime} ms\n";
        $out .= "Kategori::all() called: {$kategoriCount} times\n";
        $out .= "Penerbit::all() called: {$penerbitCount} times\n";
        $out .= "Response Size: " . strlen($html) . " bytes\n";
        $out .= "HTML Images: {$imgCount}\n";
        $out .= "HTML JS: {$jsCount}\n";
        $out .= "HTML CSS: {$cssCount}\n";
        
        file_put_contents(base_path('bottleneck_report.txt'), $out);
        
        $this->assertTrue(true);
    }
}
