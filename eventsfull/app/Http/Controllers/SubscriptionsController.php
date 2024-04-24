<?php

namespace App\Http\Controllers;

use App\Models\EventsModel;
use App\Models\SubscriptionModel;
use Illuminate\Http\Request;
use App\Mail\MailSender;
use Illuminate\Support\Facades\Mail;


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
        $users_id = $data['users_id'];
        $eventos_id = $data['eventos_id'];


        SubscriptionModel::create([
            'users_id' => $users_id,
            'eventos_id' => $eventos_id
        ]);

        $evento = EventsModel::find($eventos_id);

        $details = [
            'title' => 'Inscrição efetuada com sucesso!',
            'body' => "Você realizou a inscrição no seguinte evento:<br><h3>$evento->name</h3><br>Você pode acompanhar as suas inscrições em <a href=\"http://eventsfull/subscriptions\">Minhas inscrições</a>."
        ];

        // Envia e-mail
        $this->sendMail($details);
        
        return response()->json([
            "message" => "Inscrição realizada!",
            200
        ]);
    }

    /*public function getCheckin()
    {
        //$user = Auth::user();
        //$eventos_id = $users->inscricoes->pluck('eventos_id')->toArray();
        $checkins = SubscriptionModel::select('subscriptions.id as inscricao_id', 'subscriptions.eventos_id as eventos_id', 'subscriptions.updated_at as hora_checkin', 'events.*')
            ->join('events', 'events.id', '=', 'subscriptions.eventos_id')
            ->where('subscriptions.checkin', true)
            ->whereIn('events.id', $eventos_id)
            ->get();

        return response()->json($checkins);
    }*/

    public function checkin(Request $request)
    {
        $subscription = SubscriptionModel::find($request->get('id'));
        $subscription->checkin = true;
        $subscription->save();

        $event = EventsModel::find($subscription->eventos_id);

        $details = [
            'title' => 'Checkin realizado com sucesso!',
            'body' => "Você realizou o checkin no seguinte evento:<br><h3>$event->name</h3><br>Você pode acompanhar os seus checkins em <a href=\"http://eventsfull/checkin\">Meus checkins</a>."
        ];

        // Envia e-mail
        $this->sendMail($details);

        return response()->json([
            'success' => true,
            'message' => 'Checkin realizado com sucesso!',
            'evento' => $event->name
        ]);
    }

    private function sendMail(Array $details)
    {
        Mail::to('user_receiver_email@gmail.com')->send(new MailSender($details));
    }
}