<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\UserExercise;

class UserExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('user_exercise')->truncate();

        // Mengambil seluruh data dari table users
        $users = DB::connection('be_brainy')->table('users')->get();

        // Inisialisasi array untuk menyimpan data hasil penggabungan
        $mergedData = [];

        foreach ($users as $user) {
            // Mengambil data dari table exercise_histories
            $exerciseHistories = DB::connection('be_brainy')
                ->table('exercise_histories')
                ->where('user_id', $user->id)
                ->get();

            // Grouping data dari table exerise_histories berdasarkan nama
            $groupedHistories = $exerciseHistories->groupBy('name');

            // Mengolah data untuk setiap grup
            foreach ($groupedHistories as $group) {
                // Menghitung jumlah item dalam group
                $generateCount = $group->count();
                $generateCountFormatted = "{$generateCount}/20";

                // Membuat struktur data sementara untuk hasil penggabungan
                $tempData = [
                    'user_name' => $user->name,
                    'user_id' => $generateCountFormatted,
                ];

                // Menambahkan data ke dalam array hasil penggabungan
                $mergedData[] = $tempData;
            }
        }

        // Proses penggabungan dan format data
        $result = $this->mergeAndFormatData($mergedData);

        // Simpan data ke dalam database
        foreach ($result as $data) {
            UserExercise::create($data);
        }
    }
    // Logic untuk merge generate count
    private function mergeAndFormatData(array $data): array
    {
        $result = [];

        foreach ($data as $item) {
            $user_name = $item['user_name'];
            $generate_count = $item['user_id'];

            // Mengecek apakah data dengan user_name tersebut sudah ada
            $existingData = array_filter($result, function ($data) use ($user_name) {
                return $data['user_name'] === $user_name;
            });

            if (empty($existingData)) {
                // Jika tidak ada, tambahkan data baru
                $result[] = [
                    'user_name' => $user_name,
                    'user_id' => $generate_count,
                ];
            } else {
                // Jika sudah ada, gabungkan dengan data yang sudah ada
                foreach ($result as &$data) {
                    if ($data['user_name'] === $user_name) {
                        $data['user_id'] = $this->sumGenerateCounts($data['user_id'], $generate_count);
                    }
                }
            }
        }

        return $result;
    }

    // Merge generate count per nama user dengan asumsi batas generate adalah 20
    private function sumGenerateCounts(string $count1, string $count2): string
    {
        list($value1, $total1) = explode('/', $count1);
        list($value2, $total2) = explode('/', $count2);

        $sumValue = (int)$value1 + (int)$value2;
        $sumTotal = min((int)$total1 + (int)$total2, 20);

        return "{$sumValue}/{$sumTotal}";
    }
}
