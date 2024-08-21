<?php

namespace App\Services\Users;

use App\Models\User;
use Illuminate\Support\Facades\DB;

class CreateUser
{
    public function __construct(protected User $user)
    {
    }

    public function execute($requestParams)
    {
        try {
            DB::beginTransaction();

            $verifyUserExist = $this->user->where('email', $requestParams->email)->exists();

            if($verifyUserExist){
                return response()->json(['error' => 'Email already exist'], 409);
            }

            $user = $this->user->create([
                'name' => $requestParams->name,
                'email' => $requestParams->email,
                'password' => bcrypt($requestParams->password)
            ]);

            DB::commit();
            return $user;
        } catch (\Exception $e) {
            DB::rollBack();
            return ($e->getMessage());
        }
    }
}

