<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Ambil user pertama sebagai pemilik post
        $user = User::first();

        if (!$user) {
            $this->command->error('Seeder gagal: Tidak ada user di tabel users.');
            return;
        }

        // Buat 10 post dummy
        for ($i = 1; $i <= 10; $i++) {
            $status = $i % 3 === 0 ? 'draft' : 'published';

            Post::create([
                'user_id' => $user->id,
                'title' => 'Contoh Post ke-' . $i,
                'content' => 'Ini adalah konten dari post ke-' . $i . '. ' . Str::random(100),
                'status' => $status,
                'published_at' => $status === 'published' ? Carbon::now()->subDays(rand(0, 10)) : null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Seeder Post berhasil dijalankan.');
    }
}
