<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'phu_huynh_id',
        'gia_su_id',
        'package_type',
        'start_date',
        'end_date',
        'vip_package_id'
    ];
}
