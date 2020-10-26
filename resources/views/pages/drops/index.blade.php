{{-- layout extend --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Drops')

{{-- vendor styles --}}
@section('vendor-style')

<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/jquery.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css"
  href="{{asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/data-tables/css/dataTables.checkboxes.css')}}">
@endsection

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-sidebar.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-contacts.css')}}">
@endsection
{{-- page content --}}
@section('content')

<!-- invoice list -->
<section class="invoice-list-wrapper section">
	<!-- create invoice button-->
	<!-- Options and filter dropdown button-->
	<!-- create invoice button-->
	<div class="row">
		<div class="col s12 m12 l12">
			<div id="button-trigger" class="card card card-default scrollspy">
				<div class="card-content">
					<center><h4 class="card-title"><i class="material-icons app-header-icon text-top">location_city</i>@lang('locale.Drops')</h4></center>
						<div class="row">
							<div class="col m4 s12"></div>
							<div class="col m4 s12">
								<div class="filter-btn">
									<a href="{{ route('drops.create') }}" class="btn waves-effect waves-light invoice-create border-round z-depth-4">
										<i class="material-icons">add</i>
										<span class="hide-on-small-only">@lang('locale.NewDrops' )</span>
									</a>
								</div>			
							</div>
							<div class="col m4 s12">
								<form id="periode" method="GET" action="{{ route('drops.show') }}" >
									@csrf
									<select id="created_at" name="created_at" onchange="document.getElementById('periode').submit()">
										@if($dat=="Today")						
											<option id="Today" value="Today" selected>@lang('locale.Today')</option>
										@else
											<option id="Today" value="Today" selected>@lang('locale.Today')</option>
										@endif
										@if($dat=="Yesterday")
											<option id="Yesterday" value="Yesterday" selected >@lang('locale.Yesterday')</option>
										@else
											<option id="Yesterday" value="Yesterday">@lang('locale.Yesterday')</option>
										@endif
										@if($dat=="Last7Days")
											<option id="Last7Days" value="Last7Days" selected>@lang('locale.Last7Days')</option>
										@else
											<option id="Last7Days" value="Last7Days">@lang('locale.Last7Days')</option>
										@endif
										@if($dat=="Last30Days")
											<option id="Last30Days" value="Last30Days" selected>@lang('locale.Last30Days')</option>
										@else
											<option id="Last30Days" value="Last30Days" >@lang('locale.Last30Days')</option>
										@endif
										@if($dat=="LastMonth")
											<option id="LastMonth" value="LastMonth" selected>@lang('locale.LastMonth')</option>
										@else 
											<option id="LastMonth" value="LastMonth">@lang('locale.LastMonth')</option>
										@endif
											<!--<option id="customRange" value="customRange">@lang('locale.customRange')</option>-->											
									</select>
									<!--<div class="input-field col s12">
										<button class="btn cyan waves-effect waves-light right" type="submit" name="action">@lang('locale.Show')
											<i class="material-icons right">send</i>
										</button>
									-->	

								</form>
							</div>
						</div>
				</div>
			</div>
		</div>
	</div>
	 
	<div class="responsive-table">
		  <!--<form method="POST" action="{{ route('sends.store') }}" >
			@csrf -->							 
				<table class="table invoice-data-table white border-radius-4 pt-1" id="drops" style="width:100%">
					<thead>
						<tr>
							<th></th>
							<th></th>
							<th class="all"><center>@lang('locale.idSend')</center></th>         
							<th class="all"><center>@lang('locale.offer')</center></th>
							<!--<th class="all"><center>@lang('locale.Isp')</center></th>-->
							<!--<th class="all"><center>@lang('locale.list')</center></th>-->
							<th class="all"><center>@lang('locale.fraction')</center></th>
							<th class="all"><center>@lang('locale.seed')</center></th>
							<th class="all"><center>@lang('locale.X-delay')</center></th>
							<th class="all"><center>@lang('locale.count')</center></th>
							<th class="none"></th>
							<th class="all"><center>Action</center></th>		  		  										
						</tr>							
					</thead>
					<tbody>
						@foreach ($data as $drop)
							
							  {!! Form::open(array ('id'=>'drops-form')) !!}
								<tr>			
									<td></td>
									<td></td>
									<td> <center><div type="text" id="dropId" name="id">{{$drop->id}}</div></center></td>         
									<td>
										<center>	
											@foreach($offres as $offre)	
												@if (@$drop->offre_id === $offre->id)
													<!--<input id="offre_id" name="offre_id" type="hidden" value="{{$offre->id}}">-->
													{{$offre->name}}
												@endif
											@endforeach
										</center>
									</td>
									<!--<td> 
										<center>
											{{--@foreach($drop->isps as $id => $isps)	
													{{$isps->name}}
											@endforeach--}}
										</center>
									</td>-->
									<!--<td> 
										<center>
											
											@foreach($drop->listesends as $id => $listesends)								
													{{ $listesends->name }} 
											@endforeach 
										</center>
									</td>-->
									<td width="100" >
										{{--<select class="browser-default" name="ip_id" id="ip_id" > 																				
												@foreach($drop->sips as $id => $sips)													
													<option id="{{ $sips->id }}" name="{{ $sips->id }}" value="{{ $sips->id }}" >{{$sips->IP}}</option>
												@endforeach
										</select>--}}
										<input type="text" id="{{$drop->id}}fraction" name="fraction" placeholder="fraction"> 
									</td>
									<td width="200">
										<input type="email" id="{{$drop->id}}email" name="email" placeholder="email" value="contact@alphaemarketing.com" > 
										<input type="text" id="{{$drop->id}}seed" name="seed" placeholder="seed"> 										
									</td>
									<td width="150">
										<center>
											<input type="text" id="{{$drop->id}}x_delay" name="x_delay" placeholder="x_delay"> 
										</center>
									</td>
									<td width="150">
										<center>
											{{$drop->count}}
										</center>
									</td>
									<td>
										<div class="row">
											<div class="input-field col m4 s12 "  >
												@foreach($networks as $net)	
													@if (@$drop->network_id===$net->id)
														<strong>@lang('locale.PlateformSponsor') :</strong> {{$net->name}}
													@endif
												@endforeach
											</div>
											<div class="input-field col m4 s12 "  >
												@foreach($offres as $offre)	
													@if (@$drop->offre_id === $offre->id)
														<strong>@lang('locale.Offre') :</strong> {{$offre->name}}
													@endif
												@endforeach
											</div>
											<div class="input-field col m4 s12 "  ><strong>@lang('locale.Isp') :</strong>
											{{--	@foreach($drop->isps as $id => $isps) {{$isps->name}} ,  @endforeach --}}
											</div>
										</div>
										<div class="row">
																													
												<div class="input-field col m4 s12 "  ><strong>@lang('locale.liste') :</strong>
													@foreach($drop->listesends as $id => $listesends) {{$listesends->name}} ,  @endforeach 
												</div>												
												<div class="input-field col m4 s12 "  >
													@foreach($headers as $header)	
														@if (@$drop->header_id === $header->id)
															<strong>@lang('locale.Header') :</strong> {{$header->name}}
														@endif
													@endforeach
												</div>
												<div class="input-field col m4 s12 "  >
													@foreach($bodys as $body)	
														@if (@$drop->body_id === $body->id)
															<strong>@lang('locale.Body') :</strong> {{$body->name}} 
														@endif
													@endforeach
												</div>	
										</div>
										<div class="row">
																													
												<div class="input-field col m4 s12 "  ><strong>@lang('locale.server') :</strong>
													@foreach($drop->servers as $id => $servers) {{$servers->alias}} ,  @endforeach 
												</div>												
												<div class="input-field col m4 s12 "  ><strong>@lang('locale.IP') :</strong>
													@foreach($drop->sips as $id => $sips) {{$sips->IP}} ,  @endforeach 
												</div>	
										</div>
									</td>
									<td>
										<div class="invoice-action">
											
											<button type="submit" style="border: 0px;background-color:#fff;" onclick="myFunction({{$drop->id}})" class="invoice-action-view mr-4" >
												<i class="material-icons">mail</i>
											</button>
											<!--<a href="{{ route('sends.edit',$drop->id) }}" class="invoice-action-edit"><!--,$drop->id-->
												<!--<i class="material-icons">edit</i>
											</a>-->
											<a href="{{ route('drops.edit',$drop->id) }}" class="invoice-action-edit"><!--,$drop->id-->
												<i class="material-icons">mode_edit</i>
											</a>
											<a href="{{ route('sends.pauseSend') }}" class="invoice-action-edit">
												<i class="material-icons">pause</i>
											</a>
											<a href="{{ route('drops.delete',$drop->id) }}" class="invoice-action-delete">
												<i class="material-icons">delete_forever</i>
											</a>
											<!--<a href="" class="invoice-action-edit">
												<i class="material-icons">near_me</i>
											</a>
											
											<a href="" class="invoice-action-edit">
												<i class="material-icons">insert_chart</i>
											</a>-->
										</div>
									</td>
								</tr>
							{!! Form::close() !!}
						@endforeach 
					</tbody>
				</table>
		<input type="hidden" name="idCreative" id="idCreative"/>
	  </div>
</section>
<script>
	function myFunction(e) {
			// var id = document.getElementById("dropId").innerText;
			var fraction = document.getElementById(+e+"fraction").value;
			var email = document.getElementById(+e+"email").value;
			var x_delay = document.getElementById(+e+"x_delay").value;
			// var count = document.getElementById("count").innerText;
			var seed = document.getElementById(+e+"seed").value;
			// var ip_id = document.getElementById("ip_id").value;
			console.log();
			$.get('{!! route("sends.send") !!}?id='+ e+'&fraction='+fraction+'&email='+email+'&x_delay='+ x_delay+'&seed='+ seed,function(data) {        
			window.open('{!! route("sends.send") !!}?id='+ e+'&fraction='+fraction+'&email='+email+'&x_delay='+ x_delay+'&seed='+ seed);
			});
	}
			
	
</script>
@endsection
{{-- vendor scripts --}}
@section('vendor-script')
<script src="{{asset('vendors/data-tables/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('vendors/data-tables/js/datatables.checkboxes.min.js')}}"></script>
@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/app-invoice.js')}}"></script>
<script src="{{asset('js/scripts/app-chat.js')}}"></script>
@endsection