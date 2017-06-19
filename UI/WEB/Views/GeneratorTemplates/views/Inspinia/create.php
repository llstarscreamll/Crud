<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Create.
    ____________________________________________________________________________
    Muestra la vista de creación de registros.
    ****************************************************************************

    <?= $crud->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

@extends('<?=config('modules.crud.config.layout')?>')

{{-- page title --}}
@section('title') {{ trans('<?=$crud->getLangAccess()?>.index-create-btn') }} @endsection
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('<?=$crud->viewsDirName()?>.partials.heading', ['small_title' => trans('<?= $crud->solveSharedResourcesNamespace() ?>.views.create')])
    
{{-- content --}}
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-xs-12 animated fadeInRight">
            <div class="ibox float-e-margins">

            {{-- box content --}}
            <div class="ibox-content">

                @include ('<?=config('modules.crud.config.layout-namespace')?>partials.notifications')
                
                {!! Form::open([
                    'route' => '<?=$crud->route()?>.store',
                    'method' => 'POST',
                    'name' => 'create-<?=$crud->getDashedModelName()?>-form'
                ]) !!}

                    @include('<?=$crud->viewsDirName()?>.partials.form-fields')

                    <div class="clearfix"></div>
                    
                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            <span class="">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.create-btn')}}</span>
                        </button>
                        <span id="helpBlock" class="help-block">
                            {!!trans('<?= $crud->solveSharedResourcesNamespace() ?>.inputs-required-msg')!!}
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
<?php if ($request->get('include_assets', false)) { ?>
@include('<?=$crud->viewsDirName()?>.partials.form-assets')
<?php } ?>
<?php ?>
@include('<?=$crud->viewsDirName()?>.partials.form-scripts')
@endsection()