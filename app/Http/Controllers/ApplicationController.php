<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\inbox;
use App\Message;
use App\User;
use App\UserMessageGroup;

class ApplicationController extends Controller
{
    public function emailApp()
    {
        $inbox_controller = new InboxController();
        $inbox = $inbox_controller->getInboxMails();
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.inbox.app-email', ['pageConfigs' => $pageConfigs,'inboxes'=>$inbox,'numberOfMessages'=>$numberOfMessages]);
    }
	public function chatApp()
    {
        $users = User::where('id', '!=', auth()->user()->id)->get();
        $chat_controller = new MessageController();
        $message = $chat_controller->getMessage();
		$numberOfchat = $chat_controller->numberOfUnSeenChat();
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.chat.app-chat', ['pageConfigs' => $pageConfigs,'users' => $users,'messages'=>$message,'numberOfchat'=>$numberOfchat]);
    }
	// public function chat($id)
    // {

		// $users = User::where('id', '!=', auth()->user()->id)->get();
        // $chat_controller = new MessageController();
        // $message = $chat_controller->getMessage();
		// $numberOfchat = $chat_controller->numberOfUnSeenChat();
        // $pageConfigs = ['bodyCustomClass' => 'app-page'];
        // return view('pages.chat.chat', ['pageConfigs' => $pageConfigs,'users' => $users,'messages'=>$message,'numberOfchat'=>$numberOfchat]);
    // }
	 public function chat($id)
    {
        // $inbox_attachments = $MessageController->getInboxMailAttachment($inbox_id);         
		// $numberOfAttachments = $MessageController->numberOfAttachments($inbox_id);
		$friend = User::find($id);
		$chat_controller = new MessageController();
        $chat_details = $chat_controller->getChatMailDetails($id);
        $chat_detail = $chat_controller->getChatMailDetail($id);
		$numberOfchat = $chat_controller->numberOfUnSeenChat();
		$users = User::where('id', '!=', auth()->user()->id)->get();
		$pageConfigs = ['bodyCustomClass' => 'app-page'];
        // if(Auth::user()->id == $chat_details[0]->sender_id){

            // $message= new Message;
            // $user_id = Auth::user()->id;
            // $message->where("id",$id)->where('receiver_id',$user_id)->update([
                // "seen" => true,
            // ]);
			return view('pages.chat.chat', ['pageConfigs' => $pageConfigs,'users' => $users,'friend' => $friend,'chat_detail'=>$chat_detail,'chat_details'=>$chat_details,'numberOfchat'=>$numberOfchat]);
        // }
        // else{
			// return redirect('/pages/chat/chat', ['pageConfigs' => $pageConfigs]);
        // }
        
        
    }
	public function sent()
    {
        $inbox_controller = new InboxController();
        $sent = $inbox_controller->getSentMails();
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.inbox.sent', ['pageConfigs' => $pageConfigs,'sents'=>$sent,'numberOfMessages'=>$numberOfMessages]);
    }
	 public function deleted()
    {
        $inbox_controller = new InboxController();
        $deleted = $inbox_controller->getDeletedMails();
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();
		 $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.inbox.deleted', ['pageConfigs' => $pageConfigs,'deleted_mails'=>$deleted,'numberOfMessages'=>$numberOfMessages]);
    }
	public function starred()
    {
        $inbox_controller = new InboxController();
        $starreds = $inbox_controller->getStarred();
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();
		 $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.inbox.getStarred', ['pageConfigs' => $pageConfigs,'getStarred'=>$starreds,'numberOfMessages'=>$numberOfMessages]);
    }
	public function important()
    {
        $inbox_controller = new InboxController();
        $importants = $inbox_controller->getImportant();
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails();
		 $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.inbox.getImportant', ['pageConfigs' => $pageConfigs,'getImportant'=>$importants,'numberOfMessages'=>$numberOfMessages]);
    }

    public function emailContentApp($inbox_id)
    {
        $inbox_controller = new InboxController();
        $inbox_details = $inbox_controller->getInboxMailDetails($inbox_id);
        $inbox_attachments = $inbox_controller->getInboxMailAttachment($inbox_id);
        $numberOfMessages = $inbox_controller->numberOfUnSeenMails(); 
		$numberOfAttachments = $inbox_controller->numberOfAttachments($inbox_id);
		$pageConfigs = ['bodyCustomClass' => 'app-page'];
        if(Auth::user()->id == $inbox_details[0]->to_user_id){

            $inbox= new inbox;
            $user_id = Auth::user()->id;
            $inbox->where("inbox_id",$inbox_id)->where('to_user_id',$user_id)->update([
                "seen" => true,
            ]);
			return view('pages.inbox.app-email-content', ['pageConfigs' => $pageConfigs,'numberOfAttachments'=>$numberOfAttachments,'inbox_details'=>$inbox_details,'inbox_attachments'=>$inbox_attachments,'numberOfMessages'=>$numberOfMessages]);
        }
        else{
			return redirect('/pages/inbox/app-email', ['pageConfigs' => $pageConfigs]);
        }
        
        
    }
    
    public function todoApp()
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.app-todo', ['pageConfigs' => $pageConfigs]);
    }
    public function kanbanApp()
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page menu-collapse'];
        return view('pages.app-kanban', ['pageConfigs' => $pageConfigs]);
    }
    public function fileManagerApp()
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.app-file-manager', ['pageConfigs' => $pageConfigs]);
    }
    public function contactApp()
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.app-contacts', ['pageConfigs' => $pageConfigs]);
    }
    public function calendarApp()
    {
        // Breadcrumbs
        $breadcrumbs = [
            ['link' => "modern", 'name' => "Home"], ['link' => "javascript:void(0)", 'name' => "App"], ['name' => "Calendar"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.app-calendar', ['breadcrumbs' => $breadcrumbs], ['pageConfigs' => $pageConfigs]);
    }
    public function invoiceList()
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.app-invoice-list', ['pageConfigs' => $pageConfigs]);
    }
    public function invoiceView()
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.app-invoice-view', ['pageConfigs' => $pageConfigs]);
    }
    public function invoiceEdit()
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.app-invoice-edit', ['pageConfigs' => $pageConfigs]);
    }
    public function invoiceAdd()
    {
        // custom body class
        $pageConfigs = ['bodyCustomClass' => 'app-page'];
        return view('pages.app-invoice-add', ['pageConfigs' => $pageConfigs]);
    }
    public function ecommerceProduct()
    {
        // Breadcrumbs
        $breadcrumbs = [
            ['link' => "modern", 'name' => "Home"], ['link' => "javacript:void(0)", 'name' => "App"], ['name' => "eCommerce Products Page"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.eCommerce-products-page', ['breadcrumbs' => $breadcrumbs], ['pageConfigs' => $pageConfigs]);
    }
    public function eCommercePricing()
    { // Breadcrumbs
        $breadcrumbs = [
            ['link' => "modern", 'name' => "Home"], ['link' => "javacript:void(0)", 'name' => "eCommerce"], ['name' => "eCommerce Pricing"],
        ];
        //Pageheader set true for breadcrumbs
        $pageConfigs = ['pageHeader' => true, 'isFabButton' => true];

        return view('pages.eCommerce-pricing', ['breadcrumbs' => $breadcrumbs], ['pageConfigs' => $pageConfigs]);
    }
}
