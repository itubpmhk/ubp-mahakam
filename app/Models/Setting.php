<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

/**
 * Simple key/value store for everything editable on the landing page.
 * All values are cached together and the cache is cleared on every save.
 */
class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    private const CACHE_KEY = 'site_settings';

    /** All settings as [key => value], merged over the defaults. */
    public static function allCached(): array
    {
        $stored = Cache::rememberForever(self::CACHE_KEY, function () {
            return static::query()->pluck('value', 'key')->all();
        });

        return array_merge(static::defaults(), array_filter($stored, fn ($v) => $v !== null));
    }

    public static function get(string $key, $default = null)
    {
        return static::allCached()[$key] ?? $default;
    }

    /** Save many values at once. */
    public static function putMany(array $values): void
    {
        foreach ($values as $key => $value) {
            static::query()->updateOrCreate(['key' => $key], ['value' => $value]);
        }
        Cache::forget(self::CACHE_KEY);
    }

    /** Default content (also used by the seeder). */
    public static function defaults(): array
    {
        return [
            // hero
            'hero_badge_region' => 'Kalimantan Timur',
            'hero_badge_unit' => 'Unit Bisnis Pembangkitan',
            'hero_status' => 'Beroperasi 24/7',
            'hero_title' => 'Menjaga terang *Benua Etam*, setiap hari.',
            'hero_subtitle' => 'UBP Mahakam mengelola operasi dan pemeliharaan pembangkit listrik yang memasok Sistem Mahakam, untuk Samarinda, Balikpapan, dan sekitarnya.',

            // video
            'video_youtube' => 'https://www.youtube.com/watch?v=JV9OHAZ2jlk',
            'video_label' => 'Video Profil · PLN Indonesia Power',
            'video_title' => 'From Energy, Comes Meaning',

            // strip
            'strip_text' => 'Bagian dari PLN Indonesia Power, subholding pembangkitan PT PLN (Persero)',
            'strip_chips' => 'Samarinda, Balikpapan, Tenggarong, Kutai Kartanegara, Bontang',

            // about
            'about_heading' => 'Unit pembangkitan untuk Sistem Mahakam',
            'about_p1' => 'Berkedudukan di Kalimantan Timur, UBP Mahakam merupakan unit bisnis pembangkitan PLN Indonesia Power yang bertanggung jawab atas operasi dan pemeliharaan sejumlah pembangkit di wilayah Mahakam.',
            'about_p2' => 'Kami bekerja agar setiap unit siap memasok listrik kapan pun dibutuhkan, dengan mengutamakan keselamatan kerja, efisiensi, dan kepedulian terhadap lingkungan sekitar.',
            // about page (/tentang)
            'about_page_title' => 'Mengenal UBP Mahakam',
            'about_page_intro' => 'Unit bisnis pembangkitan PLN Indonesia Power yang menjaga pasokan listrik Sistem Mahakam, Kalimantan Timur.',
            'about_vision' => '[Isi visi resmi unit / perusahaan]',
            'about_mission' => "[Misi 1]\n[Misi 2]\n[Misi 3]",
            'about_history' => '[Ceritakan secara singkat sejarah berdirinya UBP Mahakam: kapan dibentuk, perubahan nama/organisasi, dan perkembangan unit pembangkitnya.]',
            'about_timeline' => "[Tahun] | [Peristiwa penting pertama]\n[Tahun] | [Peristiwa penting berikutnya]\n[Tahun] | [Peristiwa penting terbaru]",
            'about_units' => "PLTGU Tanjung Batu | Pembangkit listrik tenaga gas dan uap\nPLTG Sambera | Pembangkit listrik tenaga gas\n[Nama unit lain] | [Keterangan singkat]",

            'stat1_label' => 'Kapasitas terpasang', 'stat1_value' => '— MW',
            'stat2_label' => 'Unit pembangkit', 'stat2_value' => '—',
            'stat3_label' => 'Insan UBP Mahakam', 'stat3_value' => '—',
            'stat4_label' => 'Siaga operasi', 'stat4_value' => '24/7',

            // sections
            'commit_heading' => 'Andal hari ini, siap untuk transisi energi',
            'news_heading' => 'Kabar terbaru dari UBP Mahakam',
            'portal_heading' => 'Portal Aplikasi',
            'portal_subtitle' => 'Akses cepat ke aplikasi dan layanan internal UBP Mahakam.',
            'akhlak_heading' => 'Bekerja dengan AKHLAK',
            'akhlak_subtitle' => 'Nilai utama BUMN yang kami jalankan dalam keseharian.',
            'cta_heading' => 'Mari terhubung dengan UBP Mahakam',
            'cta_text' => 'Untuk kemitraan, kunjungan industri, magang, atau keperluan media, tim kami siap membantu.',

            // contact & footer
            'footer_about' => 'Unit Bisnis Pembangkitan, PLN Indonesia Power. Menjaga pasokan listrik Sistem Mahakam, Kalimantan Timur.',
            'contact_address' => "[Alamat kantor UBP Mahakam]\nSamarinda, Kalimantan Timur",
            'contact_phone' => '(0541) ———',
            'contact_email' => 'email@contoh.co.id',
            'contact_hours' => 'Senin – Jumat, 07.30 – 16.00 WITA',
            'social_instagram' => '', 'social_facebook' => '', 'social_youtube' => '', 'social_linkedin' => '', 'social_x' => '',
            'link_whistleblowing' => '', 'link_career' => '',
        ];
    }
}
