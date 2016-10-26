{{--
    ****************************************************************************
    Los campos del formulario de búsqueda de tabla.
    ____________________________________________________________________________
    En caso de que se desee reutilizar esta vista y esconder la columna de los
    checkbox, al llamar esta vista enviar la variable:
    $hide_checkboxes_column = true

    Si se desea ocultar la columna de acciones, al llamar la vista enviar la
    variable:
    $hide_actions_column = true
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

<tr class="search-row">
    @if(!isset($hide_checkboxes_column))
    <td class="checkbox-column">
        {!! Form::checkbox('check_all', 'check_all', null, ['id' => 'check_all']) !!}
    </td>
    @endif
    <td class="id">
        {!! Form::input('number', 'id', Request::input('id'), ['form' => 'searchForm', 'class' => 'form-control']) !!}
    </td>
    <td class="reason_id">
        {!! Form::select(
		'reason_id[]',
		$reason_id_list,
		Request::input('reason_id'),
		[
			'class' => 'form-control selectpicker',
			'data-live-search' => 'false',
			'data-size' => '5',
			'title' => '---',
			'data-selected-text-format' => 'count > 0',
			'multiple',
			'form' => 'searchForm'
		]
	) !!}
    </td>
    <td class="name">
        {!! Form::input('text', 'name', Request::input('name'), ['form' => 'searchForm', 'class' => 'form-control']) !!}
    </td>
    <td class="author">
        {!! Form::input('text', 'author', Request::input('author'), ['form' => 'searchForm', 'class' => 'form-control']) !!}
    </td>
    <td class="genre">
        {!! Form::input('text', 'genre', Request::input('genre'), ['form' => 'searchForm', 'class' => 'form-control']) !!}
    </td>
    <td class="stars">
        {!! Form::input('number', 'stars', Request::input('stars'), ['form' => 'searchForm', 'class' => 'form-control']) !!}
    </td>
    <td class="published_year">
        {!! Form::input('text', 'published_year[informative]', Request::input('published_year')['informative'], ['form' => 'searchForm', 'class' => 'form-control']) !!}
		{!! Form::input('hidden', 'published_year[from]', Request::input('published_year')['from'], ['form' => 'searchForm']) !!}
		{!! Form::input('hidden', 'published_year[to]', Request::input('published_year')['to'], ['form' => 'searchForm']) !!}
    </td>
    <td class="enabled">
        <label>
			{!! Form::checkbox('enabled_true', true, Request::input('enabled_true'), ['class' => 'icheckbox_square-blue', 'form' => 'searchForm']) !!}
		</label>
		<label>
			{!! Form::checkbox('enabled_false', true, Request::input('enabled_false'), ['class' => 'icheckbox_square-red', 'form' => 'searchForm']) !!}
		</label>
    </td>
    <td class="status">
        {!! Form::select(
		'status[]',
		$status_list,
		Request::input('status'),
		[
			'class' => 'form-control selectpicker',
			'data-live-search' => 'false',
			'data-size' => '5',
			'title' => '---',
			'data-selected-text-format' => 'count > 0',
			'multiple',
			'form' => 'searchForm'
		]
	) !!}
    </td>
    <td class="synopsis">
        {!! Form::input('text', 'synopsis', Request::input('synopsis'), ['form' => 'searchForm', 'class' => 'form-control']) !!}
    </td>
    <td class="approved_at">
        {!! Form::input('text', 'approved_at[informative]', Request::input('approved_at')['informative'], ['form' => 'searchForm', 'class' => 'form-control']) !!}
		{!! Form::input('hidden', 'approved_at[from]', Request::input('approved_at')['from'], ['form' => 'searchForm']) !!}
		{!! Form::input('hidden', 'approved_at[to]', Request::input('approved_at')['to'], ['form' => 'searchForm']) !!}
    </td>
    <td class="approved_by">
        {!! Form::select(
		'approved_by[]',
		$approved_by_list,
		Request::input('approved_by'),
		[
			'class' => 'form-control selectpicker',
			'data-live-search' => 'false',
			'data-size' => '5',
			'title' => '---',
			'data-selected-text-format' => 'count > 0',
			'multiple',
			'form' => 'searchForm'
		]
	) !!}
    </td>
    <td class="created_at">
        {!! Form::input('text', 'created_at[informative]', Request::input('created_at')['informative'], ['form' => 'searchForm', 'class' => 'form-control']) !!}
		{!! Form::input('hidden', 'created_at[from]', Request::input('created_at')['from'], ['form' => 'searchForm']) !!}
		{!! Form::input('hidden', 'created_at[to]', Request::input('created_at')['to'], ['form' => 'searchForm']) !!}
    </td>
    <td class="updated_at">
        {!! Form::input('text', 'updated_at[informative]', Request::input('updated_at')['informative'], ['form' => 'searchForm', 'class' => 'form-control']) !!}
		{!! Form::input('hidden', 'updated_at[from]', Request::input('updated_at')['from'], ['form' => 'searchForm']) !!}
		{!! Form::input('hidden', 'updated_at[to]', Request::input('updated_at')['to'], ['form' => 'searchForm']) !!}
    </td>
    <td class="deleted_at">
        {!! Form::input('text', 'deleted_at[informative]', Request::input('deleted_at')['informative'], ['form' => 'searchForm', 'class' => 'form-control']) !!}
		{!! Form::input('hidden', 'deleted_at[from]', Request::input('deleted_at')['from'], ['form' => 'searchForm']) !!}
		{!! Form::input('hidden', 'deleted_at[to]', Request::input('deleted_at')['to'], ['form' => 'searchForm']) !!}
    </td>
    
    @if(!isset($hide_actions_column))
    {{-- Botones de búsqueda, limpieza del formulario y opciones de búsqueda --}}
    <td class="actions-column" style="min-width: 10em;">

        {{-- Más opciones de filtros --}}
        <div class="dropdown display-inline-table"
             data-toggle="tooltip"
             data-placement="top"
             title="{{ trans('book/views.index.filters-button-label') }}">
            
            <button class="btn btn-default btn-sm dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                <span class="sr-only">{{ trans('book/views.index.filters-button-label') }}</span>
                <span class="glyphicon glyphicon-filter"></span>
            </button>

            <ul class="dropdown-menu dropdown-menu-right prevent-hide" aria-labelledby="dropdownMenu1">
                <li class="dropdown-header">{{ trans('book/views.index.filters-button-label') }}</li>
                <li role="separator" class="divider"></li>
                {{-- Con registros en papelera --}}
                <li>
                    <div class="checkbox">
                        <label>
                            {!! Form::radio('trashed_records', 'withTrashed', Request::input('trashed_records') == 'withTrashed' ? true : false, ['form' => 'searchForm']) !!}
                            {{ trans('book/views.index.filter-with-trashed-label') }}
                        </label>
                    </div>
                </li>
                {{-- Sólo registros en papelera --}}
                <li>
                    <div class="checkbox">
                        <label>
                            {!! Form::radio('trashed_records', 'onlyTrashed', Request::input('trashed_records') == 'onlyTrashed' ? true : false, ['form' => 'searchForm']) !!}
                            {{ trans('book/views.index.filter-only-trashed-label') }}
                        </label>
                    </div>
                </li>
            </ul>
        </div>
        
        {{-- Ejecuta la búsqueda --}}
        <button type="submit"
                form="searchForm"
                class="btn btn-primary btn-sm"
                data-toggle="tooltip"
                data-placement="top"
                title="{{trans('book/views.index.search-button-label')}}">
            <span class="fa fa-search"></span>
            <span class="sr-only">{{trans('book/views.index.search-button-label')}}</span>
        </button>

        {{-- Recarga la página restableciendo los campos de búsqueda --}}
        <a  href="{{route('books.index')}}"
            class="btn btn-danger btn-sm"
            role="button"
            data-toggle="tooltip"
            data-placement="top"
            title="{{trans('book/views.index.clean-filter-button-label')}}">
            <span class="glyphicon glyphicon-remove"></span>
            <span class="sr-only">{{trans('book/views.index.clean-filter-button-label')}}</span>
        </a>

    </td>
    @endif
</tr>