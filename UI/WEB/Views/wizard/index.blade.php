@extends('crud::layouts.top-navbar')

@section('title', 'CRUD Generator')

@section('content')

    
    {{-- page title --}}
    <div class="page-header">
        <h2 class="text-center">CRUD Generator <br><small>Type your table name</small></h2>
    </div>

    <div class="col-xs-12 col-sm-6 col-md-offset-3">

        {{-- panel with main content --}}
        <div class="panel panel-default">
            <div class="panel-body">

                @include('crud::partials.notifications')
                    
                {!! Form::open(['route' => 'crud.showOptions', 'method' => 'GET', 'id' => 'update-table-form']) !!}
                    
                    <div class="form-group {{ $errors->has('table_name') ? 'has-error' : '' }}">
                        {!! Form::label('table_name', 'Table name') !!}
                        @include('crud::wizard.partials.table-list-control', ['palceholder' => 'Type the table name'])
                        {!!$errors->first('table_name', '<span class="text-danger">:message</span>')!!}
                    </div>

                {!! Form::close() !!}

                <div class="clearfix"></div>
            </div>
        </div>

    </div>

@endsection
