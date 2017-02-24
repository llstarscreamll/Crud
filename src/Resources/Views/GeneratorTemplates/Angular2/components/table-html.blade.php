<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
@foreach ($fields as $field)
				<th *ngIf="showColumn('{{ $field->name }}')" class="{{ $field->name }}">{{ $field->label }}</th>
@endforeach
			</tr>
		</thead>
		<tbody>
			<tr>
@foreach ($fields as $field)
				<th *ngIf="showColumn('{{ $field->name }}')" class="{{ $field->name }}"></th>
@endforeach
			</tr>
		</tbody>
	</table>
</div>
