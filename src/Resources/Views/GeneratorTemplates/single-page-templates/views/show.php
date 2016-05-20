<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
@extends('<?=config('llstarscreamll.CrudGenerator.config.layout')?>')

@section('title') {{trans('<?=$gen->getLangAccess()?>/views.show.name').trans('<?=$gen->getLangAccess()?>/views.module.name-singular')}} @stop

@section('content')

    <div class="content-header">
        <h1>
            <a href="{{route('<?=$gen->route()?>.index')}}">{{trans('<?=$gen->getLangAccess()?>/views.module.name')}}</a>
            <small>{{trans('<?=$gen->getLangAccess()?>/views.show.name')}}</small>
        </h1>
    </div>
    
    <div class="content">
        
        <div class="box">
            
            <div class="box-header">
                @include ('CoreModule::layout.notifications')
            </div>

            <div class="panel-body">

			    {!! Form::model($<?=$gen->modelVariableName()?>, []) !!}

					@include('<?=$gen->viewsDirName()?>.partials.form-fields', ['show' => true])

                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <a href="{{route('<?=$gen->route()?>.edit', $<?=$gen->modelVariableName()?>->id)}}" class="btn btn-warning" role="button">
                            <span class="glyphicon glyphicon-pencil"></span>
                            <span class="">{{trans('<?=$gen->getLangAccess()?>/views.show.btn-edit')}}</span>
                        </a>
                    </div>

			    {!! Form::close() !!}
			</div>
        </div>
    </div>

@endsection