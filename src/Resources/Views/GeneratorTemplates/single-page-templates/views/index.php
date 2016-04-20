<?php
/* @var $gen \Nvd\Crud\Commands\Crud */
/* @var $fields [] */
?>

@extends('<?=config('llstarscreamll.CrudGenerator.config.layout')?>')

@section('title') <?=$gen->titlePlural()?> @stop

@section('content')
	
	<section class="content-header">
		<h1><a href="{{route('<?=$gen->route()?>.index')}}"><?= $gen->titlePlural() ?></a></h1>
	</section>

	<section class="content">
	
		<div class="box">
			
			<div class="box-header">
				
				<div class="row tools">

					{{-- Action Buttons --}}
					<div class="col-md-6 action-buttons">
						
						<?php if (config('llstarscreamll.CrudGenerator.config.show-create-form-on-index') === true) {
    ?>
						<!-- Button trigger modal -->
						<div class="display-inline-block" role="button"  data-toggle="tooltip" data-placement="top" title="Crear <?=$gen->titleSingular()?>">
							<button type="button" class="btn btn-default btn-sm" data-toggle="modal" data-target="#create-form-modal">
							    <span class="glyphicon glyphicon-plus"></span>
								<span class="sr-only">Crear <?=$gen->titleSingular()?></span>
							</button>
						</div>
						<?php 
} else {
    ?>
						<a id="create-<?=$gen->route()?>-link" class="btn btn-default btn-sm" href="{!! route('<?=$gen->route()?>.create') !!}" role="button"  data-toggle="tooltip" data-placement="top" title="Crear <?=$gen->titleSingular()?>">
							<span class="glyphicon glyphicon-plus"></span>
							<span class="sr-only">Crear <?=$gen->titleSingular()?></span>
						</a>
						<?php 
} ?>
					
					</div>

					@include('CoreModule::layout.notifications')

				</div>
				
	        </div>
	        
	        <div class="box-body">
				
				<?php if (config('llstarscreamll.CrudGenerator.config.show-create-form-on-index') === true) {
    ?>
				{{-- Formulario de creación de registro --}}
				@include('<?=$gen->viewsDirName()?>.partials.index-create-form')
				<?php 
} ?>

				<div class="table-responsive">
					<table class="table table-striped">
		    
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
												<?=$field->name?>{!!Request::input('sort') == '<?=$field->name?>' ? '<i class="fa fa-sort-alpha-'.Request::input('sortType').'"></i>' : ''!!}
											</a>
									</th>
								<?php 
} ?>
								<th>Acciones</th>
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
										<button type="submit" class="btn btn-primary btn-sm"  data-toggle="tooltip" data-placement="top" title="Buscar">
											<span class="fa fa-search"></span>
											<span class="sr-only">Buscar</span>
										</button>
										<a href="{{route('<?=$gen->route()?>.index')}}" class="btn btn-danger btn-sm" role="button"  data-toggle="tooltip" data-placement="top" title="Limpiar Filtros">
											<span class="glyphicon glyphicon-remove"></span>
											<span class="sr-only">Limpiar Filtros</span>
										</a>
									</td>
								</form>
							</tr>
					    </thead>

					    <tbody>
					    	@forelse ( $records as $record )
						    	<tr>
<?php foreach ($fields as $field) {
    ?>
									<td>
<?php if (!$gen->isGuarded($field->name)) {
    ?>
										<span class="editable"
											  data-type="<?=$gen->getInputType($field)?>"
											  data-name="<?=$field->name?>"
											  data-value="{{ $record-><?=$field->name?> }}"
											  data-pk="{{ $record->{$record->getKeyName()} }}"
											  data-url="/<?=$gen->route()?>/{{ $record->{$record->getKeyName()} }}"
											  <?=$gen->getSourceForEnum($field)?>>{{ $record-><?=$field->name?> }}</span>
<?php 
} else {
    ?>
										{{-- Los campos protejidos no son editables --}}
										{{ $record-><?=$field->name?> }}
<?php 
}
    ?>
									</td>
<?php 
} ?>
									{{-- Los botones de acción para cada registro --}}
									<td class="actions-cell">
										{!! Form::open(['route' => ['<?=$gen->route()?>.destroy', $record->id], 'method' => 'DELETE', 'class' => 'form-inline']) !!}

											{{-- Botón para ir a los detalles del registro --}}
											<a href="{{route('<?=$gen->route()?>.show', $record->id)}}" class="btn btn-primary btn-xs" role="button"  data-toggle="tooltip" data-placement="top" title="Ver Detalles">
										    	<span class="fa fa-eye"></span>
										    	<span class="sr-only">Ver Detalles</span>
										    </a>
											{{-- Botón para ir a formulario de actualización del registro --}}
										    <a href="{{route('<?=$gen->route()?>.edit', $record->id)}}" class="btn btn-warning btn-xs" role="button"  data-toggle="tooltip" data-placement="top" title="Editar Registro">
										    	<span class="fa fa-pencil-square-o"></span>
										    	<span class="sr-only">Editar Registro</span>
										    </a>
											
											{{-- Botón que realiza el envío del formulario para eliminar el registro --}}
											<button onclick="return confirm('Estás seguro? Toda la información será eliminada...')" type="submit" class="btn btn-danger btn-xs" role="button"  data-toggle="tooltip" data-placement="top" title="Eliminar Registro">
										        <span class="fa fa-trash"></span>
										        <span class="sr-only">Eliminar Registro</span>
											</button>
										
										{!! Form::close() !!}
									</td>
						    		
						    		</tr>
							@empty
								@include ('<?=$gen->templatesDir()?>.common.not-found-tr',['colspan' => <?=count($fields)+1?>])
					    	@endforelse
					    </tbody>
					
					</table>
				</div>

				@include('<?=$gen->templatesDir()?>.common.pagination', [ 'records' => $records ] )

			</div>
		
		</div>	
	
	</section>

@endsection

@section('script')
	<script>
		$(".editable").editable({ajaxOptions:{method:'PUT'}});
	</script>
@endsection