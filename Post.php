<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'gia_su_id',
        'user_id',
        'subject_id',
        'title',
        'description',
        'fee',
        'image',
        'slug',
        'status',
        'views'
    ];

    public function giaSu()
    {
        return $this->belongsTo(GiaSu::class, 'gia_su_id');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class, 'subject_id');
    }
}
