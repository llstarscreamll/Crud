{{--
    ****************************************************************************
    Show.
    ____________________________________________________________________________
    Muestra la vista de detalles de un registro.
    ****************************************************************************

    Este archivo es parte de Books.
    (c) Johan Alvarez <llstarscreamll@hotmail.com>
    Licensed under The MIT License (MIT).

    @package    Books
    @version    0.1
    @author     Johan Alvarez
    @license    The MIT License (MIT)
    @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>
    @link       https://github.com/llstarscreamll
    
    ****************************************************************************
--}}

@extends('core::layouts.app-sidebar')

{{-- page title --}}
@section('title') {{trans('core::shared.views.show').trans('book.module.name-singular')}} @stop
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('books.partials.heading', ['small_title' => trans('core::shared.views.show')])
    
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
                        {!! Form::label('id', trans('book.form-labels.id')) !!}
                        {!! Form::input('text', 'id', null, ['class' => 'form-control', isset($show) ? 'disabled' : '']) !!}
                    </div>

                    <div class="clearfix"></div>

                    @include('books.partials.form-fields', ['show' => ($show = true)])

                    <div class="clearfix"></div>

                    @include('books.partials.hidden-form-fields', ['show' => ($show = true)])

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        @if(auth()->user()->can('books.edit'))
                            <a href="{{route('books.edit', $book->id)}}" class="btn btn-warning" role="button">
                                <span class="glyphicon glyphicon-pencil"></span>
                                <span class="">{{trans('core::shared.edit-btn')}}</span>
                            </a>
                        @endif

                        @if(auth()->user()->can('books.destroy'))
                            {{-- Formulario para eliminar registro --}}
                            {!! Form::open(['route' => ['books.destroy', $book->id], 'method' => 'DELETE', 'class' => 'form-inline display-inline']) !!}
                                
                                {{-- Botón muestra ventana modal de confirmación para el envío de formulario de eliminar el registro --}}
                                <button type="button"
                                        class="btn btn-danger bootbox-dialog"
                                        role="button"
                                        data-toggle="tooltip"
                                        data-placement="top"
                                        {{-- Setup de ventana modal de confirmación --}}
                                        data-modalMessage="{{trans('core::shared.modal-delete-message', ['item' => $book->name])}}"
                                        data-modalTitle="{{trans('core::shared.modal-delete-title')}}"
                                        data-btnLabel="{{trans('core::shared.modal-delete-btn-confirm')}}"
                                        data-btnClassName="btn-danger"
                                        title="{{trans('core::shared.trash-btn')}}">
                                    <span class="fa fa-trash"></span>
                                    <span class="">{{trans('core::shared.trash-btn')}}</span>
                                </button>
                            
                            {!! Form::close() !!}
                        @endif
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

@endsection
{{-- /page content --}}

{{-- view scripts--}}
@section('scripts')
@include('books.partials.form-scripts')
@endsection()