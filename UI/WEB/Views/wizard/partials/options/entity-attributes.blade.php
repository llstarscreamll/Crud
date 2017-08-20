<fieldset>
    <legend>Entity Attrs</legend>
    <div class="row">

        <div class="form-group col-sm-4 col-md-3">
            {!! Form::label('plural_entity_name', 'Plural Name') !!}
            {!! Form::text('plural_entity_name', null, ['class' => 'form-control']) !!}
            <span class="help-block">Your entity plural name (Books, User Addresses)</span>
        </div>

        <div class="form-group col-sm-4 col-md-3">
            {!! Form::label('single_entity_name', 'Singular Name') !!}
            {!! Form::text('single_entity_name', null, ['class' => 'form-control']) !!}
            <span class="help-block">Your entity singular name (Book, User Address)</span>
        </div>

        <div class="form-group col-sm-4 col-md-2">
            {!! Form::label('is_part_of_package', 'Container/Module') !!}
            {!! Form::text('is_part_of_package', null, ['class' => 'form-control']) !!}
            <span class="help-block">Should be singular (Library, User)</span>
        </div>

        <div class="form-group col-sm-4 col-md-2">
            {!! Form::label('id_for_user', 'Id for User') !!}
            {!! Form::select(
                'id_for_user',
                ($names_list = collect($fields)->pluck('name', 'name')),
                isset($names_list['name']) ? $names_list['name'] : null,
                ['class' => 'form-control']
            ) !!}
            <span class="help-block">What's the human readable attr?</span>
        </div>

        <div class="form-group col-sm-4 col-md-2">
            <label for="language_key">Languaje key</label>
            {!! Form::text('language_key', null, ['class' => 'form-control', 'placeholder' => 'en']) !!}
            <span class="help-block">Language to generate (es, en, ru)</span>
        </div>

        <div class="clearfix"></div>

        <div class="col-xs-12">
            <div class="table-responsive">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr>
                        <th colspan="3" class="text-center">DB</th>
                        <th colspan="4" class="text-center">Model Attr</th>
                        <th colspan="4" class="text-center">HTML</th>
                        <th colspan="1" class="text-center">Validation</th>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <th class="column-width-medium">Type</th>
                        <th class="column-width-short">Required?</th>
                        <th class="column-width-short hidden">DefaultValue</th>
                        <th class="column-width-extra-short hidden">Key</th>
                        <th class="hidden">MaxLen.</th>
                        <th>Namespace</th>
                        <th>Relation</th>
                        <th>Fillable?</th>
                        <th>Hidden?</th>
                        <th>Index?</th>
                        <th>Create?</th>
                        <th>Update?</th>
                        <th>Label</th>
                        <th>Rules</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fields as $field => $fieldData)
                    <tr>
                        <td>
                            {!! Form::text("field[$field][name]", $field, ['class' => 'form-control input-xs']) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$field][type]", $fieldData->type, ['class' => 'form-control input-xs']) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$field][required]", $fieldData->required, $fieldData->required, [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'Yes',
                                'data-off-text' => 'No',
                            ]) !!}
                        </td>
                        <td class="hidden">
                            {!! Form::text("field[$field][defValue]", $fieldData->defValue, ['class' => 'form-control input-xs']) !!}
                        </td>
                        <td class="hidden">
                            {!! Form::text("field[$field][key]", $fieldData->key, ['class' => 'form-control input-xs', 'maxlength' => 3]) !!}
                        </td>
                        <td class="hidden">
                            {!! Form::number("field[$field][maxLength]", $fieldData->maxLength, ['class' => 'form-control input-xs']) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$field][namespace]", null, ['class' => 'form-control input-xs']) !!}
                        </td>
                        <td>
                            {!! Form::select("field[$field][relation]",
                                [
                                '' => '---',
                                'belongsTo' => 'belongsTo',
                                ],
                                null,
                                ['class' => 'form-control input-xs']
                            ) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$field][fillable]", true, !empty($options) ? null : (in_array($field, ['id', 'created_at', 'updated_at', 'deleted_at']) ? false : true), [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'Yes',
                                'data-off-text' => 'No',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$field][hidden]", true, null, [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'Yes',
                                'data-off-text' => 'No',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$field][on_index_table]", true, !empty($options) ? null : (in_array($field, ['id', 'created_at', 'updated_at', 'deleted_at']) ? false : true), [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'Yes',
                                'data-off-text' => 'No',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$field][on_create_form]", true, !empty($options) ? null : (in_array($field, ['id', 'created_at', 'updated_at', 'deleted_at']) ? false : true), [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'Yes',
                                'data-off-text' => 'No',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::checkbox("field[$field][on_update_form]", true, !empty($options) ? null : (in_array($field, ['id', 'created_at', 'updated_at', 'deleted_at']) ? false : true), [
                                'class' => 'bootstrap_switch',
                                'data-size' => 'mini',
                                'data-on-text' => 'Yes',
                                'data-off-text' => 'No',
                            ]) !!}
                        </td>
                        <td>
                            {!! Form::text(
                                "field[$field][label]",
                                (($trans = trans('validation.attributes.'.$field)) != "validation.attributes.$field")
                                    ? ucfirst($trans)
                                    : null,
                                ['class' => 'form-control input-xs', 'required', 'placeholder' => $field.' label']
                            ) !!}
                        </td>
                        <td>
                            {!! Form::text("field[$field][validation_rules]", in_array($fieldData->type, ['timestamp', 'datetime']) ? 'date:Y-m-d H:i:s' : null, ['class' => 'form-control input-xs', 'placeholder' => $field.' rules']) !!}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot>
                </tfoot>
            </table>
            </div>
        </div>

    </div>
    </fieldset>