<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class PortalApp extends Model
{
    protected $fillable = ['name', 'category', 'description', 'url', 'thumbnail_path', 'open_new_tab', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['open_new_tab' => 'boolean', 'is_active' => 'boolean', 'sort_order' => 'integer'];
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }

    public function thumbnailUrl(): ?string
    {
        return $this->thumbnail_path ? Storage::disk('public')->url($this->thumbnail_path) : null;
    }
}
