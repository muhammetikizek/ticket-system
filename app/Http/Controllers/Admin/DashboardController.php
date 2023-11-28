<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct(
        public DashboardService $dashboardService
    )
    {
    }
    public function index()
    {
        $widget = $this->dashboardService->widget();
        return view('admin.dashboard.index' , compact('widget'));
    }
}
