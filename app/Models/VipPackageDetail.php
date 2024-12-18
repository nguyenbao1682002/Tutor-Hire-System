<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VipPackageDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'package_type',
        'price',
        'duration_days',
        'post_number',
        'benefits'
    ];
}
