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

			    {!! Form::model($<?=$gen->modelVariableName()?>, []) !!}

					@include('<?=$gen->viewsDirName()?>.partials.create-form', ['show' => true])

			    {!! Form::close() !!}
			</div>
        </div>
    </div>

@endsection