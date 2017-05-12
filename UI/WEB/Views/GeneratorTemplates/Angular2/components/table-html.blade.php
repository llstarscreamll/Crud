<div class="table-responsive">
    <table class="table table-hover actions-btns-3">
      
      <thead>
        <tr>
          <th style="width: 1em;"><input type="checkbox" name="select_all_items"></th>
@foreach ($fields as $field)
@if (!$field->hidden)
          <th *ngIf="showColumn('{{ $gen->tableName.'.'.$field->name }}')" class="{{ $gen->tableName.'.'.$field->name }}">
            <span role="button" (click)="onSort('{{ $gen->tableName.'.'.$field->name }}')">
                {{ '{{' }} langKey + 'fields.'+'{{ $gen->tableName.'.'.$field->name }}' | translate }}
                <i *ngIf="orderBy == '{{ $gen->tableName.'.'.$field->name }}'"
                    [ngClass]="{'glyphicon': true, 'glyphicon-triangle-bottom': sortedBy == 'desc', 'glyphicon-triangle-top': sortedBy == 'asc'}"></i>
            </span>
          </th>
@endif
@endforeach
          <th class="actions" translate>{{ '{{' }} langKey + 'actions_table_header' }}</th>
        </tr>
      </thead>

      <tbody>

        <ng-container *ngIf="(itemsList$ | async)?.data.length > 0">
        <tr *ngFor="let {{ $var = camel_case($gen->entityName()) }} of (itemsList$ | async)?.data" @if($gen->hasSoftDeleteColumn) [ngClass]="{'danger': {{ $var }}.deleted_at }" @endif>
          <td><input type="checkbox" name="item[]" value="{{ $var }}.id"></td>
@foreach ($fields as $field)
@if (!$field->hidden)
          <td *ngIf="showColumn('{{ $gen->tableName.'.'.$field->name }}')" class="{{ $field->name }}">
@if ($field->namespace)
            {{ '{{' }} {{ $var }}?.{{  $gen->relationNameFromField($field)  }}?.data?.name }}
@else
            {{ '{{' }} {{ $var }}?.{{ $field->name }} }}
@endif
          </td>
@endif
@endforeach
          <td class="actions">
            <a
              [routerLink]="[ '/{{ $gen->slugEntityName() }}', {{ $var }}.id, 'details']"
              tooltip="{{ '{{' }} langKey + 'details' | translate }}"
              class="btn btn-sm btn-default details-link">
              <i class="glyphicon glyphicon-eye-open"></i>
              <span class="sr-only btn-label" translate>{{ '{{' }} langKey + 'details' }}</span>
            </a>

            <a
              {!! $gen->hasSoftDeleteColumn ? '*ngIf="!'.$var.'.deleted_at"' : null !!}
              [routerLink]="[ '/{{ $gen->slugEntityName() }}', {{ $var }}.id, 'edit']"
              tooltip="{{ '{{' }} langKey + 'edit' | translate }}"
              class="btn btn-sm btn-default edit-link">
              <i class="glyphicon glyphicon-pencil"></i>
              <span class="sr-only btn-label" translate>{{ '{{' }} langKey + 'edit' }}</span>
            </a>
            
            <a
              {!! $gen->hasSoftDeleteColumn ? '*ngIf="!'.$var.'.deleted_at"' : null !!}
              class="btn btn-sm btn-default delete-link"
              role="button"
              tooltip="{{ '{{' }} langKey + 'delete' | translate }}"
              (click)="deleteRow({{ $var }}.id)">
              <i class="glyphicon glyphicon-trash"></i>
              <span class="sr-only btn-label" translate>{{ '{{' }} langKey + 'delete' }}</span>
            </a>
          </td>
        </tr>
        </ng-container>

        <ng-container *ngIf="(itemsList$ | async)?.data.length == 0">
        <tr>
          <td [attr.colspan]="columns.length + 2">
            <div class="alert alert-warning" translate>{{ '{{' }} langKey + 'msg.no_rows_found' }}</div>
          </td>
        </tr>
        </ng-container>

      </tbody>

    </table>
</div>

<!-- paginator -->
<div class="row">
  <div class="col-xs-12">
    <pagination
      class="pull-right"
      [(ngModel)]="currentPage"
      [totalItems]="pagination?.total"
      [itemsPerPage]="pagination?.per_page"
      [maxSize]="5"
      [boundaryLinks]="true"
      (pageChanged)="updateSearch.emit($event)"
      [firstText]="langKey + 'paginator.first_text' | translate"
      [lastText]="langKey + 'paginator.last_text' | translate"
      [nextText]="langKey + 'paginator.next_text' | translate"
      [previousText]="langKey + 'paginator.previous_text' | translate"
      ></pagination>
  </div>
</div>
