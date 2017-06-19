<?php
/* @var $crud App\Containers\Crud\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>
{{--
    ****************************************************************************
    Tabla Index.
    ____________________________________________________________________________
    Muestra tabla con los registros de la base de datos, cada fila tiene enlaces
    de acceso rápidos a acciones como eliminar, editar o ver detalles del
    registro.

    Usa de los siguientes partials:
    - partials.index-table-header
    - partials.index-table-search
    - partials.index-table-body

    Los links de paginación de los datos se muestran a continuación de la tabla.

    Hay una zona de notas donde se hace aclaraciones de como son mostrados los
    datos mostrados en la tabla.
    ****************************************************************************

    <?= $crud->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

{!! Form::open(['route' => '<?=$crud->route()?>.index', 'method' => 'GET', 'id' => 'searchForm']) !!}
{!! Form::close() !!}

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            {{-- header de la tabla --}}
            @include('<?=$crud->viewsDirName()?>.partials.index-table-header')

            {{-- formulario de búsqueda --}}
            @include('<?=$crud->viewsDirName()?>.partials.index-table-search')
        </thead>

        <tbody>
            {{-- body de tabla --}}
            @include('<?=$crud->viewsDirName()?>.partials.index-table-body')
        </tbody>
    </table>
</div>

{!! $records->appends(Request::query())->render() !!}

<div class="table-notes">
    <strong>Notas:</strong>
    <ul>
<?php if ($crud->hasDeletedAtColumn($fields)) { ?>
        <li>Los registros que están "Eliminados", se muestran con <span class="bg-danger">Fondo Rojo</span>.</li>
<?php } ?>
    </ul>
</div>