<?php

namespace App\Services\Actives;

use App\Models\Active;

class GetActiveByNameOrTicker
{
    public function __construct(protected Active $active)
    {
    }

    public function execute($nameOrTicker)
    {
        $active = $this->active
            ->where('name', 'like', '%' . $nameOrTicker . '%')
            ->orWhere('ticker', 'like', '%' . $nameOrTicker . '%')
            ->get();

        return $active;
    }
}
