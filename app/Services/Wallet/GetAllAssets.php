<?php

namespace App\Services\Wallet;

use App\Models\Wallet;
use Carbon\Carbon;

class GetAllAssets
{
    public function __construct(protected Wallet $wallet)
    {
    }

    public function execute($userId)
    {
        $allActiveByUser = $this->wallet
            ->with('active')
            ->where('user_id', $userId)
            ->get();


        $allActionsByUser = $this->wallet
            ->whereHas('active', function ($query) {
                $query->where('type', 'actions');
            })
            ->with(['active' => function ($query) {
                $query->where('type', 'actions');
            }])
            ->where('user_id', $userId)
            ->get();


        $allRealEstateFundsByYser = $this->wallet
        ->whereHas('active', function ($query) {
            $query->where('type', 'real_estate_funds');
        })
        ->with(['active' => function ($query) {
            $query->where('type', 'real_estate_funds');
        }])
        ->where('user_id', $userId)
        ->get();

        $lastSevenDays = $this->wallet
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('updated_at', 'asc')
            ->get();

        $sumsByDate = [];

        foreach ($lastSevenDays as $item) {
            $date = substr($item['updated_at'], 0, 10);

            if (isset($sumsByDate[$date])) {
                $sumsByDate[$date] += floatval($item['cash_value']);
            } else {
                $sumsByDate[$date] = floatval($item['cash_value']);
            }
        }

        $filter = $this->wallet
            ->whereHas('active', function ($query) {
                $query->where('type', 'actions');
            })
            ->with(['active' => function ($query) {
                $query->where('type', 'actions');
            }])
            ->where('updated_at', '>=', Carbon::now()->subDays(7))
            ->orderBy('updated_at', 'asc')
            ->get();

        return [
            'all' => $allActiveByUser,
            'actions' => $allActionsByUser,
            'real_estate_funds' => $allRealEstateFundsByYser,
            'last_seven_days' => $sumsByDate,
            'teste' => $filter
        ];
    }
}
