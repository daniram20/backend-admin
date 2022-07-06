<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ListAplikasi extends Model
{
    use HasFactory;
    protected $table = 'list_aplikasi';
    protected $fillable = [
        'nama', 'url', 'foto', 'status'
    ];
}
