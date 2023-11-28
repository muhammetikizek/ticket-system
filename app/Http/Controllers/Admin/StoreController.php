<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Store;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\SwitchStoreService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Admin\StoreCreateRequest;
use App\Http\Requests\Admin\StoreUpdateRequest;

class StoreController extends Controller
{

    public function index()
    {
        return view('admin.store.index', [
            'stores' => Store::orderBy('updated_at')->get(),
        ]);
    }

    public function create()
    {
        return view('admin.store.create');
    }

    public function store(StoreCreateRequest $request)
    {
        Store::create($request->validated());
        return redirect()
            ->route('admin.store.index')
            ->with('success', 'Created Successfully');
    }

    public function edit(int $id)
    {
        return view('admin.store.edit', [
            'store' => Store::findOrFail($id),
        ]);
    }

    public function update(StoreUpdateRequest $request, int $storeId)
    {
        Store::find($storeId)->update($request->validated());
        return redirect()->route('admin.store.index')->with('success', 'Updated Successfully');
    }

    public function switchStore(int $storeId)
    {
        $store = Store::find($storeId);
        session()->put('adminStoreId', $store->id);

        $user = User::find(Auth::guard('admin')->id());
        $user->last_used_store_id = $store->id;
        $user->save();

        return redirect()
            ->back()
            ->with('success', 'Switched Successfully');
    }
}
