<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class letter_types extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_code',
        'name_type',
    ];

    public function letters()
    {
        return $this->hasMany(Letter::class, 'letter_type_id');
    }
}
