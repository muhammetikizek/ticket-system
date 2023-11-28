<?php

namespace App\Http\Controllers\API;

use App\Models\TicketTime;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketTimeController extends Controller
{
    
    public function deleteTicketTime(Request $request,  $ticketId)
    {
        $ticketTime = TicketTime::where('ticket_id', $ticketId)
        ->where('id', $request->id)
        ->first();
        $ticketTime->delete();
        return response()->json(null, 204);
    }
}
