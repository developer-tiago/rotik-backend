<?php

namespace App\Services\Wallet;

use App\Models\Wallet;

class GetActivesByUserId
{
    public function __construct(protected Wallet $wallet)
    {
    }

    public function execute($userId)
    {
        $wallet = $this->wallet->where('user_id', $userId)->get();

        return $wallet;
    }
}
