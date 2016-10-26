{{--
    ****************************************************************************
    El cuerpo de la tabla.
    ____________________________________________________________________________
    Aquí se muestran los datos devueltos por la consulta ejecutada en el
    controlador según los criterios que haya dado el usuario.

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

@forelse ( $records as $record )
    @if(!isset($hide_checkboxes_column))
    <tr class="item-{{ $record->id }} {{ $record->trashed() ? 'danger' : null }} ">
    @endif
    <td class="checkbox-column">{!! Form::checkbox('id[]', $record->id, null, ['id' => 'record-'.$record->id, 'class' => 'checkbox-table-item']) !!}</td>
        <td class="id">
            {{-- El campo id no es editable --}}
            {{ $record->id }}
        </td>
        <td class="reason_id">
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
        
        @if(!isset($hide_actions_column))
        {{-- Los botones de acción para cada registro --}}
        <td class="actions-column">
        @if ($record->trashed() && auth()->user()->can('books.restore'))

            {{-- Formulario para restablecer el registro --}}
            {!! Form::open(['route' => ['books.restore', $record->id], 'method' => 'PUT', 'class' => 'form-inline display-inline']) !!}
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
                    <span class="sr-only">{{trans('book/views.index.restore-row-button-label')}}</span>
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

            @if(auth()->user()->can('books.edit'))
                {{-- Botón para ir a formulario de actualización del registro --}}
                <a  href="{{route('books.edit', $record->id)}}"
                    class="btn btn-warning btn-xs" role="button"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="{{trans('book/views.index.edit-item-button-label')}}">
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span class="sr-only">{{trans('book/views.index.edit-item-button-label')}}</span>
                </a>
            @endif

            @if(auth()->user()->can('books.destroy'))
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
        @endif
        </td>
        @endif
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