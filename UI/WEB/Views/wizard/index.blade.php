@extends('theme::Inspinia.layouts.app-sidebar')

@section('title', 'CRUD Generator')

@section('styles')
@endsection

@section('content')

    @component('theme::Inspinia.components.page')
        @slot('title')
            <div class="col-xs-12">
                <h2>CRUD Generator <small>Type your table name</small></h2>
            </div>
        @endslot

        <div class="col-xs-12 col-sm-10 col-md-8">

            @component('theme::Inspinia.components.box')

                @slot('title')
                    <h5>Foo Title</h5>
                    @component('theme::Inspinia.components.box-tools')
                    @endcomponent
                @endslot

                @include ('theme::Inspinia.partials.notifications')
                    
                {!! Form::open(['route' => 'crud.showOptions', 'method' => 'GET']) !!}
                    
                    <div class="form-group {{ $errors->has('table_name') ? 'has-error' : '' }}">
                        {!! Form::label('table_name', 'Table name') !!}
                        {!! Form::text('table_name', null, ['class' => 'form-control']) !!}
                        {!!$errors->first('table_name', '<span class="text-danger">:message</span>')!!}
                    </div>

                    <div class="clearfix"></div>
                    
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            Let's configure the CRUD!!
                        </button>
                    </div>
                {!! Form::close() !!}

                <div class="clearfix"></div>
            @endcomponent

        </div>

    @endcomponent

@endsection

@section('scripts')
@stop()
