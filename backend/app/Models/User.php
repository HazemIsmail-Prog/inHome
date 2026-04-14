<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\Appends;
// use Illuminate\Database\Eloquent\Attributes\UnGuarded;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
// #[UnGuarded]
// #[Fillable(['name', 'email', 'password'])]
#[Hidden(['password', 'remember_token'])]
#[Appends(['can', 'name'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasApiTokens;

    protected $guarded = [];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean',
        ];
    }

    public function getCanAttribute(): array
    {
        $permissions = $this->permissions->pluck('name_en')->toArray();
        $roles = $this->roles->load('permissions')->pluck('permissions.*.name_en')->flatten()->toArray();
        // return unique permissions and roles
        return array_unique(array_merge($permissions, $roles));
    }

    public function hasPermission(string $permission): bool
    {
        return in_array($permission, $this->can);
    }

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

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }
}
