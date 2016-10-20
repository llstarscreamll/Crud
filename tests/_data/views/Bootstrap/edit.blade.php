@extends('core::layouts.app-sidebar')

@section('title') {{trans('book/views.edit.name').trans('book/views.module.name-singular')}} @endsection

@section('styles')
@endsection

@section('content')

    <div class="content-header">
        <h1>
            <a href="{{route('books.index')}}">{{trans('book/views.module.name')}}</a>
            <small>{{trans('book/views.edit.name')}}</small>
        </h1>
    </div>
    
    <div class="content">
        
        <div class="box">
            
            <div class="box-header">
                @include ('core::partials.notifications')
            </div>

            <div class="box-body">

                {!! Form::model($book, ['route' => ['books.update', $book->id], 'method' => 'PUT', 'name' => 'edit-books-form']) !!}

                    @include('books.partials.form-fields')

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-warning">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <span class="">{{trans('book/views.edit.btn-edit')}}</span> 
                        </button>
                        <span id="helpBlock" class="help-block">{!!trans('book/views.inputs-required-help')!!}</span>
                    </div>

                {!! Form::close() !!}

            </div>

        </div>

    </div>
@endsection

@section('scripts')

    {{-- Componente Bootstrap-Select, este componente se inicializa automáticamente --}}
    <script src="{{ asset('plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}"></script>
    <script src="{{ asset('plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-select/dist/js/i18n/defaults-es_CL.min.js') }}"></script>
    {{-- Componente Bootstrap DateTimePicker --}}
    <link rel="stylesheet" href="{{ asset('plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"/>
    <script src="{{ asset('plugins/moment/min/moment-with-locales.min.js') }}"></script>
    <script src="{{ asset('plugins/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>


    <script type="text/javascript">

        {{-- Configuración de Bootstrap DateTimePicker --}}
        $('input[name=published_year]').datetimepicker({
            locale: '{{ Lang::locale() }}',
            format: 'YYYY-MM-DD'
        });
        
        {{-- Inicializa el componente SwitchBootstrap --}}
        $(".bootstrap_switch").bootstrapSwitch();
        
    </script>

@endsection()