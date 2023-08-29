<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class System extends Model
{
    use HasUuids;
    use HasFactory;

    protected $fillable = [
        'project_id',
        'recurring_id',
        'slug',
        'code',
        'name',
        'description',
        'is_service',
        'sort',
        'active',
    ];

    protected $casts = [
        'active'    => 'boolean',
        'is_service'  => 'boolean',
    ];


    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class)->orderBy('sort');
    }

    public function devices(): HasMany
    {
        return $this->hasMany(Device::class)->orderBy('sort');
    }

    public function specifications(): HasManyThrough
    {
        return $this->hasManyThrough(Specification::class, Device::class)->orderBy('sort');
    }

    public function technicians(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
