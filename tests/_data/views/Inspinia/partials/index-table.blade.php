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

    Este archivo es parte del Books.
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

{!! Form::open(['route' => 'books.index', 'method' => 'GET', 'id' => 'searchForm']) !!}
{!! Form::close() !!}

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            {{-- header de la tabla --}}
            @include('books.partials.index-table-header')

            {{-- formulario de búsqueda --}}
            @include('books.partials.index-table-search')
        </thead>

        <tbody>
            {{-- body de tabla --}}
            @include('books.partials.index-table-body')
        </tbody>
    </table>
</div>

{!! $records->appends(Request::query())->render() !!}

<div>
    <strong>Notas:</strong>
    <ul>
        <li>Los registros que están "Eliminados", se muestran con <span class="bg-danger">Fondo Rojo</span>.</li>
    </ul>
</div>