<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $table = 'tickets';
    protected $fillable = [
        'subject',
        'content',
        'user_name',
        'user_email',
        'status',
        'created_at'
    ];

    protected $casts = [
        'status' => 'boolean',
        'processed_at' => 'datetime',
    ];
}
