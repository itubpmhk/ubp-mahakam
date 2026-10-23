<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Support\Uploads;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', ['s' => Setting::allCached()]);
    }

    public function update(Request $request)
    {
        $keys = array_keys(Setting::defaults());

        $urlKeys = ['video_youtube', 'social_instagram', 'social_facebook', 'social_youtube', 'social_linkedin', 'social_x', 'link_whistleblowing', 'link_career'];

        $rules = [];
        foreach ($keys as $key) {
            $rules[$key] = in_array($key, $urlKeys, true)
                ? ['nullable', 'url:http,https', 'max:2048']
                : ['nullable', 'string', 'max:5000'];
        }
        $rules['contact_email'] = ['nullable', 'email', 'max:255'];
        foreach (['about_history', 'about_timeline', 'about_units', 'about_mission'] as $long) {
            $rules[$long] = ['nullable', 'string', 'max:20000'];
        }

        $rules['video_cover_file'] = ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'];

        $data = $request->validate($rules, [
            'url' => 'Kolom ini harus berupa alamat lengkap yang diawali https://',
            'video_cover_file.max' => 'Gambar sampul video maksimal 5 MB.',
        ]);

        // keep empty fields as empty strings so they can be cleared on purpose
        $values = [];
        foreach ($keys as $key) {
            $values[$key] = $data[$key] ?? '';
        }
        // own cover picture for the video (YouTube only offers a small one for some videos)
        $cover = Setting::get('video_cover');
        if ($request->boolean('remove_video_cover')) {
            Uploads::delete($cover);
            $cover = null;
        }
        $values['video_cover'] = Uploads::replace($request->file('video_cover_file'), $cover, 'site') ?? '';

        Setting::putMany($values);

        return back()->with('success', 'Konten landing page tersimpan.');
    }
}
