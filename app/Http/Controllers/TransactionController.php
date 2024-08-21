<?php

namespace App\Http\Controllers;

use App\Services\Transactions\CreateTransaction;
use App\Services\Transactions\GetAllTransactions;
use App\Services\Transactions\GetByCategory;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index(GetAllTransactions $service, $userId)
    {
        return $service->execute($userId);
    }

    public function getByCategory(Request $request, GetByCategory $service, $userId)
    {
        return $service->execute($request, $userId);
    }

    public function makeTransaction(Request $request, CreateTransaction $service)
    {
        return $service->execute($request->all());
    }
}
