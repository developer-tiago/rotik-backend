<?php

namespace App\Services\Evolution;

use App\Models\EvolutionOfHeritage;
use App\Models\User;
use App\Models\Wallet;

class RegisterEvolution
{
    public function __construct(
        protected Wallet $wallet,
        protected EvolutionOfHeritage $evolutionOfHeritage,
        protected User $user
    )
    {
    }

    public function execute()
    {
        $usersIds = $this->user->pluck('id');

        foreach ($usersIds as $userId) {
            $totalValueActions = $this->wallet
                ->whereHas('active', function ($query) {
                    $query->where('type', 'actions');
                })
                ->with(['active' => function ($query) {
                    $query->where('type', 'actions');
                }])
                ->where('user_id', $userId)
                ->sum('cash_value');

            $this->evolutionOfHeritage->create([
                'user_id' => $userId,
                'type_of_active' => 'actions',
                'value' => $totalValueActions
            ]);

            $totalValueFunds = $this->wallet
                ->whereHas('active', function ($query) {
                    $query->where('type', 'real_estate_funds');
                })
                ->with(['active' => function ($query) {
                    $query->where('type', 'real_estate_funds');
                }])
                ->where('user_id', $userId)
                ->sum('cash_value');

            $this->evolutionOfHeritage->create([
                'user_id' => $userId,
                'type_of_active' => 'real_estate_funds',
                'value' => $totalValueFunds
            ]);
        }
    }
}
