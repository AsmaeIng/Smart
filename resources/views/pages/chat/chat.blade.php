{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- Page title --}}
@section('title','Chat')

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-chat.css')}}">
@endsection
 <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
 <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
 <script src="{{ asset('assets/js/socket.io.js') }}"></script>
  <script src="{{ asset('js/app.js') }}" defer></script>
{{-- main page content --}}
@section('content')
<div class="chat-application">
  <div class="chat-content-head">
    <div class="header-details">
      <h5 class="m-0 sidebar-title"><i class="material-icons app-header-icon text-top">mail_outline</i> Chat</h5>
    </div>
  </div>
  <div class="app-chat">
    <div class="content-area content-right">
      <div class="app-wrapper">
        <!-- Sidebar menu for small screen -->
        <a href="#" data-target="chat-sidenav" class="sidenav-trigger hide-on-large-only">
          <i class="material-icons">menu</i>
        </a>
        <!--/ Sidebar menu for small screen -->

        <div class="card card card-default scrollspy border-radius-6 fixed-width">
          <div class="card-content chat-content p-0">
            <!-- Sidebar Area -->
            <div class="sidebar-left sidebar-fixed animate fadeUp animation-fast">
              <div class="sidebar animate fadeUp">
                <div class="sidebar-content">
                  <div id="sidebar-list" class="sidebar-menu chat-sidebar list-group position-relative">
                    <div class="sidebar-list-padding app-sidebar sidenav" id="chat-sidenav">
                      <!-- Sidebar Header -->
                      <div class="sidebar-header">
                        <div class="row valign-wrapper">
                          <div class="col s2 media-image pr-0">
                            <img src="/{{Auth::user()->path}}"" alt="" class="circle z-depth-2 responsive-img">
                          </div>
                          <div class="col s10">
                            <p class="m-0 blue-grey-text text-darken-4 font-weight-700">{{Auth::user()->username}} {{Auth::user()->lastname}}</p>
                            <p class="m-0 info-text">Apple pie bonbon cheesecake tiramisu</p>
                          </div>
                        </div>
                        <span class="option-icon">
                          <i class="material-icons">more_vert</i>
                        </span>
                      </div>
                      <!--/ Sidebar Header -->

                      <!-- Sidebar Search -->
                      <div class="sidebar-search animate fadeUp">
                        <div class="search-area">
                          <i class="material-icons search-icon">search</i>
                          <input type="text" placeholder="Search Chat" class="app-filter" id="chat_filter">
                        </div>
                        <div class="add-user">
                          <a href="#">
                            <i class="material-icons mr-2 add-user-icon">person_add</i>
                          </a>
                        </div>
                      </div>
                      <!--/ Sidebar Search -->

                      <!-- Sidebar Content List -->
                      <div class="sidebar-content sidebar-chat">
                        <div class="chat-list">
						@if (iterator_count($users))
						@foreach ($users as $user)						
                          <div class="chat-user animate fadeUp delay-1">
							<a href="{!! route('users.chat', ['id' => $user->id]) !!}">
								<div class="user-section">
								  <div class="row valign-wrapper">
									<div class="col s2 media-image online pr-0">
									  <img src="/{!! $user->path !!}" alt=""
										class="circle z-depth-2 responsive-img">
									</div>
									<div class="col s10">
										<p class="m-0 blue-grey-text text-darken-4 font-weight-700">{!! $user->username !!}{!! $user->lastname !!}</p>
										<p class="m-0 info-text">
												@foreach($chat_details as $message)	
													@if (@$user->id===$message->sender_id)
														{{ $message->message }}
												@endif
												@endforeach
										</p>
									</div>
								  </div>
								</div>
							</a>
                            <div class="info-section">
                              <div class="star-timing">
                                <div class="favorite">
                                  <i class="material-icons amber-text">star</i>
                                </div>
                                <div class="time">
                                  <span>2.38 pm</span>
                                </div>
                              </div>
                              @if($numberOfchat>0)<span class="badge badge pill red">{{$numberOfchat}}</span>@endif
                            </div>
                          </div> 
						
						@endforeach
						@endif
                        </div>
                        <div class="no-data-found">
                          <h6 class="center">No Results Found</h6>
                        </div>
                      </div>
                      <!--/ Sidebar Content List -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!--/ Sidebar Area -->

            <!-- Content Area -->
            <div class="chat-content-area animate fadeUp">
              <!-- Chat header -->
              <div class="chat-header">
                <div class="row valign-wrapper">
                  <div class="col media-image online pr-0">
                    <img src="/{!! ucfirst($friend->path) !!}" alt="" class="circle z-depth-2 responsive-img">
                  </div>
                  <div class="col">
                    <p class="m-0 blue-grey-text text-darken-4 font-weight-700">{!! ucfirst($friend->name) !!}</p>
                    <p class="m-0 chat-text truncate">Apple pie bonbon cheesecake tiramisu</p>
                  </div>
                </div>
                <span class="option-icon">
                  <span class="favorite">
                    <i class="material-icons">star_outline</i>
                  </span>
                  <i class="material-icons">delete</i>
                  <i class="material-icons">more_vert</i>
                </span>
              </div>
              <!--/ Chat header -->

              <!-- Chat content area -->
              <div class="chat-area">
                <div class="chats">
                  <div class="chats">
                    <div class="chat chat-right">
                      <div class="chat-avatar">
                        <a class="avatar">
                          <img src="/{!! $user->path !!}" class="circle" alt="avatar" />
                        </a>
                      </div>
                      <div class="chat-body" id="conversation-ul" >
							@foreach($chat_detail as $chat_detai)	
								<div class="chat-text">
								  <p>{{$chat_detai->message}}</p>						
								</div>
							@endforeach	
                      </div>
                    </div>
                    <div class="chat">
                      <div class="chat-avatar">
                        <a class="avatar">
                          <img src="/{{$chat_details[0]->path}}" class="circle" alt="avatar" />
                        </a>
                      </div>
                      <div class="chat-body" >
							@foreach($chat_details as $chat_det)
								<div class="chat-text">
								  <p>{{$chat_det->message}}
									</p>
								</div>
							@endforeach
                      </div>
                    </div>                 
                  </div>
                </div>
              </div>
              <!--/ Chat content area -->

              <!-- Chat footer <-->
              <div class="chat-footer">
                <form id="message-form" class="chat-input">
                    @csrf
					<i class="material-icons mr-2">face</i>
					<i class="material-icons mr-2">attachment</i>
                    <input type="text" name="message" id="message-textarea" placeholder="Type message here.." class="message mb-0">
                    <button class="btn waves-effect waves-light send" type="submit">Send</button>
                </form>
				
				<!--<form onsubmit="enter_chat();" action="javascript:void(0);" class="chat-input">
                  <i class="material-icons mr-2">face</i>
                  <i class="material-icons mr-2">attachment</i>
                  <input type="text" placeholder="Type message here.." class="message mb-0">
                  <a class="btn waves-effect waves-light send" onclick="enter_chat();">Send</a>
                </form>-->
              </div>
              <!--/ Chat footer -->
            </div>
            <!--/ Content Area -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
    $(function() {
        const conversation_ul = $("#conversation-ul");
        const msg_textarea = $("#message-textarea");
        const auth_id = "{!! auth()->user()->id !!}";
        let ip_address = "{!! request()->ip() !!}";
        let socket_port = '{!! config("constants.socket_port") !!}';
        let socket = io(ip_address + ':' + socket_port);

        socket.on('connect', function() {
            socket.emit('user_connected', auth_id);
        });

        msg_textarea.keypress(function (e) {
            if (e.which == 13) {
                $('#message-form').submit();
                return false;    //<---- Add this line
            }
        });

        $("#message-form").on('submit', function(event) {
            event.preventDefault();
            let message = msg_textarea.val();
            let li = '<div class="chat-text">\
                <p>'+message+'</p>\
                </div>';
            conversation_ul.append(li);
            let url = "{!! route('users.message') !!}";
            let form = $(this);
            let formData = new FormData(form[0]);
            let friend_id = "{!! $friend->id !!}";
            formData.append('receiver_id', friend_id);
            msg_textarea.val("");
            $.ajax({
                url: url,
                type: 'POST',
                dataType: 'JSON',
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                async: false,
                success: function(response) {
                    console.log(response);
                }
            });
        });

        // socket.on('privateMessage', function(data) {
        //     console.log(data);
        // });

        socket.on("private-channel:App\\Events\\PrivateMessageEvent", function(message) {
            let li = '<div>\
                    <small>'+(message.sender_name).substring(0,1)+'</small>\
                    <p>'+message.content+'</p>\
                </div>';
            conversation_ul.append(li);
        });
    });
</script>
@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/app-chat.js')}}"></script>
@endsection