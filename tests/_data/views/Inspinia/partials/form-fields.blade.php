{{--
    ****************************************************************************
    Campos de formulario.
    ____________________________________________________________________________
    Contiene los campos del formulario de creación, actualización o detalles del
    registro.
    Si se desea que sean mostrados en modo deshabilitado, pasar la variable
    $show = true cuando sea llamada esta vista, util para el caso en que sólo se
    quiera visualizar los datos sin riesgo a que se hagan cambios.
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

<div class='form-group col-sm-6 {{ $errors->has('reason_id') ? 'has-error' : null }}'>
	{!! Form::label('reason_id', trans('book/views.form-fields.reason_id')) !!}
	{!! Form::select(
		'reason_id',
		$reason_id_list,
		Request::input('reason_id'),
		[
			'class' => 'form-control selectpicker',
			'data-live-search' => 'false',
			'data-size' => '5',
			'title' => '---',
			'data-selected-text-format' => 'count > 0',
			isset($show) ? 'disabled' : null,
			'form' => 'searchForm'
		]
	) !!}

	{!! $errors->first('reason_id', '<span class="text-danger">:message</span>') !!}
</div>

<div class='form-group col-sm-6 {{ $errors->has('name') ? 'has-error' : null }}'>
	{!! Form::label('name', trans('book/views.form-fields.name')) !!}
	{!! Form::input('text', 'name', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('name', '<span class="text-danger">:message</span>') !!}
</div>

<div class="clearfix"></div>

<div class='form-group col-sm-6 {{ $errors->has('author') ? 'has-error' : null }}'>
	{!! Form::label('author', trans('book/views.form-fields.author')) !!}
	{!! Form::input('text', 'author', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('author', '<span class="text-danger">:message</span>') !!}
</div>

<div class='form-group col-sm-6 {{ $errors->has('genre') ? 'has-error' : null }}'>
	{!! Form::label('genre', trans('book/views.form-fields.genre')) !!}
	{!! Form::input('text', 'genre', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('genre', '<span class="text-danger">:message</span>') !!}
</div>

<div class="clearfix"></div>

<div class='form-group col-sm-6 {{ $errors->has('stars') ? 'has-error' : null }}'>
	{!! Form::label('stars', trans('book/views.form-fields.stars')) !!}
	{!! Form::input('number', 'stars', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('stars', '<span class="text-danger">:message</span>') !!}
</div>

<div class='form-group col-sm-6 {{ $errors->has('published_year') ? 'has-error' : null }}'>
	{!! Form::label('published_year', trans('book/views.form-fields.published_year')) !!}
	{!! Form::input('text', 'published_year', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('published_year', '<span class="text-danger">:message</span>') !!}
</div>

<div class="clearfix"></div>

<div class='form-group col-sm-6 {{ $errors->has('enabled') ? 'has-error' : null }}'>
	{!! Form::label('enabled', trans('book/views.form-fields.enabled')) !!}
	<br>
	{!! Form::hidden('enabled', '0') !!}
	{!! Form::checkbox(
		'enabled',
		1,
		null,
		[
			'class' => 'bootstrap_switch',
			'data-size' => 'medium',
			'data-on-text' => 'Si',
			'data-off-text' => 'No',
			'data-on-color' => 'primary',
			'data-off-color' => 'default',
			isset($show) ? 'disabled' : null,
		])
	!!}

	{!! $errors->first('enabled', '<span class="text-danger">:message</span>') !!}
</div>

<div class='form-group col-sm-6 {{ $errors->has('status') ? 'has-error' : null }}'>
	{!! Form::label('status', trans('book/views.form-fields.status')) !!}
	{!! Form::select(
		'status',
		$status_list,
		Request::input('status'),
		[
			'class' => 'form-control selectpicker',
			'data-live-search' => 'false',
			'data-size' => '5',
			'title' => '---',
			'data-selected-text-format' => 'count > 0',
			isset($show) ? 'disabled' : null,
			'form' => 'searchForm'
		]
	) !!}

	{!! $errors->first('status', '<span class="text-danger">:message</span>') !!}
</div>

<div class="clearfix"></div>

<div class='form-group col-sm-6 {{ $errors->has('unlocking_word') ? 'has-error' : null }}'>
	{!! Form::label('unlocking_word', trans('book/views.form-fields.unlocking_word')) !!}
	{!! Form::input('text', 'unlocking_word', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('unlocking_word', '<span class="text-danger">:message</span>') !!}
</div>

@if(!isset($show))
<div class='form-group col-sm-6 {{ $errors->has('unlocking_word') ? 'has-error' : null }}'>
	{!! Form::label('unlocking_word_confirmation', trans('book/views.form-fields.unlocking_word_confirmation')) !!}
	{!! Form::input('text', 'unlocking_word_confirmation', null, ['class' => 'form-control']) !!}

	{!! $errors->first('unlocking_word', '<span class="text-danger">:message</span>') !!}
</div>
@endif

<div class='form-group col-sm-6 {{ $errors->has('synopsis') ? 'has-error' : null }}'>
	{!! Form::label('synopsis', trans('book/views.form-fields.synopsis')) !!}
	{!! Form::textarea('synopsis', null, ['class' => 'form-control', isset($show) ? 'disabled' : null]) !!}

	{!! $errors->first('synopsis', '<span class="text-danger">:message</span>') !!}
</div>
