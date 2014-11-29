@extends('layout')
<!--<html>
    <head>
        <title>Login Form</title>
        <link rel="shortcut icon" href="../../favicon.ico" />
        <!-- Latest compiled and minified CSS -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css">-->
        <!--{{HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css')}}
        <!-- Optional theme -->
        <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css">-->
        <!--{{HTML::style('https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap-theme.min.css')}}
        <style>
            body{
                background-color:rgba(0, 255, 255, 0.1);
                min-height:100%;
                min-width:100%;
                padding: 15% 0;
            }
            form{
                padding:10px 10px;
                border:1px solid black;
                background-color:white;
                width:30%;
                margin:0 auto;
                
                border-radius:3px;
            }
            .btn.btn-primary{
                margin-top:5px;
            }
            .error{
                border:1px solid red;
                background:#FFC4C4;
                width:30%;
                text-align:center;
                margin:5px 0;
            }
        </style>
    </head>
    
    <body id>-->
@section("css")
<style>
    form{
        padding:10px 10px;
        border:1px solid black;
        background-color:white;
        width:30%;
        margin:0 auto;

        border-radius:3px;
    }
    .btn.btn-primary{
        margin-top:5px;
    }
    .error{
        border:1px solid red;
        background:#FFC4C4;
        width:30%;
        text-align:center;
        margin:5px 0;
    }
</style>
@stop

@section('content')
    @if($errors->all())
        <div class="error">
            @foreach($errors->all() as $message)
                <span>{{$message}}</span><br/>
            @endforeach
        </div>
    @endif
    {{ Form::open(array('url' => 'login', 'method' => 'post')) }}
        {{Form::label('username','Username')}}
        {{Form::text('username', null,array('class' => 'form-control'))}}
        {{Form::label('password','Password')}}
        {{Form::password('password',array('class' => 'form-control'))}}
        {{Form::submit('Login', array('class' => 'btn btn-primary'))}}
    {{ Form::close() }}
@stop
    <!--<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <!-- Latest compiled and minified JavaScript -->
    <!--<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
    </body>
</html>-->