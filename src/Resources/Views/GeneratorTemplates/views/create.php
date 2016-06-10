<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
@extends('<?=config('llstarscreamll.CrudGenerator.config.layout')?>')

@section('title') {{trans('<?=$gen->getLangAccess()?>/views.create.name').trans('<?=$gen->getLangAccess()?>/views.module.name-singular')}} @stop

@section('style')

@endsection

@section('content')

    <div class="content-header">
        <h1>
            <a href="{{route('<?=$gen->route()?>.index')}}">{{trans('<?=$gen->getLangAccess()?>/views.module.name')}}</a>
            <small>{{trans('<?=$gen->getLangAccess()?>/views.create.name')}}</small>
        </h1>
    </div>
    
    <div class="content">
        
        <div class="box">
            
            <div class="box-header">
                @include ('<?=config('llstarscreamll.CrudGenerator.config.layout-namespace')?>layout.notifications')
            </div>

            <div class="panel-body">
                
                {!! Form::open(['route' => '<?=$gen->route()?>.store', 'method' => 'POST', 'name' => 'create-<?=$gen->getDashedModelName()?>-form']) !!}

                    @include('<?=$gen->viewsDirName()?>.partials.form-fields')

                    <div class="clearfix"></div>
                    
                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            <span class="">{{trans('<?=$gen->getLangAccess()?>/views.create.btn-create')}}</span>
                        </button>
                        <span id="helpBlock" class="help-block">{!!trans('<?=$gen->getLangAccess()?>/views.inputs-required-help')!!}</span>
                    </div>

                {!! Form::close() !!}
                
            </div>
        </div>
    </div>

@endsection

@section('script')

    <script type="text/javascript">
        
<?php if ($gen->hasTinyintTypeField($fields)) { ?>
        {{-- Inicializa el componente SwitchBootstrap --}}
        $(".bootstrap_switch").bootstrapSwitch();
<?php } ?>
        
    </script>

@endsection()