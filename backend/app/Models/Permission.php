<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Appends;

#[Appends(['name'])]
class Permission extends Model
{
    protected $guarded = [];

    public function getNameAttribute(): object
    {
        return (object) [
            'ar' => $this->name_ar,
            'en' => $this->name_en,
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
