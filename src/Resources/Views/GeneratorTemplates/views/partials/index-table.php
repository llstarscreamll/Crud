<?php
/* @var $gen llstarscreamll\CrudGenerator\Providers\TestsGenerator */
/* @var $fields [] */
/* @var $request Request */
?>

<div class="table-responsive">
                    <table class="table table-striped table-hover">
            
                        <thead>
                            {{-- Nombres de columnas de tabla --}}
                            <tr class="header-row">
                                <?php foreach ($fields as $field) {
    ?>
                                    <th>
                                        <a href="{{route(
                                                        '<?= $gen->route() ?>.index',
                                                        array_merge(
                                                            Request::query(),
                                                            [
                                                                'sort' => '<?=$field->name?>',
                                                                'sortType' => (Request::input('sort') == '<?=$field->name?>' and Request::input('sortType') == 'asc') ? 'desc' : 'asc'
                                                            ]
                                                        )
                                                    )
                                                }}">
                                                {{trans('<?=$gen->getLangAccess()?>/views.form-fields-short-name.<?=$field->name?>')}}{!!Request::input('sort') == '<?=$field->name?>' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
                                            </a>
                                    </th>
                                <?php
} ?>
                                <th>{{trans('<?=$gen->getLangAccess()?>/views.index.table-actions-column')}}</th>
                            </tr>
                            
                            {{-- Formulario de búqueda de tabla --}}
                            <tr class="search-row">
                                <form class="search-form">

<?php foreach ($fields as $field) {
    ?>
                                    <td><?=$gen->getSearchInputStr($field, $gen->table_name)?></td>
<?php
} ?>
                                    <td style="min-width: 8em;">
                                        <button type="submit" class="btn btn-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.search-button')}}">
                                            <span class="fa fa-search"></span>
                                            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.search-button')}}</span>
                                        </button>
                                        <a href="{{route('<?=$gen->route()?>.index')}}" class="btn btn-danger btn-sm" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.clean-filter')}}">
                                            <span class="glyphicon glyphicon-remove"></span>
                                            <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.clean-filter')}}</span>
                                        </a>
                                    </td>
                                </form>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse ( $records as $record )
                                <tr class="item-{{$record->id}}">
        <?php foreach ($fields as $field) { ?>
                                    <td>
                                <?php if (! $gen->isGuarded($field->name)) { ?>

                                        <span class="editable"
                                              data-type="<?=$gen->getInputType($field)?>"
                                              data-name="<?=$field->name?>"
                                              data-placement="bottom"
                                              data-value="{{ $record-><?=$field->name?> }}"
                                              data-pk="{{ $record->{$record->getKeyName()} }}"
                                              data-url="/<?=$gen->route()?>/{{ $record->{$record->getKeyName()} }}"
                <?=$gen->getSourceForEnum($field)?>>
                                                {{ $record-><?=$field->name?> }}
                                              </span>

                                <?php } else { ?>

                                        {{-- Los campos protejidos no son editables --}}
                                        {{ $record-><?=$field->name?> }}

                                <?php } // end if ?>
                                    </td>
        <?php } // endforeach ?>
                                    {{-- Los botones de acción para cada registro --}}
                                    <td class="actions-cell">
                                        {!! Form::open(['route' => ['<?=$gen->route()?>.destroy', $record->id], 'method' => 'DELETE', 'class' => 'form-inline']) !!}

                                            {{-- Botón para ir a los detalles del registro --}}
                                            <a href="{{route('<?=$gen->route()?>.show', $record->id)}}" class="btn btn-primary btn-xs" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.see-details-button')}}">
                                                <span class="fa fa-eye"></span>
                                                <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.see-details-button')}}</span>
                                            </a>

                                            {{-- Botón para ir a formulario de actualización del registro --}}
                                            <a href="{{route('<?=$gen->route()?>.edit', $record->id)}}" class="btn btn-warning btn-xs" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.edit-item-button')}}">
                                                <span class="glyphicon glyphicon-pencil"></span>
                                                <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.edit-item-button')}}</span>
                                            </a>
                                            
                                            {{-- Botón que realiza el envío del formulario para eliminar el registro --}}
                                            <button onclick="return confirm('Estás seguro? Toda la información será eliminada...')" type="submit" class="btn btn-danger btn-xs" role="button"  data-toggle="tooltip" data-placement="top" title="{{trans('<?=$gen->getLangAccess()?>/views.index.delete-item-button')}}">
                                                <span class="fa fa-trash"></span>
                                                <span class="sr-only">{{trans('<?=$gen->getLangAccess()?>/views.index.delete-item-button')}}</span>
                                            </button>
                                        
                                        {!! Form::close() !!}
                                    </td>
                                    
                                    </tr>
                            @empty
                                <tr>
                                    <td colspan="<?=count($fields)+1?>">
                                        <div  class="alert alert-warning">
                                        {{trans('<?=$gen->getLangAccess()?>/views.index.no-records-found')}}
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    
                    </table>
                </div>

                {!! $records->appends(Request::query())->render() !!}