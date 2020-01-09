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


        $lastMessages = $this->LastMessWithUser($contacts);

        // add last  messages
        $contacts = $contacts->map(function($contact) use ($lastMessages) {
            $lastMess = $lastMessages->where('uid', $contact->id)->first();

            $contact->lastMess = $lastMess ? $lastMess['lastMess'] : null;

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



    protected function LastMessWithUser($contacts){
        $LastMessWithUser = collect();

        foreach ($contacts as $contact) {
            $lastMess;
            //select last resseved message with contact id
            $mess1= Message::where('to', $contact->id)->orderBy('id','desc')->first();
            
            //select last send message to mess1 user  
            $mess2= Message::where('to', $mess1['from'])->where('from', $mess1['to'])->orderBy('id','desc')->first();
          
            if ($mess2)
            {
                if ($mess1['id'] > $mess2['id']) 
                {
                    $lastMess = $mess1->text;
                }else{
                    $lastMess = $mess2->text;
                }
                $LastMessWithUser[]= [
                    'uid' => $contact->id,
                    'lastMess' => $lastMess
                ];

            }else
            {
                $LastMessWithUser[]= [
                    'uid' => $mess1['to'],
                    'lastMess' => null
                ];
            }
            

            
        }

        return $LastMessWithUser;
    }
}
