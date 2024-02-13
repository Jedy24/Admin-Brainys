<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\UserMaterial;
use App\Models\UserBrainys;

class UserMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Mengambil seluruh data dari table users
        $users = DB::connection('be_brainy')->table('users')->get();

        foreach ($users as $user) {
            // Mengambil data dari table material_histories
            $materialHistories = DB::connection('be_brainy')
                ->table('material_histories')
                ->where('user_id', $user->id)
                ->get();

            // Grouping data dari table material_histories berdasarkan nama
            $groupedHistories = $materialHistories->groupBy('name');

            foreach ($groupedHistories as $group) {
                // Mengambil item pertama dalam grup untuk mendapatkan atribut umum
                $firstItem = $group->first();

                // Menghitung jumlah item dalam group
                $generateCount = $group->count();
                $generateCountFormatted = "{$generateCount}/20";

                // Create atau update user_material data input berupa id, nama user, nama generate, dan jumlah generate
                $userMaterial = UserMaterial::updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'user_name' => $user->name,
                        'name' => $firstItem->name,
                        'user_id' => $generateCountFormatted,
                    ]
                );
            }
        }
    }
}
