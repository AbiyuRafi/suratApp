<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Letter extends Model
{
    use HasFactory;

    protected $fillable = [
        'letter_type_id',
        'letter_perihal',
        'recipients',
        'content',
        'attachment',
        'notulis',
    ];

    protected $casts = [
        'recipients' => 'array',
    ];

    public function letter_types()
    {
        return $this->belongsTo(Letter_types::class, 'letter_type_id', 'id');
    }
    
    public function user()
    {
        return $this->belongsTo(User::class, 'notulis', 'id');
    }
    public function notulisInfo()
    {
        return $this->belongsTo(User::class, 'notulis', 'id');
    }

    public function result()
    {
        return $this->hasOne(Result::class, 'letter_id', 'id');
    }    

    public function letter_type()
    {
        return $this->hasMany(letter_types::class);
    }
}
