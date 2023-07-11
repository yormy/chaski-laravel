<?php

namespace Yormy\ChaskiLaravel\Http\Controllers;

use Illuminate\Routing\Controller;
use Yormy\ChaskiLaravel\Http\Controllers\Resources\LogCollection;
use Yormy\ChaskiLaravel\Repositories\LogRepository;

class LogController extends controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $logRepository = new LogRepository();
        $logs = $logRepository->getAll();

        $logs = (new LogCollection($logs))->toArray(null);

        return response()->json($logs);
    }
}
