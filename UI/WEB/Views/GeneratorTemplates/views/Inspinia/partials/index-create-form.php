<?php
/* @var $gen App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Ventana Modal con Formulario de Creación.
    ____________________________________________________________________________
    Contiene ventana modal con el formulario de creación (partials.form-fields),
    útil si no se desea cargar otra vista para crear un registro, esta vista es
    cargada desde la vista index.
    ****************************************************************************

    <?= $gen->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

<div class="modal fade" id="create-form-modal" tabindex="-1" role="dialog" arialedby="{{trans('<?=$gen->getLangAccess()?>.index-create-form-modal-title')}}">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{trans('<?=$gen->getLangAccess()?>.index-create-form-modal-title')}}</h4>
            </div>

            <div class="modal-body">

                {!! Form::open(['route' => '<?=$gen->route()?>.store', 'method' => 'POST']) !!}

                    @include('<?=$gen->viewsDirName()?>.partials.form-fields')
                    
                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            <span class="">{{trans('<?= $gen->solveSharedResourcesNamespace() ?>.create-btn')}}</span>
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span>
                            <span>Cerrar</span>
                        </button>
                        <span id="helpBlock" class="help-block">{!!trans('<?= $gen->solveSharedResourcesNamespace() ?>.inputs-required-msg')!!}</span>
                    </div>
                    <div class="clearfix"></div>
                    
                {!! Form::close() !!}

            </div>
            
        </div>

    </div>
</div>
