{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- Page title --}}
@section('title','Chat')

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-chat.css')}}">
@endsection

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
                            <img src="/{{Auth::user()->path}}" alt="" class="circle z-depth-2 responsive-img">
                          </div>
                          <div class="col s10">
                            <p class="m-0 blue-grey-text text-darken-4 font-weight-700">{{Auth::user()->username}} {{Auth::user()->lastname}}</p>
                            <p class="m-0 info-text">{{Auth::user()->name}}</p>
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
											 messages <p class="m-0 blue-grey-text text-darken-4 font-weight-700">{!! $user->username !!}{!! $user->lastname !!}</p>
												<p class="m-0 info-text">
													@foreach($messages as $message)
														@if (@$user->id===$message->sender_id)
															{{ $message->message }}
														@endif
													@endforeach
												</p>
											</div>
										  </div>
										</div>
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
									
								</a>
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
                    <img src="{{asset('images/user/7.jpg')}}" alt="" class="circle z-depth-2 responsive-img">
                  </div>
                  <div class="col">
                    <p class="m-0 blue-grey-text text-darken-4 font-weight-700">Alice Hawker</p>
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
                          <img src="{{asset('images/user/12.jpg')}}" class="circle" alt="avatar" />
                        </a>
                      </div>
                      <div class="chat-body">
                        <div class="chat-text">
                          <p>How can we help? We're here for you!</p>
                        </div>
                      </div>
                    </div>
                    <div class="chat">
                      <div class="chat-avatar">
                        <a class="avatar">
                          <img src="{{asset('images/user/7.jpg')}}" class="circle" alt="avatar" />
                        </a>
                      </div>
                      <div class="chat-body">
                        <div class="chat-text">
                          <p>Hey John, I am looking for the best admin template. Could you please help me to find it
                            out?</p>
                        </div>
                        <div class="chat-text">
                          <p>It should be material css compatible.</p>
                        </div>
                      </div>
                    </div>
                    <div class="chat chat-right">
                      <div class="chat-avatar">
                        <a class="avatar">
                          <img src="{{asset('images/user/12.jpg')}}" class="circle" alt="avatar" />
                        </a>
                      </div>
                      <div class="chat-body">
                        <div class="chat-text">
                          <p>Absolutely!</p>
                        </div>
                        <div class="chat-text">
                          <p>Materialize admin is the responsive material admin template.</p>
                        </div>
                      </div>
                    </div>
                    <div class="chat">
                      <div class="chat-avatar">
                        <a class="avatar">
                          <img src="{{asset('images/user/7.jpg')}}" class="circle" alt="avatar" />
                        </a>
                      </div>
                      <div class="chat-body">
                        <div class="chat-text">
                          <p>Looks clean and fresh UI.</p>
                        </div>
                        <div class="chat-text">
                          <p>It's perfect for my next project.</p>
                        </div>
                        <div class="chat-text">
                          <p>How can I purchase it?</p>
                        </div>
                      </div>
                    </div>
                    <div class="chat chat-right">
                      <div class="chat-avatar">
                        <a class="avatar">
                          <img src="{{asset('images/user/12.jpg')}}" class="circle" alt="avatar" />
                        </a>
                      </div>
                      <div class="chat-body">
                        <div class="chat-text">
                          <p>Thanks, from ThemeForest.</p>
                        </div>
                      </div>
                    </div>
                    <div class="chat">
                      <div class="chat-avatar">
                        <a class="avatar">
                          <img src="{{asset('images/user/7.jpg')}}" class="circle" alt="avatar" />
                        </a>
                      </div>
                      <div class="chat-body">
                        <div class="chat-text">
                          <p>I will purchase it for sure.</p>
                        </div>
                        <div class="chat-text">
                          <p>Thanks.</p>
                        </div>
                      </div>
                    </div>
                    <div class="chat chat-right">
                      <div class="chat-avatar">
                        <a class="avatar">
                          <img src="{{asset('images/user/12.jpg')}}" class="circle" alt="avatar" />
                        </a>
                      </div>
                      <div class="chat-body">
                        <div class="chat-text">
                          <p>Great, Feel free to get in touch on</p>
                        </div>
                        <div class="chat-text">
                          <p>https://pixinvent.ticksy.com/</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!--/ Chat content area -->

              <!-- Chat footer <-->
              <div class="chat-footer">
                <form onsubmit="enter_chat();" action="javascript:void(0);" class="chat-input">
                  <i class="material-icons mr-2">face</i>
                  <i class="material-icons mr-2">attachment</i>
                  <input type="text" placeholder="Type message here.." class="message mb-0">
                  <a class="btn waves-effect waves-light send" onclick="enter_chat();">Send</a>
                </form>
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
@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/app-chat.js')}}"></script>
@endsection