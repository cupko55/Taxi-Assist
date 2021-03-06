@extends('layouts.app')

@section('content')


    <h2>Dodavanje korisnika</h2>
    <hr>
    <div class="row">
        <div class="col-md-6">
            {!! Form::open(array('url'=>'user')) !!}
            <div class="form-group">
                {!! Form::label('name', 'Ime') !!}
                {!! Form::text('name',null,array('class'=>'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('email', 'E-mail') !!}
                {!! Form::email('email',null,array('class'=>'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('phone', 'Telefonski broj') !!}
                {!! Form::text('phone',null,array('class'=>'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password', 'Lozinka:') !!}
                {!! Form::password('password',array('class'=>'form-control')) !!}
            </div>
            <div class="form-group">
                {!! Form::label('password_confirmation', 'Potvrda lozinke:') !!}
                {!! Form::password('password_confirmation',array('class'=>'form-control')) !!}
            </div>
            <div class="form-group">

            </div>
            {!! Form::submit("Dodaj",array('class'=>'btn btn-primary')) !!}
            {!! Form::close() !!}
        </div>
    </div>
    <div class="row">
        @include('errors.list')
    </div>



@endsection