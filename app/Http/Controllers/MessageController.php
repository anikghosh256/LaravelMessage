<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use DB;
use App\Events\NewMessage;

class MessageController extends Controller
{
	public function __construct()
    {
        $this->middleware('auth');
    }

    public function getContact()
    {
    	$contacts =DB::table('users')
                     ->select(DB::raw('id, name, email'))
                     ->where('id','!=', auth()->id())
                     ->get();

        $unreadIds = Message::select(\DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('unread', 1)
            ->groupBy('from')
            ->get();


        

        // add an unread key to each contact with the count of unread messages
        $contacts = $contacts->map(function($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;
            return $contact;
        });

        return response()->json($contacts);
    }

    public function getMessages($id)
    {
        Message::where('from', $id)->where('to', auth()->id())->update(['unread' => 0]);

    	$messages = Message::with('fromContact')->where(function($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })
        ->latest()
        ->take(40)
        ->get();
        
        
        return response()->json($messages);
    }

    public function sendMess(Request $request)
    {
    	$newMess= Message::create([
    		'from' => auth()->id(),
            'to' => $request->contact_id,
            'text' => $request->text
    	]);
    	broadcast(new NewMessage($newMess));

    	return response()->json($newMess);
    }
}
