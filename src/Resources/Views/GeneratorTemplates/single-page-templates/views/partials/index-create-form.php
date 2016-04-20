<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>
<!-- Modal -->
<div class="modal fade" id="create-form-modal" tabindex="-1" role="dialog" aria-labelledby="Crear Nuevo <?=$gen->titleSingular()?>">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Crear Nuevo <?=$gen->titleSingular()?></h4>
            </div>
            <div class="modal-body">

                {!! Form::open(['route' => '<?=$gen->route()?>.store', 'method' => 'POST']) !!}

                    @include('<?=$gen->viewsDirName()?>.partials.create-form')
                    <div class="clearfix"></div>
                    <div class="form-group col-sm-6">
                    <button type="submit" class="btn btn-primary">Crear</button>
                    </div>
                    <div class="clearfix"></div>
                    
                {!! Form::close() !!}

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
