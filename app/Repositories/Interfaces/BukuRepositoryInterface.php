<?php

namespace App\Repositories\Interfaces;

use Illuminate\Http\Request;

interface BukuRepositoryInterface
{
    public function getBukuWelcome();
    public function getBukuDashboard();
    public function getBukuBerdasarkanFilter(Request $request);
    public function getBukuById($id);
    public function getBukuTerkait($kategori, $id_sekarang);
}
