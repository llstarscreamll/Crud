<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Edit.
    ____________________________________________________________________________
    Muestra la vista de edición de registros.
    ****************************************************************************

    <?= $gen->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

@extends('<?=config('modules.CrudGenerator.config.layout')?>')

{{-- page title --}}
@section('title') {{trans('<?=$gen->getLangAccess()?>/views.edit.name').trans('<?=$gen->getLangAccess()?>/views.module.name-singular')}} @endsection
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('<?=$gen->viewsDirName()?>.partials.heading', ['small_title' => trans('<?=$gen->getLangAccess()?>/views.edit.name')])
    
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
                        'route' => ['<?=$gen->route()?>.update',
                        $<?=$gen->modelVariableName()?>->id],
                        'method' => 'PUT',
                        'name' => 'edit-<?=$gen->getDashedModelName()?>-form'
                    ]
                ) !!}

                    @include('<?=$gen->viewsDirName()?>.partials.form-fields')

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-warning">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <span class="">{{trans('<?=$gen->getLangAccess()?>/views.edit.btn-edit')}}</span> 
                        </button>
                        <span id="helpBlock" class="help-block">{!!trans('<?=$gen->getLangAccess()?>/views.inputs-required-help')!!}</span>
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

@include('<?=$gen->viewsDirName()?>.partials.form-assets')
@include('<?=$gen->viewsDirName()?>.partials.form-scripts')

@endsection()