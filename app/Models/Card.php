<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'author',
        'title',
        'type',
        'publisher',
        'year',
        'binding',
        'condition',
        'status',
        'rejection_reason',
    ];

    protected $casts = [
        'type' => 'string',
        'binding' => 'string',
        'condition' => 'string',
        'status' => 'string',
    ];

    /**
     * Get the user that owns the card.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 
