<?php

namespace App\Http\Controllers;

use App\Services\Wallet\GetActivesByUserId;
use App\Services\Wallet\GetAllAssets;

class WalletController extends Controller
{
    public function index(GetAllAssets $service, $userId)
    {
        return $service->execute($userId);
    }

    public function getActivesByUserId(GetActivesByUserId $service, $userId)
    {
        return $service->execute($userId);
    }
}
