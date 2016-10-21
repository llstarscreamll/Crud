{{--
    ****************************************************************************
    Create.
    ____________________________________________________________________________
    Muestra la vista de creación de registros.
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
@section('title') {{trans('book/views.create.name').trans('book/views.module.name-singular')}} @stop
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('books.partials.heading', ['module_section' => trans('book/views.create.name')])
    
{{-- content --}}
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-xs-12 animated fadeInRight">
            <div class="ibox float-e-margins">

            {{-- box content --}}
            <div class="ibox-content">

                @include ('core::partials.notifications')
                
                {!! Form::open([
                    'route' => 'books.store',
                    'method' => 'POST',
                    'name' => 'create-books-form'
                ]) !!}

                    @include('books.partials.form-fields')

                    <div class="clearfix"></div>
                    
                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            <span class="">{{trans('book/views.create.btn-create')}}</span>
                        </button>
                        <span id="helpBlock" class="help-block">
                            {!!trans('book/views.inputs-required-help')!!}
                        </span>
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

@include('books.partials.form-assets')
@include('books.partials.form-scripts')

@endsection()