{{--
    ****************************************************************************
    Los nombres de las columnas de la tabla.
    ____________________________________________________________________________
    Aquí se muestran los nombres de columnas de la tabla, los cuales son enlaces
    que ordenan los resultados de la consulta ascendente o descendentemente.

    En caso de que se desee reutilizar esta vista y esconder la columna de los
    checkbox, al llamar esta vista enviar la variable:
    $hide_checkboxes_column = true

    Si se desea ocultar la columna de acciones, al llamar la vista enviar la
    variable:
    $hide_actions_column = true
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

<tr class="header-row">
    @if(!isset($hide_checkboxes_column))
        <th class="checkbox-column"></th>
    @endif
    @if(in_array('id', $selectedTableColumns))
    <th class="id">
        {!! UI::sortLink('books.index', trans('book.table-columns.id'), 'id') !!}
    </th>
    @endif
    @if(in_array('reason_id', $selectedTableColumns))
    <th class="reason_id">
        {!! UI::sortLink('books.index', trans('book.table-columns.reason_id'), 'reason_id') !!}
    </th>
    @endif
    @if(in_array('name', $selectedTableColumns))
    <th class="name">
        {!! UI::sortLink('books.index', trans('book.table-columns.name'), 'name') !!}
    </th>
    @endif
    @if(in_array('author', $selectedTableColumns))
    <th class="author">
        {!! UI::sortLink('books.index', trans('book.table-columns.author'), 'author') !!}
    </th>
    @endif
    @if(in_array('genre', $selectedTableColumns))
    <th class="genre">
        {!! UI::sortLink('books.index', trans('book.table-columns.genre'), 'genre') !!}
    </th>
    @endif
    @if(in_array('stars', $selectedTableColumns))
    <th class="stars">
        {!! UI::sortLink('books.index', trans('book.table-columns.stars'), 'stars') !!}
    </th>
    @endif
    @if(in_array('published_year', $selectedTableColumns))
    <th class="published_year">
        {!! UI::sortLink('books.index', trans('book.table-columns.published_year'), 'published_year') !!}
    </th>
    @endif
    @if(in_array('enabled', $selectedTableColumns))
    <th class="enabled">
        {!! UI::sortLink('books.index', trans('book.table-columns.enabled'), 'enabled') !!}
    </th>
    @endif
    @if(in_array('status', $selectedTableColumns))
    <th class="status">
        {!! UI::sortLink('books.index', trans('book.table-columns.status'), 'status') !!}
    </th>
    @endif
    @if(in_array('synopsis', $selectedTableColumns))
    <th class="synopsis">
        {!! UI::sortLink('books.index', trans('book.table-columns.synopsis'), 'synopsis') !!}
    </th>
    @endif
    @if(in_array('approved_at', $selectedTableColumns))
    <th class="approved_at">
        {!! UI::sortLink('books.index', trans('book.table-columns.approved_at'), 'approved_at') !!}
    </th>
    @endif
    @if(in_array('approved_by', $selectedTableColumns))
    <th class="approved_by">
        {!! UI::sortLink('books.index', trans('book.table-columns.approved_by'), 'approved_by') !!}
    </th>
    @endif
    @if(in_array('created_at', $selectedTableColumns))
    <th class="created_at">
        {!! UI::sortLink('books.index', trans('book.table-columns.created_at'), 'created_at') !!}
    </th>
    @endif
    @if(in_array('updated_at', $selectedTableColumns))
    <th class="updated_at">
        {!! UI::sortLink('books.index', trans('book.table-columns.updated_at'), 'updated_at') !!}
    </th>
    @endif
    @if(in_array('deleted_at', $selectedTableColumns))
    <th class="deleted_at">
        {!! UI::sortLink('books.index', trans('book.table-columns.deleted_at'), 'deleted_at') !!}
    </th>
    @endif
    @if(!isset($hide_actions_column))
        <th class="actions-column">{{trans('core::shared.table-actions-column')}}</th>
    @endif
</tr>
