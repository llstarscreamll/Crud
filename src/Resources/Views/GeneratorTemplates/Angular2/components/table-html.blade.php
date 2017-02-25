<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
@foreach ($fields as $field)
@if (!$field->hidden)
				<th *ngIf="showColumn('{{ $field->name }}')" class="{{ $field->name }}">
					{{ '{{' }} '{{ $gen->entityNameUppercase() }}.fields.{{ $field->name }}' | translate }}
				</th>
@endif
@endforeach
			</tr>
		</thead>
		<tbody>
			<tr *ngFor="let {{ $var = camel_case($gen->entityName()) }} of {{ camel_case($gen->entityName(true)) }}">
@foreach ($fields as $field)
@if (!$field->hidden)
				<td *ngIf="showColumn('{{ $field->name }}')" class="{{ $field->name }}">
@if (in_array($field->type, ['datetime', 'timestamp']))
					{{ '{{' }} {{ $var }}?.{{ $field->name }}?.date | date:'shortDate' }}
@elseif ($field->namespace)
					{{ '{{' }} {{ $var }}?.{{  $gen->relationNameFromField($field)  }}?.data?.name }}
@else
					{{ '{{' }} {{ $var }}?.{{ $field->name }} }}
@endif
				</td>
@endif
@endforeach
			</tr>
		</tbody>
	</table>
</div>
