<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    use HasUuids;
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'id',
        'name',
        'slug',
        'description',
        'avatar',
        'address',
        'phone',
        'delay',
        'delay_service',
        'sort',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function systems(): HasMany
    {
        return $this->hasMany(System::class)->orderBy('sort');
    }

    public function devices(): HasManyThrough
    {
        return $this->hasManyThrough(Device::class, System::class)->orderBy('sort');
    }

    public function managers(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function technicians()
    {
        return $this->hasManyDeep(User::class, [System::class, 'system_user'])->distinct();
    }
}
