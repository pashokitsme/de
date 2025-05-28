<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    
    /**
     * Атрибуты, которые можно массово назначать.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
    ];
    
    /**
     * Пользователи, принадлежащие роли.
     */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    
    /**
     * Разрешения, принадлежащие роли.
     */
    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }
}
