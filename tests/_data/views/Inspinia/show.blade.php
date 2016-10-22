{{--
    ****************************************************************************
    Show.
    ____________________________________________________________________________
    Muestra la vista de detalles de un registro.
    ****************************************************************************

    Este archivo es parte del Módulo Libros.
	(c) Johan Alvarez <llstarscreamll@hotmail.com>
	Licensed under The MIT License (MIT).

	@package    Módulo Libros.
	@version    0.1
	@author     Johan Alvarez.
	@license    The MIT License (MIT).
	@copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>.
	@link       https://github.com/llstarscreamll.
    
    ****************************************************************************
--}}

@extends('core::layouts.app-sidebar')

{{-- page title --}}
@section('title') {{trans('book/views.show.name').trans('book/views.module.name-singular')}} @stop
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('books.partials.heading', ['small_title' => trans('book/views.show.name')])
    
{{-- content --}}
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-xs-12 animated fadeInRight">
            <div class="ibox float-e-margins">

            {{-- box content --}}
            <div class="ibox-content">

                @include ('core::partials.notifications')

                {!! Form::model(
                    $book,
                    [
                        'name' => 'show-books-form',
                        'data-show' => ($show = true)
                    ]
                ) !!}

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

                    <div class="clearfix"></div>

                {!! Form::close() !!}

            </div>
            {{-- /box content --}}
            </div>{{-- /ibox --}}
        </div>{{-- /col-**-** --}}
    </div>{{-- /row --}}
</div>
{{-- /content --}}


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
            {!! Form::open([
                'route' => ['books.destroy',
                $book->id],
                'method' => 'DELETE',
                'class' => 'display-inline',
                'name' => 'delete-books-form'
            ]) !!}
                <button type="submit" class="btn btn-danger">
                    <span>{{trans('book/views.show.modal-confirm-trash-btn-confirm')}}</span>
                </button>
            {!! Form::close() !!}
        </div>

      </div>
    </div>
</div>

@endsection
{{-- /page content --}}

{{-- view scripts--}}
@section('scripts')

@include('books.partials.form-assets')
@include('books.partials.form-scripts')

@endsection()