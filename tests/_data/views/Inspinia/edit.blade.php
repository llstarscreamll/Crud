@extends('core::layouts.app-sidebar')

{{-- page title --}}
@section('title') {{trans('book/views.edit.name').trans('book/views.module.name-singular')}} @endsection
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('books.partials.heading', ['module_section' => trans('book/views.edit.name')])
    
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
                        'route' => ['books.update',
                        $book->id],
                        'method' => 'PUT',
                        'name' => 'edit-books-form'
                    ]
                ) !!}

                    @include('books.partials.form-fields')

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-warning">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <span class="">{{trans('book/views.edit.btn-edit')}}</span> 
                        </button>
                        <span id="helpBlock" class="help-block">{!!trans('book/views.inputs-required-help')!!}</span>
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