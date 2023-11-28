<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Finder\Exception\AccessDeniedException;

class CheckStoreAccessForUsers
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::guard('user')->user();
        $storeUser = $this->getStoreUser($user);

        if (! $storeUser)
        {

            return response()->json([
                'error' => 'User does not have access to any store.'
            ], 403);
            //throw new AccessDeniedException('User does not have access to any store.');
        }

        $this->updateUserStoreInfo($user, $storeUser);

        return $next($request);
    }

    private function getStoreUser($user)
    {
        return DB::table('store_users')
            ->where('user_id', $user->id)
            ->first();
    }

    private function updateUserStoreInfo($user, $storeUser)
    {
        session()->put('storeId', $storeUser->store_id);
        $user->update([
            'last_used_store_id' => $storeUser->store_id,
        ]);
    }
}
