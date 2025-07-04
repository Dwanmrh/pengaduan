<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'nidn', 'nama', 'email', 'jabatan'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
