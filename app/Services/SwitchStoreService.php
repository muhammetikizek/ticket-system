<?php

namespace App\Services;

use App\Models\Store;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SwitchStoreService
{

    private $storeSessionKey = 'storeId';

    private $adminStoreSessionKey = 'adminStoreId';


    public function switchStore(int $storeId)
    {
        $store = Store::find($storeId);
        session()->put('storeId', $store->id);
        $user = User::find(Auth::guard('user')->id());
        $user->last_used_store_id = $store->id;
        $user->save();
        return $store;
    }

    public function getSessionStoreForAdmin()
    {
        return session()->get($this->adminStoreSessionKey);
    }

    public function setSessionStoreForAdmin(int $storeId)
    {
        session()->put($this->adminStoreSessionKey, $storeId);
    }

    public function getSessionStore()
    {
        return session()->get($this->storeSessionKey);
    }

    public function setSessionStore(int $storeId)
    {
        session()->put($this->storeSessionKey, $storeId);
    }
}
