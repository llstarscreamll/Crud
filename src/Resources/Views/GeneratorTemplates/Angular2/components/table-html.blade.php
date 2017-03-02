<div class="table-responsive">
	<table class="table table-hover">
		<thead>
			<tr>
				<ng-container *ngFor="let column of columns">
				<th *ngIf="showColumn(column)" class="{{ '{{' }} column }}">
					<span role="button">{{ '{{' }} translateKey+'.fields.'+column | translate }}</span>
				</th>
				</ng-container>
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
<app-pagination [pagination]="pagination"></app-pagination>
