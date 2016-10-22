<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Show.
    ____________________________________________________________________________
    Muestra la vista de detalles de un registro.
    ****************************************************************************

    <?= $gen->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

@extends('<?=config('modules.CrudGenerator.config.layout')?>')

{{-- page title --}}
@section('title') {{trans('<?=$gen->getLangAccess()?>/views.show.name').trans('<?=$gen->getLangAccess()?>/views.module.name-singular')}} @stop
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('<?=$gen->viewsDirName()?>.partials.heading', ['small_title' => trans('<?=$gen->getLangAccess()?>/views.show.name')])
    
{{-- content --}}
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-xs-12 animated fadeInRight">
            <div class="ibox float-e-margins">

            {{-- box content --}}
            <div class="ibox-content">

                @include ('<?=config('modules.CrudGenerator.config.layout-namespace')?>partials.notifications')

                {!! Form::model(
                    $<?=$gen->modelVariableName()?>,
                    [
                        'name' => 'show-<?=$gen->getDashedModelName()?>-form',
                        'data-show' => ($show = true)
                    ]
                ) !!}

                    <div class='form-group col-sm-6 {{$errors->has('id') ? 'has-error' : ''}}'>
                        {!! Form::label('id', trans('<?=$gen->getLangAccess()?>/views.form-fields.id')) !!}
                        {!! Form::input('text', 'id', null, ['class' => 'form-control', isset($show) ? 'disabled' : '']) !!}
                    </div>

                    <div class="clearfix"></div>

                    @include('<?=$gen->viewsDirName()?>.partials.form-fields', ['show' => ($show = true)])

                    <div class="clearfix"></div>

                    @include('<?=$gen->viewsDirName()?>.partials.hidden-form-fields', ['show' => ($show = true)])

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <a href="{{route('<?=$gen->route()?>.edit', $<?=$gen->modelVariableName()?>->id)}}" class="btn btn-warning" role="button">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <span class="">{{trans('<?=$gen->getLangAccess()?>/views.show.btn-edit')}}</span>
                        </a>
                        <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal_confirm">
                            <span class="glyphicon glyphicon-trash"></span>
                            <span class="">{{trans('<?=$gen->getLangAccess()?>/views.show.btn-trash')}}</span>
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
            <h4 class="modal-title" id="ModalLabel">{{trans('<?=$gen->getLangAccess()?>/views.show.modal-confirm-trash-title')}}</h4>
        </div>

        <div class="modal-body">
            <p>{!!trans('<?=$gen->getLangAccess()?>/views.show.modal-confirm-trash-body', ['item' => $<?=$gen->modelVariableName()?>-><?=$request->id_for_user?>])!!}</p>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">{{trans('<?=$gen->getLangAccess()?>/views.show.modal-confirm-trash-btn-cancel')}}</button>
            {!! Form::open([
                'route' => ['<?=$gen->route()?>.destroy',
                $<?=$gen->modelVariableName()?>->id],
                'method' => 'DELETE',
                'class' => 'display-inline',
                'name' => 'delete-<?=$gen->getDashedModelName()?>-form'
            ]) !!}
                <button type="submit" class="btn btn-danger">
                    <span>{{trans('<?=$gen->getLangAccess()?>/views.show.modal-confirm-trash-btn-confirm')}}</span>
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

@include('<?=$gen->viewsDirName()?>.partials.form-assets')
@include('<?=$gen->viewsDirName()?>.partials.form-scripts')

@endsection()