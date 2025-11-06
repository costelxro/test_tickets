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
        'priority',
        'status',
        'processed_at',
        'user_id'
    ];

    protected $casts = [
        'status' => 'boolean',
        'processed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
