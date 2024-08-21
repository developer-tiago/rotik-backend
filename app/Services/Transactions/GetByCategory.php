<?php

namespace App\Services\Transactions;

use App\Models\Transaction;

class GetByCategory
{
    public function __construct(protected Transaction $transaction)
    {
    }

    public function execute($requestParams, $userId)
    {
        if($requestParams->query('type') === 'category') {
            $category = $requestParams->query('value');

            $transaction = $this->transaction
                ->whereHas('active', function ($query) use ($category) {
                    $query->where('type', $category);
                })
                ->with(['active' => function ($query) use ($category) {
                    $query->where('type', $category);
                }])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $ticker = $requestParams->query('value');
            $transaction = $this->transaction
                ->whereHas('active', function ($query) use ($ticker) {
                    $query->where('ticker','like', '%' . $ticker . '%');
                })
                ->with(['active' => function ($query) use ($ticker) {
                    $query->where('ticker','like', '%' . $ticker . '%');
                }])
                ->where('user_id', $userId)
                ->orderBy('created_at', 'desc')
                ->get();
        }

        return $transaction;
    }
}
