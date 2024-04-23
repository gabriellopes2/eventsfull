<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SubscriptionsController extends Controller
{
    public function searchSubscription($args)
    {
        //$user = Auth::user();
        $subscriptionId = $args;
        $subscription = SubscriptionModel::select('subscriptions.*')
            ->where('subscriptions.id', $subscriptionId)
            ->get();

        return response()->json($subscription);
    }

    public function register(Request $request)
    {
        $data = $request->all();
        /*$subscription = new SubscriptionModel();
        $subscription->users_id = $data['users_id'];
        $subscription->eventos_id = $data['eventos_id'];
        $subscription->save();*/

        SubscriptionModel::create([
            'users_id' => $data['users_id'],
            'eventos_id' => $data['eventos_id']
        ]);  
        
        return response()->json([
            "message" => "Inscrição realizada!",
            200
        ]);
    }
}