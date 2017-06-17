<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Show.
    ____________________________________________________________________________
    Muestra la vista de detalles de un registro.
    ****************************************************************************

    <?= $crud->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

@extends('<?=config('modules.crud.config.layout')?>')

{{-- page title --}}
@section('title') {{trans('<?= $crud->solveSharedResourcesNamespace() ?>.views.show').trans('<?=$crud->getLangAccess()?>.module.name-singular')}} @stop
{{-- /page title --}}

{{-- view styles --}}
@section('styles')
@endsection
{{-- /view styles --}}

{{-- page content --}}
@section('content')

{{-- heading --}}
@include('<?=$crud->viewsDirName()?>.partials.heading', ['small_title' => trans('<?= $crud->solveSharedResourcesNamespace() ?>.views.show')])
    
{{-- content --}}
<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-xs-12 animated fadeInRight">
            <div class="ibox float-e-margins">

            {{-- box content --}}
            <div class="ibox-content">

                @include ('<?=config('modules.crud.config.layout-namespace')?>partials.notifications')

                {!! Form::model(
                    $<?=$crud->modelVariableName()?>,
                    [
                        'name' => 'show-<?=$crud->getDashedModelName()?>-form',
                        'data-show' => ($show = true)
                    ]
                ) !!}

                    <div class='form-group col-sm-6 {{$errors->has('id') ? 'has-error' : ''}}'>
                        {!! Form::label('id', trans('<?=$crud->getLangAccess()?>.form-labels.id')) !!}
                        {!! Form::input('text', 'id', null, ['class' => 'form-control', isset($show) ? 'disabled' : '']) !!}
                    </div>

                    <div class="clearfix"></div>

                    @include('<?=$crud->viewsDirName()?>.partials.form-fields', ['show' => ($show = true)])

                    <div class="clearfix"></div>

                    @include('<?=$crud->viewsDirName()?>.partials.hidden-form-fields', ['show' => ($show = true)])

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        @if(auth()->user()->can('<?=$crud->route()?>.edit'))
                            <a href="{{route('<?=$crud->route()?>.edit', $<?=$crud->modelVariableName()?>->id)}}" class="btn btn-warning" role="button">
                                <span class="glyphicon glyphicon-pencil"></span>
                                <span class="">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.edit-btn')}}</span>
                            </a>
                        @endif

                        @if(auth()->user()->can('<?=$crud->route()?>.destroy'))
                            {{-- Formulario para eliminar registro --}}
                            {!! Form::open(['route' => ['<?=$crud->route()?>.destroy', $<?=$crud->modelVariableName()?>->id], 'method' => 'DELETE', 'class' => 'form-inline display-inline']) !!}
                                
                                {{-- Botón muestra ventana modal de confirmación para el envío de formulario de eliminar el registro --}}
                                <button type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>"
                                        class="btn btn-danger <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                                        role="button"
                                        data-toggle="tooltip"
                                        data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                                        {{-- Setup de ventana modal de confirmación --}}
                                        data-modalMessage="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-<?= $crud->getDestroyVariableName() ?>-message', ['item' => $<?=$crud->modelVariableName()?>->name])}}"
                                        data-modalTitle="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-<?= $crud->getDestroyVariableName() ?>-title')}}"
                                        data-btnLabel="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.modal-<?= $crud->getDestroyVariableName() ?>-btn-confirm')}}"
                                        data-btnClassName="btn-danger"
<?php } else { ?>
                                        onclick="return confirm('{{ trans('<?=$crud->getLangAccess()?>.index.<?= $crud->getDestroyVariableName() ?>-confirm-message') }}')"
<?php } ?>
                                        title="{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.<?= $crud->getDestroyVariableName() ?>-btn')}}">
                                    <span class="fa fa-<?= $crud->getDestroyVariableName() == 'trash' ? 'trash' : 'minus-circle' ?>"></span>
                                    <span class="">{{trans('<?= $crud->solveSharedResourcesNamespace() ?>.<?= $crud->getDestroyVariableName() ?>-btn')}}</span>
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
<?php if ($request->get('include_assets', false)) { ?>
@include('<?=$crud->viewsDirName()?>.partials.form-assets')
<?php } ?>
@include('<?=$crud->viewsDirName()?>.partials.form-scripts')
@endsection()