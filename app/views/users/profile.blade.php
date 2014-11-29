@extends('layout')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <p>Welcome to your profile page {{Auth::user()->first_name}} - {{Auth::user()->last_name}}</p>
        </div> 
    </div>
</div>
@stop