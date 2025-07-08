<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\LazyCollection;

class GuruFromCsvSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LazyCollection::make(function () {
            $path = public_path("csv/data_guru.csv");

            $handle = fopen($path, 'r');

            while (($row = fgetcsv($handle, 1000, ',')) !== false) {
                yield $row;
            }
            fclose($handle);
        })
        ->skip(1)
        ->chunk(1000)
        ->each(function (LazyCollection $chunk) {
            $records = $chunk->map(function ($row) {

                return [
                    'name' => $row[0] ?? null,
                    'email' => $row[1] ?? null,
                    'nip' => null,
                    'password' => Hash::make('rapatguru'),
                    'role' => 'guru',
                ];
            })->toArray();

            User::insert($records);
        });
    }
}