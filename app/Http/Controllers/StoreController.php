<?php

namespace App\Http\Controllers;

use App\Services\SwitchStoreService;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    
    public function __construct(
        public SwitchStoreService $switchStoreService
    )
    {
    }

    public function switchStore($storeId)
    {
        $store = $this->switchStoreService->switchStore($storeId);
        return redirect()->back()
        ->with([
            'success' => ' müzesine başarıyla geçiş yapıldı.',
            'switchedStore' => $store->name,
        ]);
    }
}
