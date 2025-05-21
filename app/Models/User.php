<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     *  Фильтр только активных пользователей
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->whereNotNull('email_verified_at');
    }

    /**
     *  Фильтр по поисковому запросу
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $term  Поисковый запрос
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, string $term): Builder
    {
        return $query->where(function($query) use ($term) {
            $query->where('name', 'LIKE', "%{$term}%")
                  ->orWhere('email', 'LIKE', "%{$term}%");
        });
    }

    /**
     *  Создание пользователя
     *
     * @param  array  $data
     * @return \App\Models\User
     */
    public static function createUser(array $data): self
    {
        return static::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);
    }

    /**
     *  Обновление профиля пользователя
     *
     * @param  array  $data
     * @return bool
     */
    public function updateProfile(array $data): bool
    {
        return $this->update([
            'name' => $data['name'] ?? $this->name,
            'email' => $data['email'] ?? $this->email,
        ]);
    }

    /**
     *  Обновление пароля пользователя
     *
     * @param  string  $password
     * @return bool
     */
    public function updatePassword(string $password): bool
    {
        return $this->update([
            'password' => bcrypt($password)
        ]);
    }

    /**
     *  Подтверждение почты
     *
     * @return bool
     */
    public function verifyEmail(): bool
    {
        return $this->update([
            'email_verified_at' => now(),
        ]);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
