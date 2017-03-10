<?php
/* @var $gen App\Containers\Crud\Providers\TestsGenerator */
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

@extends('<?=config('modules.crud.config.layout')?>')

{{-- page title --}}
@section('title') {{trans('<?= $gen->solveSharedResourcesNamespace() ?>.views.edit').trans('<?=$gen->getLangAccess()?>.module.name-singular')}} @endsection
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('<?=$gen->viewsDirName()?>.partials.heading', ['small_title' => trans('<?= $gen->solveSharedResourcesNamespace() ?>.views.edit')])
    
{{-- content --}}
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-xs-12 animated fadeInRight">
            <div class="ibox float-e-margins">

            {{-- box content --}}
            <div class="ibox-content">

                @include ('<?=config('modules.crud.config.layout-namespace')?>partials.notifications')

                {!! Form::model(
                    $<?=$gen->modelVariableName()?>,
                    [
                        'route' => ['<?=$gen->route()?>.update', $<?=$gen->modelVariableName()?>->id],
                        'method' => 'PUT',
                        'name' => 'edit-<?=$gen->getDashedModelName()?>-form'
                    ]
                ) !!}

                    @include('<?=$gen->viewsDirName()?>.partials.form-fields')

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-warning">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <span class="">{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.edit-btn')}}</span> 
                        </button>
                        <span id="helpBlock" class="help-block">{!!trans('<?= $gen->solveSharedResourcesNamespace() ?>.inputs-required-msg')!!}</span>
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
<?php if ($request->get('include_assets', false)) { ?>
@include('<?=$gen->viewsDirName()?>.partials.form-assets')
<?php } ?>
@include('<?=$gen->viewsDirName()?>.partials.form-scripts')
@endsection()