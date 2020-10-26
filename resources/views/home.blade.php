@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    Click on the user to chat.
                </div>
                <ul>
                    @if (iterator_count($users))
                    @foreach ($users as $user)
                        <li><a href="{!! route('users.chat', ['id' => $user->id]) !!}">{!! $user->name !!}</a></li>
                    @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
