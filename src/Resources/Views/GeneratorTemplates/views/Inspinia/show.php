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
                        @if(auth()->user()->can('<?=$gen->route()?>.edit'))
                            <a href="{{route('<?=$gen->route()?>.edit', $<?=$gen->modelVariableName()?>->id)}}" class="btn btn-warning" role="button">
                                <span class="glyphicon glyphicon-pencil"></span>
                                <span class="">{{trans('<?=$gen->getLangAccess()?>/views.show.btn-edit')}}</span>
                            </a>
                        @endif

                        @if(auth()->user()->can('<?=$gen->route()?>.destroy'))
                            {{-- Formulario para eliminar registro --}}
                            {!! Form::open(['route' => ['<?=$gen->route()?>.destroy', $<?=$gen->modelVariableName()?>->id], 'method' => 'DELETE', 'class' => 'form-inline display-inline']) !!}
                                
                                {{-- Botón muestra ventana modal de confirmación para el envío de formulario de eliminar el registro --}}
                                <button type="<?= $request->has('use_modal_confirmation_on_delete') ? 'button' : 'submit' ?>"
                                        class="btn btn-danger <?= $request->has('use_modal_confirmation_on_delete') ? 'bootbox-dialog' : null ?>"
                                        role="button"
                                        data-toggle="tooltip"
                                        data-placement="top"
<?php if ($request->has('use_modal_confirmation_on_delete')) { ?>
                                        {{-- Setup de ventana modal de confirmación --}}
                                        data-modalMessage="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-message', ['item' => $<?=$gen->modelVariableName()?>->name])}}"
                                        data-modalTitle="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-title')}}"
                                        data-btnLabel="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-btn-confirm-label')}}"
                                        data-btnClassName="{{trans('<?=$gen->getLangAccess()?>/views.index.modal-delete-btn-confirm-class-name')}}"
<?php } else { ?>
                                        onclick="return confirm('{{ trans('<?=$gen->getLangAccess()?>/views.index.delete-confirm-message') }}')"
<?php } ?>
                                        title="{{trans('<?=$gen->getLangAccess()?>/views.index.delete-item-button-label')}}">
                                    <span class="fa fa-trash"></span>
                                    <span class="">{{trans('<?=$gen->getLangAccess()?>/views.index.delete-item-button-label')}}</span>
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

@include('<?=$gen->viewsDirName()?>.partials.form-assets')
@include('<?=$gen->viewsDirName()?>.partials.form-scripts')

@endsection()