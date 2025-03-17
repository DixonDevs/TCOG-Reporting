<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class State extends Model
{
    protected $fillable = ['name', 'country_id'];

    public function districts(): HasMany
    {
        return $this->hasMany(District::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function churches(): HasMany
    {
        return $this->hasMany(Church::class);
    }

    public function reports(): HasMany
    {
        return $this->hasMany(Report::class);
    }

    public function overseers(): HasMany
    {
        return $this->hasMany(User::class)->whereHas('roles', function ($query) {
            $query->where('name', 'state_overseer');
        });
    }
}
