<?php
// Let's create a route that accepts a POST and validates
use Illuminate\Support\Facades\Route;

Route::post('/test-validation', function (\Illuminate\Http\Request $request) {
    $request->validate([
        'judul' => 'required|string',
    ]);
    return response()->json(['success' => true]);
});
