<fieldset>
    <legend>Atributos de Entidad</legend>
    <div class="row">

        <div class="form-group col-sm-4 col-md-2">
            {!! Form::label('plural_entity_name', 'Plural Name') !!}
            {!! Form::text('plural_entity_name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-4 col-md-2">
            {!! Form::label('single_entity_name', 'Singular Name') !!}
            {!! Form::text('single_entity_name', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-4 col-md-2">
            {!! Form::label('is_part_of_package', 'Part of package') !!}
            {!! Form::text('is_part_of_package', null, ['class' => 'form-control']) !!}
        </div>

        <div class="form-group col-sm-4 col-md-3">
            {!! Form::label('id_for_user', 'Id for User') !!}
            {!! Form::select(
                'id_for_user',
                ($names_list = collect($fields)->pluck('name', 'name')),
                isset($names_list['name']) ? $names_list['name'] : null,
                ['class' => 'form-control']
            ) !!}
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-12">
            <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th colspan="6" class="text-center">DB</th>
                        <th colspan="4" class="text-center">Model Attr</th>
                        <th colspan="4" class="text-center">HTML</th>
                        <th colspan="2" class="text-center">Test</th>
                        <th colspan="1" class="text-center">Validation</th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th>Type</th>
                        <th>Required?</th>
                        <th>DefaultValue</th>
                        <th>Key</th>
                        <th>MaxLen.</th>
                        <th>Namespace</th>
                        <th>Relation</th>
                        <th>Fillable?</th>
                        <th>Hidden?</th>
                        <th>Index?</th>
                        <th>Create?</th>
                        <th>Update?</th>
                        <th>Label</th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>Rules</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i = 0; $i < count($fields); $i++)
                    <tr>
                        <td>
                            {!! Form::text("field[$i][name]", $fields[$i]->name, ['class' => 'form-control input-xs']) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$i][type]", $fields[$i]->type, ['class' => 'form-control input-xs input-text-medium']) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$i][required]", $fields[$i]->required, $fields[$i]->required, [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'SI',
                                'data-off-text' => 'NO',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$i][defValue]", $fields[$i]->defValue, ['class' => 'form-control input-xs input-text-short']) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$i][key]", $fields[$i]->key, ['class' => 'form-control input-xs input-text-extra-short', 'maxlength' => 3]) !!}
                        </td>
                        <td>
                            {!! Form::number("field[$i][maxLength]", $fields[$i]->maxLength, ['class' => 'form-control input-xs']) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$i][namespace]", null, ['class' => 'form-control input-xs']) !!}
                        </td>
                        <td>
                            {!! Form::select("field[$i][relation]",
                                [
                                '' => '---',
                                'hasOne' => 'hasOne',
                                'belongsTo' => 'belongsTo',
                                'hasMany' => 'hasMany',
                                'belongsToMany' => 'belongsToMany',
                                ],
                                null,
                                ['class' => 'form-control input-xs']
                            ) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$i][fillable]", true, null, [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'SI',
                                'data-off-text' => 'NO',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$i][hidden]", true, null, [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'SI',
                                'data-off-text' => 'NO',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$i][on_index_table]", true, null, [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'SI',
                                'data-off-text' => 'NO',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$i][on_create_form]", true, null, [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'SI',
                                'data-off-text' => 'NO',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$i][on_update_form]", true, null, [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'SI',
                                'data-off-text' => 'NO',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$i][label]", null, ['class' => 'form-control input-xs', 'required', 'placeholder' => $fields[$i]->name.' label']) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$i][testData]", null, ['class' => 'form-control input-xs', 'placeholder' => 'null']) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$i][testDataUpdate]", null, ['class' => 'form-control input-xs', 'placeholder' => 'null']) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$i][validation_rules]", null, ['class' => 'form-control input-xs', 'placeholder' => $fields[$i]->name.' rules']) !!}
                        </td>
                    </tr>
                    @endfor
                </tbody>
                <tfoot>
                </tfoot>
            </table>
            </div>
        </div>

    </div>
    </fieldset>