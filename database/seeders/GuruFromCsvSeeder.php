<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Exception;

class GuruFromCsvSeeder extends Seeder
{
    public function run(): void
    {
        $defaultPassword = Hash::make('rapatguru2025');
        $csvPath = database_path('seeders/csv/EmailGuru.csv');

        if (!file_exists($csvPath)) {
            $this->command->error("File CSV tidak ditemukan di: " . $csvPath);
            return;
        }

        try {
            $fileContent = file_get_contents($csvPath);
            // Deteksi dan hapus karakter BOM (Byte Order Mark
            $bom = pack('H*','EFBBBF');
            $fileContent = preg_replace("/^$bom/", '', $fileContent);
            
            // Buat file sementara di memori untuk dibaca
            $fileHandle = fopen("php://memory", 'r+');
            fwrite($fileHandle, $fileContent);
            rewind($fileHandle);

            // Baca header dari file yang sudah bersih
            $header = fgetcsv($fileHandle, 1000, ",");
            if ($header === false) {
                 $this->command->error("Gagal membaca header. Pastikan file CSV tidak kosong.");
                 fclose($fileHandle);
                 return;
            }
            
            $cleanHeader = array_map('strtolower', array_map('trim', $header));
            $nameIndex = array_search('nama', $cleanHeader);
            $emailIndex = array_search('email', $cleanHeader);

            if ($nameIndex === false || $emailIndex === false) {
                $this->command->error("Header 'nama' dan/atau 'email' tidak ditemukan. Header yang terdeteksi: " . implode(', ', $header));
                fclose($fileHandle);
                return;
            }

            while (($row = fgetcsv($fileHandle, 1000, ",")) !== false) {
                if (empty($row[$nameIndex]) || empty($row[$emailIndex])) continue;
                
                $name = trim($row[$nameIndex]);
                $email = trim($row[$emailIndex]);

                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) continue;

                User::firstOrCreate(
                    ['email' => $email],
                    ['name' => $name, 'password' => $defaultPassword, 'role' => 'guru']
                );
            }

            fclose($fileHandle);

        } catch (Exception $e) {
            $this->command->error("Terjadi error saat memproses file CSV: " . $e->getMessage());
            return;
        }

        $this->command->info('✅ Impor data guru dari CSV berhasil.');

        User::firstOrCreate(
            ['email' => 'admin@rapat.com'],
            ['name' => 'Admin Aplikasi', 'password' => Hash::make('adminrapat'), 'role' => 'admin']
        );
        $this->command->info('✅ Akun admin berhasil dibuat/ditemukan.');
    }
}