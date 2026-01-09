<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sport extends Model
{
    protected $table = 'sports';
    
    // Tambahkan ini agar id tidak auto increment
    public $incrementing = false;
    
    // Tambahkan ini agar id dianggap string
    protected $keyType = 'string';
    
    protected $fillable = [
        'id',
        'name',
        'description',
        'image',
    ];
}