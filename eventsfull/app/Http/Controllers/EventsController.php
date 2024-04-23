<?php

namespace App\Http\Controllers;

use App\Models\EventsModel;
use Illuminate\Http\Request;

class EventsController extends Controller
{
    public function index()
    {
        //$user = Auth::id();
        $eventos = EventsModel::select('events.*')        
            ->get();

        return response()->json($eventos);
    }

    public function searchEventParticipants(Request $request, $args)
    {
        $eventId = $args;
        $participantes = EventsModel::select('users.name')
            ->join('subscriptions', 'subscriptions.eventos_id', '=', 'events.id')
            ->join('users', 'subscriptions.users_id', '=', 'users.id')
            ->where('events.id', '==', $eventId)    
            ->get();

        return response()->json($participantes);
    }
}