<div class="table-responsive">
    <table class="table table-bordered table-hover actions-btns-3">
        <thead>
            <tr>
                <ng-container *ngFor="let column of columns">
                <th *ngIf="showColumn(column)" class="{{ '{{' }} column }}">
                    <span role="button" (click)="sortLinkClicked.emit({'orderBy': column, 'sortedBy': (sortedBy == 'desc' || orderBy != column) ? 'asc' : 'desc'})">
                        {{ '{{' }} translateKey+'.fields.'+column | translate }}
                        <i *ngIf="orderBy == column"
                            [ngClass]="{'glyphicon': true, 'glyphicon-triangle-bottom': sortedBy == 'desc', 'glyphicon-triangle-top': sortedBy == 'asc'}"></i>
                    </span>
                </th>
                </ng-container>
                <th class="actions"></th>
            </tr>
        </thead>
        <tbody>
            <tr *ngFor="let {{ $var = camel_case($gen->entityName()) }} of {{ camel_case($gen->entityName(true)) }}">
@foreach ($fields as $field)
@if (!$field->hidden)
                <td *ngIf="showColumn('{{ $gen->tableName.'.'.$field->name }}')" class="{{ $field->name }}">
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
                <td class="actions">
                    <a [routerLink]="[ '/{{ $gen->slugEntityName() }}', {{ $var }}.id]" class="btn btn-sm btn-default">
                        <i class="glyphicon glyphicon-eye-open"></i>
                        <span class="sr-only btn-label" translate>translateKey+'.details' }}</span>
                    </a>
                    <a [routerLink]="[ '/{{ $gen->slugEntityName() }}', {{ $var }}.id, 'edit']" class="btn btn-sm btn-default">
                        <i class="glyphicon glyphicon-pencil"></i>
                        <span class="sr-only btn-label" translate>{{ '{{' }} translateKey+'.edit' }}</span>
                    </a>
                    <a role="button" class="btn btn-sm btn-default">
                        <i class="glyphicon glyphicon-trash"></i>
                        <span class="sr-only btn-label" translate>{{ '{{' }} translateKey+'.delete' }}</span>
                    </a>
                </td>
            </tr>
        </tbody>
    </table>
</div>
