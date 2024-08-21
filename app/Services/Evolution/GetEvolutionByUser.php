<?php

namespace App\Services\Evolution;

use App\Models\EvolutionOfHeritage;
use Carbon\Carbon;

class GetEvolutionByUser
{
    public function __construct(protected EvolutionOfHeritage $evolution)
    {
    }

    public function execute($userId)
    {
        $evolutionActions = $this->evolution
            ->where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('type_of_active', 'actions')
            ->orderBy('created_at', 'asc')
            ->get(['id', 'value', 'created_at']);

        $evolutionRealEstateFunds = $this->evolution
            ->where('user_id', $userId)
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->where('type_of_active', 'real_estate_funds')
            ->orderBy('created_at', 'asc')
            ->get(['id', 'value', 'created_at']);

        return [
            'actions' => $evolutionActions,
            'real_estate_funds' => $evolutionRealEstateFunds
        ];
    }
}
