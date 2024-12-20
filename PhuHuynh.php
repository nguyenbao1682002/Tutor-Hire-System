<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PhuHuynh extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vip_package',
        'balance',
        'phone_number',
        'address',
        'status',
        'avatar'
    ];

    public function user()
    {
        return $this->belongsTo(User::class, foreignKey: 'user_id');
    }
}
