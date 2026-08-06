<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(
        protected DashboardService $service
    ) {
    }

    public function index()
    {
        return view('dashboard.index', [
            'data' => $this->service->getData()
        ]);
    }
}
