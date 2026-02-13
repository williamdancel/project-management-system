<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiRequestLog extends Model
{
    protected $fillable = [
        'user_id',
        'method',
        'endpoint',
        'status_code',
        'requested_at',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'status_code' => 'integer',
        'requested_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
