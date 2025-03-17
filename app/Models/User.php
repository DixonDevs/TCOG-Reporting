<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'church_id', 'district_id', 'state_id'];

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function church()
    {
        return $this->belongsTo(Church::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }

    // Helper methods to check permissions
    public function isAdmin()
    {
        return $this->roles()->where('role', 'admin')->exists();
    }

    public function isPastor()
    {
        return $this->roles()->where('role', 'pastor')->exists();
    }

    public function isOverseer()
    {
        return $this->roles()->where('role', 'district_overseer')->exists();
    }

    public function canViewReports()
    {
        return $this->isAdmin() || $this->isPastor() || $this->isOverseer();
    }

    // Check if the user can assign roles
    public function canAssignRoles()
    {
        return $this->isAdmin() || $this->isStateOverseer();
    }

    public function isStateOverseer()
    {
        return $this->roles()->where('role', 'state_overseer')->exists();
    }

    public function isGeneralOverseer()
    {
        return $this->roles()->where('role', 'general_overseer')->exists();
    }
}
