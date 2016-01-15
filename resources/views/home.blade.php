@extends('dvdlayout')

@section('content')

    <div class="row">
        <h1>Welcome to my website</h1>
        <p>We are creating something beautiful today.</p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>

        <h2>Sign In</h2>
        {!! Html::ul($errors->all(), array('class'=>'errors')) !!}

        {!! Form::open(array('url' => 'signin','class'=>'form-inline')) !!}

        {!! Form::label('email', 'E-Mail Address') !!}
        {!! Form::text('email', 'example@gmail .com', array('class' => 'form-control')) !!}
        {!! Form::label('password', 'Password') !!}
        {!! Form::password('password', array('class' => 'form-control')) !!}

        {!! Form::submit('Sign In' , array('class' => 'btn btn-primary')) !!}
        {!! Form::close() !!}


    </div>

@stop