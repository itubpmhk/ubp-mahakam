<?php

namespace App\Models;

use App\Support\Youtube;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class PostMedia extends Model
{
    protected $table = 'post_media';

    protected $fillable = ['post_id', 'type', 'path', 'url', 'caption', 'sort_order'];

    public const TYPES = [
        'image' => 'Gambar (upload)',
        'video' => 'Video (upload)',
        'youtube' => 'Video YouTube (link)',
        'link' => 'Tautan / link',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function fileUrl(): ?string
    {
        return $this->path ? Storage::disk('public')->url($this->path) : null;
    }

    public function youtubeId(): ?string
    {
        return $this->type === 'youtube' ? Youtube::id($this->url) : null;
    }

    /** Host name shown on link cards, e.g. "www.pln.co.id". */
    public function host(): string
    {
        return (string) (parse_url((string) $this->url, PHP_URL_HOST) ?: $this->url);
    }
}
