{{--
    ****************************************************************************
    Heading de las Vistas.
    ____________________________________________________________________________
    Muestra el header utilizado en las vistas index, create, show y edit.
    Opcionalmente se puede mostrar un texto junto al título de la página dentro
    de un tag <small> enviando el valor por medio de una variable que se llame
    $small_title.
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

{{-- heading --}}
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-xs-12">
        <h2>
            <a href="{{route('books.index')}}">{{trans('book.module.name')}}</a>
            <small>{{ isset($small_title) ? $small_title : null }}</small>
        </h2>
    </div>
</div>
{{-- /heading --}}