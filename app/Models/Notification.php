<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'answer_id',
        'is_seen',
        'created_at'
    ];

    public function answer() {
        return $this->belongsTo(Answer::class)->orderByDesc('updated_at');
    }
}
