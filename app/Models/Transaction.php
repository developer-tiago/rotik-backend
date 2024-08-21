<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'active_id',
        'user_id',
        'transaction_type',
        'amount'
    ];

    public function active()
    {
        return $this->belongsTo(Active::class);
    }
}
