<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
@extends('<?=config('llstarscreamll.CrudGenerator.config.layout')?>')

@section('title') <?=$gen->titlePlural()?> @stop

@section('content')

	<div class="content-header">
        <h1><a href="{{route('<?=$gen->route()?>.index')}}"><?= $gen->titlePlural() ?></a></h1>
    </div>
    
    <div class="content">
        
        <div class="box">
            
            <div class="box-header">
                @include ('CoreModule::layout.notifications')
            </div>

            <div class="panel-body">

	    		{!! Form::model($<?=$gen->modelVariableName()?>, ['route' => ['<?=$gen->route()?>.update', '$<?=$gen->modelVariableName()?>->id'], 'method' => 'PUT']) !!}

					@include('<?=$gen->viewsDirName()?>.partials.create-form')
					<div class="clearfix"></div>
					<div class="form-group col-sm-6">
			        	<button type="submit" class="btn btn-warning">Editar</button>
					</div>

			    {!! Form::close() !!}

			</div>
        </div>
    </div>
@endsection