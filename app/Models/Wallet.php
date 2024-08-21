<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'active_id',
        'user_id',
        'amount',
        'cash_value'
    ];

    public function active()
    {
        return $this->belongsTo(Active::class);
    }
}
