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

<tr class="header-row">
    @if(!isset($hide_checkboxes_column))
    <th class="checkbox-column"></th>
    @endif
    <th class="id">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'id',
                'sortType' => (Request::input('sort') == 'id' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.id')}}
            {!!Request::input('sort') == 'id' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="reason_id">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'reason_id',
                'sortType' => (Request::input('sort') == 'reason_id' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.reason_id')}}
            {!!Request::input('sort') == 'reason_id' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="name">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'name',
                'sortType' => (Request::input('sort') == 'name' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.name')}}
            {!!Request::input('sort') == 'name' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="author">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'author',
                'sortType' => (Request::input('sort') == 'author' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.author')}}
            {!!Request::input('sort') == 'author' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="genre">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'genre',
                'sortType' => (Request::input('sort') == 'genre' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.genre')}}
            {!!Request::input('sort') == 'genre' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="stars">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'stars',
                'sortType' => (Request::input('sort') == 'stars' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.stars')}}
            {!!Request::input('sort') == 'stars' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="published_year">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'published_year',
                'sortType' => (Request::input('sort') == 'published_year' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.published_year')}}
            {!!Request::input('sort') == 'published_year' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="enabled">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'enabled',
                'sortType' => (Request::input('sort') == 'enabled' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.enabled')}}
            {!!Request::input('sort') == 'enabled' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="status">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'status',
                'sortType' => (Request::input('sort') == 'status' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.status')}}
            {!!Request::input('sort') == 'status' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="synopsis">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'synopsis',
                'sortType' => (Request::input('sort') == 'synopsis' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.synopsis')}}
            {!!Request::input('sort') == 'synopsis' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="approved_at">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'approved_at',
                'sortType' => (Request::input('sort') == 'approved_at' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.approved_at')}}
            {!!Request::input('sort') == 'approved_at' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="approved_by">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'approved_by',
                'sortType' => (Request::input('sort') == 'approved_by' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.approved_by')}}
            {!!Request::input('sort') == 'approved_by' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="created_at">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'created_at',
                'sortType' => (Request::input('sort') == 'created_at' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.created_at')}}
            {!!Request::input('sort') == 'created_at' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="updated_at">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'updated_at',
                'sortType' => (Request::input('sort') == 'updated_at' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.updated_at')}}
            {!!Request::input('sort') == 'updated_at' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    <th class="deleted_at">
        <a href="{{route('books.index',
            array_merge(
                Request::query(),
                [
                'sort' => 'deleted_at',
                'sortType' => (Request::input('sort') == 'deleted_at' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                ]
            )
        )}}">
            {{trans('book/views.form-fields-short-name.deleted_at')}}
            {!!Request::input('sort') == 'deleted_at' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
        </a>
    </th>
    @if(!isset($hide_actions_column))
    <th class="actions-column">{{trans('book/views.index.table-actions-column')}}</th>
    @endif
</tr>
