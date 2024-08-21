<?php

namespace App\Http\Controllers;

use App\Services\Actives\GetActiveByNameOrTicker;
use App\Services\Actives\GetAllActives;

class ActiveController extends Controller
{
    public function paginate(GetAllActives $service)
    {
        return $service->execute();
    }

    public function getActiveByNameOrTicker(GetActiveByNameOrTicker $service, string $nameOrTicker)
    {
        return $service->execute($nameOrTicker);
    }
}
