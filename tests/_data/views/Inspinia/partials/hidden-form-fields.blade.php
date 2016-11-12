{{--
    ****************************************************************************
    Campos de Formulario Ocultos.
    ____________________________________________________________________________
    Aquí se muestran los campos que no están presentes en la vista de creación o
    edición como los de fecha de creación y de actualizacíón, se usan en la
    vista de detalles de un registro (show).
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

<div class='form-group col-sm-6 {{ $errors->has('approved_at') ? 'has-error' : null }}'>
	{!! Form::label('approved_at', trans('book.form-labels.approved_at')) !!}
	{!! Form::input('text', 'approved_at', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('approved_at', '<span class="text-danger">:message</span>') !!}
</div>

<div class='form-group col-sm-6 {{ $errors->has('approved_by') ? 'has-error' : null }}'>
	{!! Form::label('approved_by', trans('book.form-labels.approved_by')) !!}
	{!! Form::select(
		'approved_by',
		$approved_by_list,
		Request::input('approved_by'),
		[
			'class' => 'form-control selectpicker',
			'data-live-search' => 'false',
			'data-size' => '5',
			'title' => '---',
			'data-selected-text-format' => 'count > 0',
			isset($show) ? 'disabled' : null,
		]
	) !!}

	{!! $errors->first('approved_by', '<span class="text-danger">:message</span>') !!}
</div>

<div class="clearfix"></div>

<div class='form-group col-sm-6 {{ $errors->has('created_at') ? 'has-error' : null }}'>
	{!! Form::label('created_at', trans('book.form-labels.created_at')) !!}
	{!! Form::input('text', 'created_at', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('created_at', '<span class="text-danger">:message</span>') !!}
</div>

<div class='form-group col-sm-6 {{ $errors->has('updated_at') ? 'has-error' : null }}'>
	{!! Form::label('updated_at', trans('book.form-labels.updated_at')) !!}
	{!! Form::input('text', 'updated_at', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('updated_at', '<span class="text-danger">:message</span>') !!}
</div>

<div class="clearfix"></div>

<div class='form-group col-sm-6 {{ $errors->has('deleted_at') ? 'has-error' : null }}'>
	{!! Form::label('deleted_at', trans('book.form-labels.deleted_at')) !!}
	{!! Form::input('text', 'deleted_at', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('deleted_at', '<span class="text-danger">:message</span>') !!}
</div>
