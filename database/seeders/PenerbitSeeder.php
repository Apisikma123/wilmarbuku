<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenerbitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $penerbits = [
            ['nama_penerbit' => 'Erlangga', 'icon' => 'menu_book'],
            ['nama_penerbit' => 'Gramedia', 'icon' => 'import_contacts'],
            ['nama_penerbit' => 'Andi Publ.', 'icon' => 'school'],
            ['nama_penerbit' => 'Informatika', 'icon' => 'science'],
            ['nama_penerbit' => 'Pearson', 'icon' => 'language'],
            ['nama_penerbit' => 'Wiley', 'icon' => 'workspace_premium'],
        ];

        foreach ($penerbits as $penerbit) {
            \App\Models\Penerbit::updateOrCreate(
                ['nama_penerbit' => $penerbit['nama_penerbit']],
                ['icon' => $penerbit['icon']]
            );
        }
    }
}
