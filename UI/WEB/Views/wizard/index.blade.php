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
                {{-- delete msgs --}}
                {{ session()->forget(['success', 'error', 'warning']) }}
                    
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

        <div class="panel panel-default">
            <div class="panel-body">
                {!! Form::open(['route' => 'crud.generate-many', 'method' => 'POST', 'id' => 'update-table-form']) !!}

                <strong>Generate many from existing config files</strong>
                
                <div class="form-group">
                @foreach ($config_files as $file)
                    <div class="checkbox">
                        <label>
                            {!! Form::checkbox('config[]', $file, null, ['class' => 'icheckbox_square-blue']) !!}
                            {{ $file }}
                        </label>
                    </div>
                @endforeach
                </div>

                <div class="clearfix"></div>
                @include('crud::wizard.partials.options.app-type')

                <div class="form-group">
                    <button class="btn btn-primary">Generate</button>
                </div>

                {!! Form::close() !!}
            </div>
        </div>

    </div>

@endsection

@section('scripts')
    <!-- iCheck skins -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/icheck.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/iCheck/1.0.2/skins/square/blue.css" />

    <script type="text/javascript">
        {{-- init iCheck --}}
        $('.icheckbox_square-blue').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue'
        });
    </script>
@endsection