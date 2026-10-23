<?php

namespace Database\Seeders;

use App\Models\Commitment;
use App\Models\PortalApp;
use App\Models\Post;
use App\Models\Setting;
use Illuminate\Database\Seeder;

/** Default landing page content, commitments, a sample portal app and a sample news post. */
class ContentSeeder extends Seeder
{
    public function run(): void
    {
        // settings: only fill keys that do not exist yet (re-running never overwrites admin edits)
        $existing = Setting::query()->pluck('key')->all();
        $missing = array_diff_key(Setting::defaults(), array_flip($existing));
        if ($missing) {
            Setting::putMany($missing);
        }

        if (Commitment::query()->doesntExist()) {
            $items = [
                ['bolt', 'Keandalan pasokan', 'Pemeliharaan terencana dan kesiapan operasi menjadi kunci agar listrik Sistem Mahakam tetap mengalir untuk rumah, industri, dan layanan publik.', true],
                ['shield', 'Keselamatan kerja', 'Budaya K3 di setiap pekerjaan, menuju target zero accident.', false],
                ['leaf', 'Ramah lingkungan', 'Pengelolaan emisi dan limbah serta program konservasi di sekitar unit.', false],
                ['people', 'Tumbuh bersama masyarakat', 'Program TJSL untuk pendidikan, UMKM, dan kesehatan warga sekitar.', false],
                ['chart', 'Digitalisasi operasi', 'Pemantauan kinerja unit berbasis data untuk keputusan yang lebih cepat.', false],
            ];
            foreach ($items as $i => [$icon, $title, $desc, $featured]) {
                Commitment::query()->create([
                    'icon' => $icon, 'title' => $title, 'description' => $desc,
                    'is_featured' => $featured, 'is_active' => true, 'sort_order' => $i + 1,
                ]);
            }
        }

        if (PortalApp::query()->doesntExist()) {
            PortalApp::query()->create([
                'name' => 'Contoh Aplikasi',
                'category' => 'Umum',
                'description' => 'Ganti atau hapus contoh ini dari panel admin, lalu tambahkan aplikasi milik unit.',
                'url' => 'https://www.plnindonesiapower.co.id',
                'open_new_tab' => true,
                'is_active' => true,
                'sort_order' => 1,
            ]);
        }

        if (Post::query()->doesntExist()) {
            Post::query()->create([
                'title' => 'Selamat datang di website UBP Mahakam',
                'slug' => 'selamat-datang-di-website-ubp-mahakam',
                'excerpt' => 'Contoh berita pertama. Ubah atau hapus dari panel admin.',
                'body' => '<div>Ini adalah contoh berita. Buka <strong>Panel Admin → Berita</strong> untuk menulis berita baru lengkap dengan gambar, video, dan tautan.</div>',
                'status' => 'published',
                'published_at' => now(),
            ]);
        }
    }
}
