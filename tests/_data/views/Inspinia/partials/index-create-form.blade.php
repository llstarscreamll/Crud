{{--
    ****************************************************************************
    Ventana Modal con Formulario de Creación.
    ____________________________________________________________________________
    Contiene ventana modal con el formulario de creación (partials.form-fields),
    útil si no se desea cargar otra vista para crear un registro, esta vista es
    cargada desde la vista index.
    ****************************************************************************

    Este archivo es parte de Books.
    (c) Johan Alvarez <llstarscreamll@hotmail.com>
    Licensed under The MIT License (MIT).

    @package    Books
    @version    0.1
    @author     Johan Alvarez
    @license    The MIT License (MIT)
    @copyright  (c) 2015-2016, Johan Alvarez <llstarscreamll@hotmail.com>
    @link       https://github.com/llstarscreamll
    
    ****************************************************************************
--}}

<div class="modal fade" id="create-form-modal" tabindex="-1" role="dialog" arialedby="{{trans('book.index-create-form-modal-title')}}">
    <div class="modal-dialog modal-lg" role="document">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{trans('book.index-create-form-modal-title')}}</h4>
            </div>

            <div class="modal-body">

                {!! Form::open(['route' => 'books.store', 'method' => 'POST']) !!}

                    @include('books.partials.form-fields')
                    
                    <div class="clearfix"></div>

                    <div class="form-group col-sm-6">
                        <button type="submit" class="btn btn-primary">
                            <span class="glyphicon glyphicon-floppy-disk"></span>
                            <span class="">{{trans('core::shared.create-btn')}}</span>
                        </button>
                        <button type="button" class="btn btn-danger" data-dismiss="modal">
                            <span class="glyphicon glyphicon-remove"></span>
                            <span>Cerrar</span>
                        </button>
                        <span id="helpBlock" class="help-block">{!!trans('core::shared.inputs-required-msg')!!}</span>
                    </div>
                    <div class="clearfix"></div>
                    
                {!! Form::close() !!}

            </div>
            
        </div>

    </div>
</div>
