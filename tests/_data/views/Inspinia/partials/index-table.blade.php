{!! Form::open(['route' => 'books.index', 'method' => 'GET', 'id' => 'searchForm']) !!}
{!! Form::close() !!}

<div class="table-responsive">
    <table class="table table-hover">
        <thead>
            {{-- Nombres de columnas de tabla --}}
            <tr class="header-row">
                <th class="checkbox-column"></th>
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
                <th class="actions-column">{{trans('book/views.index.table-actions-column')}}</th>
            </tr>
            
            {{-- Elementos de Formulario de búqueda de tabla --}}
            <tr class="search-row">

                <td class="checkbox-column">{!! Form::checkbox('check_all', 'check_all', null, ['id' => 'check_all']) !!}</td>
                <td class="id">{!! Form::input('number', 'id', Request::input('id'), ['form' => 'searchForm', 'class' => 'form-control']) !!}</td>
                <td class="reason_id">
					{!! Form::select(
                        'reason_id[]',
                        $reason_id_list,
                        Request::input('reason_id'),
                        ['class' => 'form-control selectpicker', 'data-live-search' => 'false', 'data-size' => '5', 'title' => '---', 'data-selected-text-format' => 'count > 0', 'multiple', 'form' => 'searchForm']
                    ) !!}
				</td>
                <td class="name">{!! Form::input('text', 'name', Request::input('name'), ['form' => 'searchForm', 'class' => 'form-control']) !!}</td>
                <td class="author">{!! Form::input('text', 'author', Request::input('author'), ['form' => 'searchForm', 'class' => 'form-control']) !!}</td>
                <td class="genre">{!! Form::input('text', 'genre', Request::input('genre'), ['form' => 'searchForm', 'class' => 'form-control']) !!}</td>
                <td class="stars">{!! Form::input('number', 'stars', Request::input('stars'), ['form' => 'searchForm', 'class' => 'form-control']) !!}</td>
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
                        ['class' => 'form-control selectpicker', 'data-live-search' => 'false', 'data-size' => '5', 'title' => '---', 'data-selected-text-format' => 'count > 0', 'multiple', 'form' => 'searchForm']
                    ) !!}
				</td>
                <td class="synopsis">{!! Form::input('text', 'synopsis', Request::input('synopsis'), ['form' => 'searchForm', 'class' => 'form-control']) !!}</td>
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
                        ['class' => 'form-control selectpicker', 'data-live-search' => 'false', 'data-size' => '5', 'title' => '---', 'data-selected-text-format' => 'count > 0', 'multiple', 'form' => 'searchForm']
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

                {{-- Los botones de búsqueda y limpieza del formulario --}}
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
                            <li>
                                <div class="checkbox">
                                    <label>
                                        {!! Form::radio('trashed_records', 'withTrashed', Request::input('trashed_records') == 'withTrashed' ? true : false, ['form' => 'searchForm']) !!} {{ trans('book/views.index.filter-with-trashed-label') }}
                                    </label>
                                </div>
                            </li>
                            <li>
                                <div class="checkbox">
                                    <label>
                                        {!! Form::radio('trashed_records', 'onlyTrashed', Request::input('trashed_records') == 'onlyTrashed' ? true : false, ['form' => 'searchForm']) !!} {{ trans('book/views.index.filter-only-trashed-label') }}
                                    </label>
                                </div>
                            </li>
                        </ul>
                    </div>
                    
                    <button type="submit"
                            form="searchForm"
                            class="btn btn-primary btn-sm"
                            data-toggle="tooltip"
                            data-placement="top"
                            title="{{trans('book/views.index.search-button-label')}}">
                        <span class="fa fa-search"></span>
                        <span class="sr-only">{{trans('book/views.index.search-button-label')}}</span>
                    </button>

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

            </tr>
        </thead>

        <tbody>

            @forelse ( $records as $record )
            <tr class="item-{{ $record->id }} {{ $record->trashed() ? 'danger' : null }} ">
            <td class="checkbox-column">{!! Form::checkbox('id[]', $record->id, null, ['id' => 'record-'.$record->id, 'class' => 'checkbox-table-item']) !!}</td>
                <td class="id">
                    {{-- El campo id no es editable --}}
                    {{ $record->id }}
                </td>
                <td class="reason_id">
                    {{-- Campo reason_id es editable --}}
                    <span @if (! $record->trashed()) class="editable"
                          data-type="select"
                          data-name="reason_id"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->reason_id }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          data-source='{{ $reason_id_list_json }}'
                          @endif>{{ $record->reason ? $record->reason->name : '' }}</span>
                </td>
                <td class="name">
                    {{-- Campo name es editable --}}
                    <span @if (! $record->trashed()) class="editable"
                          data-type="text"
                          data-name="name"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->name }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          @endif>{{ $record->name }}</span>
                </td>
                <td class="author">
                    {{-- Campo author es editable --}}
                    <span @if (! $record->trashed()) class="editable"
                          data-type="text"
                          data-name="author"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->author }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          @endif>{{ $record->author }}</span>
                </td>
                <td class="genre">
                    {{-- Campo genre es editable --}}
                    <span @if (! $record->trashed()) class="editable"
                          data-type="text"
                          data-name="genre"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->genre }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          @endif>{{ $record->genre }}</span>
                </td>
                <td class="stars">
                    {{-- Campo stars es editable --}}
                    <span @if (! $record->trashed()) class="editable"
                          data-type="number"
                          data-name="stars"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->stars }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          @endif>{{ $record->stars }}</span>
                </td>
                <td class="published_year">
                    {{-- Campo published_year es editable --}}
                    <span @if (! $record->trashed()) class="editable-date"
                          data-type="date"
                          data-name="published_year"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->published_year }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          @endif>{{ $record->published_year }}</span>
                </td>
                <td class="enabled">
                    {{-- Campo enabled es editable --}}
                    <span @if (! $record->trashed()) class="editable"
                          data-type="text"
                          data-name="enabled"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->enabled }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          @endif>{{ $record->enabled }}</span>
                </td>
                <td class="status">
                    {{-- Campo status es editable --}}
                    <span @if (! $record->trashed()) class="editable"
                          data-type="select"
                          data-name="status"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->status }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          data-source='{{ $status_list_json }}'
                          @endif>{{ $record->status }}</span>
                </td>
                <td class="synopsis">
                    {{-- Campo synopsis es editable --}}
                    <span @if (! $record->trashed()) class="editable"
                          data-type="textarea"
                          data-name="synopsis"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->synopsis }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          @endif>{{ $record->synopsis }}</span>
                </td>
                <td class="approved_at">
                    {{-- Campo approved_at es editable --}}
                    <span @if (! $record->trashed()) class="editable-datetime"
                          data-type="datetime"
                          data-name="approved_at"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->approved_at }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          @endif>{{ $record->approved_at }}</span>
                </td>
                <td class="approved_by">
                    {{-- Campo approved_by es editable --}}
                    <span @if (! $record->trashed()) class="editable"
                          data-type="select"
                          data-name="approved_by"
                          data-placement="bottom"
                          data-emptytext="{{ trans('book/views.index.x-editable.dafaultValue') }}"
                          data-value="{{ $record->approved_by }}"
                          data-pk="{{ $record->{$record->getKeyName()} }}"
                          data-url="/books/{{ $record->{$record->getKeyName()} }}"
                          data-source='{{ $approved_by_list_json }}'
                          @endif>{{ $record->approvedBy ? $record->approvedBy->name : '' }}</span>
                </td>
                <td class="created_at">
                    {{-- El campo created_at no es editable --}}
                    {{ $record->created_at }}
                </td>
                <td class="updated_at">
                    {{-- El campo updated_at no es editable --}}
                    {{ $record->updated_at }}
                </td>
                <td class="deleted_at">
                    {{-- El campo deleted_at no es editable --}}
                    {{ $record->deleted_at }}
                </td>
                
                {{-- Los botones de acción para cada registro --}}
                <td class="actions-column">
                @if ($record->trashed())

                    {{-- Formulario para restablecer el registro --}}
                    {!! Form::open(['route' => ['books.restore'], 'method' => 'PUT', 'class' => 'form-inline display-inline']) !!}

                        {!! Form::hidden('id[]', $record->id) !!}
                        
                        {{-- Botón que muestra ventana modal de confirmación para el envío del formulario de restablecer el registro --}}
                        <button type="button"
                                class="btn btn-success btn-xs bootbox-dialog"
                                role="button"
                                data-toggle="tooltip"
                                data-placement="top"
                                {{-- Setup de ventana modal de confirmación --}}
                                data-modalTitle="{{trans('book/views.index.modal-restore-title')}}"
                                data-modalMessage="{{trans('book/views.index.modal-restore-message', ['item' => $record->name])}}"
                                data-btnLabel="{{trans('book/views.index.modal-restore-btn-confirm-label')}}"
                                data-btnClassName="{{trans('book/views.index.modal-restore-btn-confirm-class-name')}}"
                                title="{{trans('book/views.index.restore-row-button-label')}}">
                            <span class="fa fa-mail-reply"></span>
                            <span class="sr-only">{{trans('book/views.index.restore-item-button')}}</span>
                        </button>
                    
                    {!! Form::close() !!}

                @else
                    {{-- Botón para ir a los detalles del registro --}}
                    <a  href="{{route('books.show', $record->id)}}"
                        class="btn btn-primary btn-xs"
                        role="button"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="{{trans('book/views.index.see-details-button-label')}}">
                        <span class="fa fa-eye"></span>
                        <span class="sr-only">{{trans('book/views.index.see-details-button-label')}}</span>
                    </a>

                    {{-- Botón para ir a formulario de actualización del registro --}}
                    <a  href="{{route('books.edit', $record->id)}}"
                        class="btn btn-warning btn-xs" role="button"
                        data-toggle="tooltip"
                        data-placement="top"
                        title="{{trans('book/views.index.edit-item-button-label')}}">
                        <span class="glyphicon glyphicon-pencil"></span>
                        <span class="sr-only">{{trans('book/views.index.edit-item-button-label')}}</span>
                    </a>

                    {{-- Formulario para eliminar registro --}}
                    {!! Form::open(['route' => ['books.destroy', $record->id], 'method' => 'DELETE', 'class' => 'form-inline display-inline']) !!}
                        
                        {{-- Botón muestra ventana modal de confirmación para el envío de formulario de eliminar el registro --}}
                        <button type="button"
                                class="btn btn-danger btn-xs bootbox-dialog"
                                role="button"
                                data-toggle="tooltip"
                                data-placement="top"
                                {{-- Setup de ventana modal de confirmación --}}
                                data-modalMessage="{{trans('book/views.index.modal-delete-message', ['item' => $record->name])}}"
                                data-modalTitle="{{trans('book/views.index.modal-delete-title')}}"
                                data-btnLabel="{{trans('book/views.index.modal-delete-btn-confirm-label')}}"
                                data-btnClassName="{{trans('book/views.index.modal-delete-btn-confirm-class-name')}}"
                                title="{{trans('book/views.index.delete-item-button-label')}}">
                            <span class="fa fa-trash"></span>
                            <span class="sr-only">{{trans('book/views.index.delete-item-button-label')}}</span>
                        </button>
                    
                    {!! Form::close() !!}
                @endif
                </td>
                    
            </tr>

            @empty

                <tr>
                    <td class="empty-table" colspan="19">
                        <div  class="alert alert-warning">
                            {{trans('book/views.index.no-records-found')}}
                        </div>
                    </td>
                </tr>

            @endforelse

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