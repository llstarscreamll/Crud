@extends('core::layouts.app-sidebar')

@section('title') {{trans('book/views.show.name').trans('book/views.module.name-singular')}} @stop

@section('styles')
@endsection

@section('content')

    <div class="content-header">
        <h1>
            <a href="{{route('books.index')}}">{{trans('book/views.module.name')}}</a>
            <small>{{trans('book/views.show.name')}}</small>
        </h1>
    </div>
    
    <div class="content">
        
        <div class="box">
            
            <div class="box-header">
                @include ('core::partials.notifications')
            </div>

            <div class="box-body">

                {!! Form::model($book, ['name' => 'show-books-form', 'data-show' => ($show = true)]) !!}

                    <div class='form-group col-sm-6 {{$errors->has('id') ? 'has-error' : ''}}'>
                        {!! Form::label('id', trans('book/views.form-fields.id')) !!}
                        {!! Form::input('text', 'id', null, ['class' => 'form-control', isset($show) ? 'disabled' : '']) !!}
                    </div>

                    <div class="clearfix"></div>

                    @include('books.partials.form-fields', ['show' => ($show = true)])

                    <div class="clearfix"></div>

                    @include('books.partials.hidden-form-fields', ['show' => ($show = true)])

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <a href="{{route('books.edit', $book->id)}}" class="btn btn-warning" role="button">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <span class="">{{trans('book/views.show.btn-edit')}}</span>
                        </a>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_confirm">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="">{{trans('book/views.show.btn-trash')}}</span>
                        </button>
                    </div>

                {!! Form::close() !!}
            </div>
        </div>
    </div>


    {{-- Ventana modal que pide confirmación de eliminación del registro --}}
    <div class="modal fade" id="modal_confirm" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog">
          <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="ModalLabel">{{trans('book/views.show.modal-confirm-trash-title')}}</h4>
            </div>

            <div class="modal-body">
                <p>{!!trans('book/views.show.modal-confirm-trash-body', ['item' => $book->name])!!}</p>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('book/views.show.modal-confirm-trash-btn-cancel')}}</button>
                {!! Form::open(['route' => ['books.destroy', $book->id], 'method' => 'DELETE', 'class' => 'display-inline', 'name' => 'delete-books-form']) !!}
                    <button type="submit" class="btn btn-danger">
                        <span>{{trans('book/views.show.modal-confirm-trash-btn-confirm')}}</span>
                    </button>
                {!! Form::close() !!}
            </div>

          </div>
        </div>
    </div>

@endsection

@section('scripts')
    {{-- Componente Bootstrap-Select, este componente se inicializa automáticamente --}}
    <script src="{{ asset('plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}"></script>
    <script src="{{ asset('plugins/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-select/dist/js/i18n/defaults-es_CL.min.js') }}"></script>
    
    <script type="text/javascript">

        {{-- Inicializa el componente SwitchBootstrap --}}
        $(".bootstrap_switch").bootstrapSwitch();
        
    </script>

@endsection()