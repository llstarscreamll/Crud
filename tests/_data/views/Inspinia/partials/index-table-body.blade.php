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

@forelse ( $records as $record )
    @if(!isset($hide_checkboxes_column))
    <tr class="item-{{ $record->id }} {{ $record->trashed() ? 'danger' : null }} ">
    @endif
    <td class="checkbox-column">
        {!! Form::checkbox('id[]', $record->id, null, ['id' => 'record-'.$record->id, 'class' => 'checkbox-table-item']) !!}
    </td>
        @if(in_array('id', $selectedTableColumns))
        <td class="id">
            {{ $record->id }}
        </td>
        @endif
        @if(in_array('reason_id', $selectedTableColumns))
        <td class="reason_id">
            {{ $record->reason ? $record->reason->name : '' }}
        </td>
        @endif
        @if(in_array('name', $selectedTableColumns))
        <td class="name">
            {{ $record->name }}
        </td>
        @endif
        @if(in_array('author', $selectedTableColumns))
        <td class="author">
            {{ $record->author }}
        </td>
        @endif
        @if(in_array('genre', $selectedTableColumns))
        <td class="genre">
            {{ $record->genre }}
        </td>
        @endif
        @if(in_array('stars', $selectedTableColumns))
        <td class="stars">
            {{ $record->stars }}
        </td>
        @endif
        @if(in_array('published_year', $selectedTableColumns))
        <td class="published_year">
            {{ $record->published_year }}
        </td>
        @endif
        @if(in_array('enabled', $selectedTableColumns))
        <td class="enabled">
            {{ $record->enabled }}
        </td>
        @endif
        @if(in_array('status', $selectedTableColumns))
        <td class="status">
            {{ $record->status }}
        </td>
        @endif
        @if(in_array('synopsis', $selectedTableColumns))
        <td class="synopsis">
            {{ $record->synopsis }}
        </td>
        @endif
        @if(in_array('approved_at', $selectedTableColumns))
        <td class="approved_at">
            {{ $record->approved_at }}
        </td>
        @endif
        @if(in_array('approved_by', $selectedTableColumns))
        <td class="approved_by">
            {{ $record->approvedBy ? $record->approvedBy->name : '' }}
        </td>
        @endif
        @if(in_array('created_at', $selectedTableColumns))
        <td class="created_at">
            {{ $record->created_at }}
        </td>
        @endif
        @if(in_array('updated_at', $selectedTableColumns))
        <td class="updated_at">
            {{ $record->updated_at }}
        </td>
        @endif
        @if(in_array('deleted_at', $selectedTableColumns))
        <td class="deleted_at">
            {{ $record->deleted_at }}
        </td>
        @endif
        
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
                        data-modalTitle="{{trans('core::shared.modal-restore-title')}}"
                        data-modalMessage="{{trans('core::shared.modal-restore-message', ['item' => $record->name])}}"
                        data-btnLabel="{{trans('core::shared.modal-restore-btn-confirm')}}"
                        data-btnClassName="btn-success"
                        title="{{trans('core::shared.restore-btn')}}">
                    <span class="fa fa-mail-reply"></span>
                    <span class="sr-only">{{trans('core::shared.restore-btn')}}</span>
                </button>
            
            {!! Form::close() !!}

        @else
            {{-- Botón para ir a los detalles del registro --}}
            <a  href="{{route('books.show', $record->id)}}"
                class="btn btn-primary btn-xs"
                role="button"
                data-toggle="tooltip"
                data-placement="top"
                title="{{trans('core::shared.show-btn')}}">
                <span class="fa fa-eye"></span>
                <span class="sr-only">{{trans('core::shared.show-btn')}}</span>
            </a>

            @if(auth()->user()->can('books.edit'))
                {{-- Botón para ir a formulario de actualización del registro --}}
                <a  href="{{route('books.edit', $record->id)}}"
                    class="btn btn-warning btn-xs" role="button"
                    data-toggle="tooltip"
                    data-placement="top"
                    title="{{trans('core::shared.edit-btn')}}">
                    <span class="glyphicon glyphicon-pencil"></span>
                    <span class="sr-only">{{trans('core::shared.edit-btn')}}</span>
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
                            data-modalMessage="{{trans('core::shared.modal-delete-message', ['item' => $record->name])}}"
                            data-modalTitle="{{trans('core::shared.modal-delete-title')}}"
                            data-btnLabel="{{trans('core::shared.modal-delete-btn-confirm')}}"
                            data-btnClassName="btn-danger"
                            title="{{trans('core::shared.trash-btn')}}">
                        <span class="fa fa-trash"></span>
                        <span class="sr-only">{{trans('core::shared.trash-btn')}}</span>
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
                {{trans('core::shared.no-records-found')}}
            </div>
        </td>
    </tr>

@endforelse