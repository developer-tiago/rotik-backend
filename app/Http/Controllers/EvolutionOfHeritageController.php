<?php

namespace App\Http\Controllers;



use App\Services\Evolution\GetEvolutionByUser;

class EvolutionOfHeritageController extends Controller
{
    public function getEvolutionByUser(GetEvolutionByUser $service, $userId)
    {
        return $service->execute($userId);
    }
}
