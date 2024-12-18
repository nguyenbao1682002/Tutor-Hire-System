<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'phu_huynh_id',
        'gia_su_id',
        'rating'
    ];

    public function giaSu()
    {
        return $this->belongsTo(GiaSu::class, 'gia_su_id');
    }

    public function phuHuynh()
    {
        return $this->belongsTo(PhuHuynh::class, 'phu_huynh_id');
    }

}
