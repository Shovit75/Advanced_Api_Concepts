<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id',
        'multipleimage'
    ];


    protected $casts = [
        'multipleimage' => 'array',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
}
