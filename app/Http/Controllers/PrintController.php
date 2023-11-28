<?php

namespace App\Http\Controllers;

use App\Services\PrintOrderService;
use Illuminate\Http\Request;

class PrintController extends Controller
{

    public function __construct(
        public PrintOrderService $printOrderService,
    )
    {
    }

    public function printOrder(Request $request)
    {
        $response = $this->printOrderService->printOrder($request->orderId);
        return response()->json($response);
    }
}
