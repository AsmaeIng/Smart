<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Events\PrivateMessageEvent;
use Illuminate\Support\Facades\Auth;
use App\Message;
use App\User;
use App\UserMessageGroup;

class MessageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    // public function chat($id)
    // {
        // $friend = User::find($id);
        // return view('pages.chat.chat', compact('friend'));
    // }
	public function getMessage(){

        $to_user_id = Auth::user()->id;
		$lastOne = DB::table('messages')->latest('id')->first();
		$message = DB::table('messages')
            ->join('user_message','messages.id','=','user_message.message_id')   
            ->select('messages.*','user_message.sender_id')
			->where('user_message.receiver_id', '=',$to_user_id)
			->orderBy('created_at','desc')
            ->get();
		 // $message = DB::table('messages')
            // ->join('user_message','messages.id','=','user_message.message_id')   
            // ->join('users','users.id','=','user_message.sender_id')   
            // ->select('messages.*','user_message.sender_id','users.username','users.lastname','users.path','users.id as idUser')
			// ->where('user_message.receiver_id', '=',$to_user_id)
			// ->orderBy('created_at','desc')
            // ->get();
        return $message;
    }
	public function numberOfUnSeenChat(){

        $user_id = Auth::user()->id;
		$message = DB::table('user_message')
		->where('receiver_id',$user_id)
		->where('seen_status',false)
		->where('deletedTo',0)->count();

        return $message;
    }

	public function getChatMailDetails($id){

        $user_id = Auth::user()->id;
		$exist = DB::table('user_message')
				->select('user_message.*')
				->get();
		foreach($exist as $ex) {
			if($ex->sender_id == $id )
			{
			$chat_details = DB::table('messages')
				->join('user_message','messages.id','=','user_message.message_id')   
				->join('users','users.id','=','user_message.sender_id')
				->select('messages.*','user_message.sender_id','users.username','users.lastname','users.path','users.email')
				->where('user_message.receiver_id', '=',$user_id)
				->where('user_message.sender_id', '=',$id)			
				->where('users.id', '=',$id)			
				->orderBy('created_at','desc')
				->get();
			}
			else{
				$chat_details = User::select('users.username','users.lastname','users.path','users.email')->where('id',$id)->get();				
			}
		 }
        return $chat_details;
    } 
	public function getChatMailDetail($id){

        $user_id = Auth::user()->id;
		$exist = DB::table('user_message')
				->select('user_message.*')
				->get();
		foreach($exist as $ex) {
			if($ex->receiver_id == $id)
			{
			$chat_detail = Message::select('messages.*','user_message.sender_id')
				->where('user_message.receiver_id', '=',$id)
				->where('user_message.sender_id', '=',$user_id)						
				->orderBy('created_at','desc')
				->join('user_message','messages.id','=','user_message.message_id') 
				->get();
			}
			else{
				 $chat_details = User::select('users.username','users.lastname','users.path','users.email')->where('id',$id)->get();
				
			}
		}
        return $chat_detail;
    } 
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required',
            'receiver_id' => 'required'
        ]);

        $sender_id = auth()->user()->id;
        $receiver_id = $request->receiver_id;

        $message = new Message;
        $message->message = $request->message;

        if ($message->save()) {
            try {
                $message->users()->attach($sender_id, ['receiver_id' => $receiver_id]);
                $sender = User::where('id', '=', $sender_id)->first();
                $data = [];
                $data['sender_id'] = $sender_id;
                $data['sender_name'] = $sender->name;
                $data['receiver_id'] = $receiver_id;
                $data['content'] = $message->message;
                $data['type'] = 1;
                $data['in'] = true;
                $data['content_type'] = "text";

                event(new PrivateMessageEvent($data));

                return response()->json([
                    'data' => [],
                    'success' => true,
                    'message' => 'Message sent successfully.'
                ]);
            } catch (\Exception $e) {
                $message->delete();
            }
        }
    }
}
