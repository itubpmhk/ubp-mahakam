<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Commitment extends Model
{
    protected $fillable = ['icon', 'title', 'description', 'is_featured', 'is_active', 'sort_order'];

    protected function casts(): array
    {
        return ['is_featured' => 'boolean', 'is_active' => 'boolean', 'sort_order' => 'integer'];
    }

    public function scopeOrdered(Builder $q): Builder
    {
        return $q->orderBy('sort_order')->orderBy('id');
    }

    /** Icon keys an admin can choose from (rendered by partials/icon.blade.php). */
    public const ICONS = [
        'bolt' => 'Petir / Energi',
        'shield' => 'Perisai / K3',
        'leaf' => 'Daun / Lingkungan',
        'people' => 'Orang / Masyarakat',
        'chart' => 'Grafik / Digital',
        'gear' => 'Roda gigi / Pemeliharaan',
        'star' => 'Bintang / Prestasi',
        'globe' => 'Globe / Transisi energi',
    ];
}
