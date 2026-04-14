<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Appends;

#[Appends(['name'])]
class Role extends Model
{
    protected $guarded = [];

    public function getNameAttribute(): object
    {
        return (object) [
            'ar' => $this->name_ar,
            'en' => $this->name_en,
        ];
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
