<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\UserBrainys;
use DB;

class UserBrainysSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hapus semua data dari tabel UserBrainys sebelum penyemaian
        UserBrainys::truncate();

        // Mengambil data dari tabel users dan mengurutkannya secara descending berdasarkan ID
        $users = DB::connection('be_brainy')
            ->table('users')
            ->orderBy('id', 'desc')
            ->get();

        // Menyemaikan data ke tabel UserBrainys
        foreach ($users as $user) {
            UserBrainys::create([
                'name' => $user->name,
                'email' => $user->email,
                'profession' => $user->profession,
                'school_name' => $user->school_name,
            ]);
        }
    }
}
