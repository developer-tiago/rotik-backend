<?php

namespace App\Services\Actives;

use App\Models\Active;

class GetAllActives
{
    public function __construct(protected Active $active)
    {
    }

    public function execute()
    {
        $actives = $this->active
            ->orderBy('name', 'asc')
            ->paginate(10);

        return $actives;
    }
}
