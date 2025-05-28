<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    
    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'phone',
        'bio',
        'address',
    ];
    
    /**
     * Получить пользователя, которому принадлежит профиль.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
