<?php

namespace App\Services\Transactions;

use App\Models\Transaction;

class GetAllTransactions
{
    public function __construct(protected Transaction $transaction)
    {
    }

    public function execute($userId)
    {
        $transactions = $this->transaction
            ->with('active')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();

        return $transactions;
    }
}
