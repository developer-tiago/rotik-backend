<?php

use Illuminate\Support\Facades\App;
use App\Services\Evolution\RegisterEvolution;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schedule;

Schedule::call(function () {
    try {
        $registerEvolution = App::make(RegisterEvolution::class);
        $registerEvolution->execute();
        Log::info('Evolution recorded successfully.');
    } catch (\Exception $e) {
        Log::error('Error recording evolution: ' . $e->getMessage(), ['exception' => $e]);
    }
})->dailyAt('19:00')->when(function () {
    return now()->isWeekday();
});
