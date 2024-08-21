<?php

namespace App\Services\Transactions;

use App\Models\Transaction;
use App\Models\Wallet;
use Illuminate\Support\Facades\DB;

class CreateTransaction
{
    public function __construct(
        protected Transaction $transaction,
        protected Wallet $wallet
    )
    {
    }

    public function execute($requestParams)
    {
        try {
            DB::beginTransaction();
            $this->transaction->create([
                'active_id' => $requestParams['active_id'],
                'user_id' => $requestParams['user_id'],
                'transaction_type' => $requestParams['transaction_type'],
                'amount' => $requestParams['amount']
            ]);

            if ($requestParams['transaction_type'] === 'buy') {
                $wallet = $this->wallet
                    ->where('user_id', $requestParams['user_id'])
                    ->where('active_id', $requestParams['active_id'])
                    ->first();

                if ($wallet) {
                    $wallet->amount += $requestParams['amount'];
                    $wallet->cash_value += $requestParams['amount'] * $requestParams['price'];
                    $wallet->save();
                } else {
                    $this->wallet->create([
                        'user_id' => $requestParams['user_id'],
                        'active_id' => $requestParams['active_id'],
                        'amount' => $requestParams['amount'],
                        'cash_value' => $requestParams['amount'] * $requestParams['price']
                    ]);
                }
            } else {
                $wallet = $this->wallet
                    ->where('user_id', $requestParams['user_id'])
                    ->where('active_id', $requestParams['active_id'])
                    ->first();

                if ($wallet) {
                    if ($requestParams['amount'] === $wallet->amount) {
                        $wallet->delete();

                    } else {
                        $wallet->amount -= $requestParams['amount'];
                        $wallet->cash_value -= $requestParams['amount'] * $requestParams['price'];
                        $wallet->save();
                    }
                }
            }

            $walletByUserId = $this->wallet->where('user_id', $requestParams['user_id'])->get();

            DB::commit();
            return $walletByUserId;
        } catch (\Exception $e) {
            DB::rollBack();
            return ($e->getMessage());
        }
    }
}
