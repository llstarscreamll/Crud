<div class="table-responsive">
    <table class="table table-hover actions-btns-3">
      
      <thead>
        <tr>
          <th style="width: 1em;"><input type="checkbox" name="select_all_items"></th>
          <ng-container *ngFor="let column of columns">
          <th class="{{ '{{' }} column }}">
            <span role="button" (click)="updateSearch.emit({'orderBy': column, 'sortedBy': (sortedBy == 'desc' || orderBy != column) ? 'asc' : 'desc'})">
                {{ '{{' }} translateKey + 'fields.'+column | translate }}
                <i *ngIf="orderBy == column"
                    [ngClass]="{'glyphicon': true, 'glyphicon-triangle-bottom': sortedBy == 'desc', 'glyphicon-triangle-top': sortedBy == 'asc'}"></i>
            </span>
          </th>
          </ng-container>
          <th class="actions" translate>{{ '{{' }} translateKey + 'actions_table_header' }}</th>
        </tr>
      </thead>

      <tbody>

        <ng-container *ngIf="{{ $items = camel_case($gen->entityName(true)) }} && {{ $items }}.length > 0">
        <tr *ngFor="let {{ $var = camel_case($gen->entityName()) }} of {{ $items }}" @if($gen->hasSoftDeleteColumn) [ngClass]="{'danger': {{ $var }}.deleted_at }" @endif>
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
              tooltip="{{ '{{' }} translateKey + 'details' | translate }}"
              class="btn btn-sm btn-default">
              <i class="glyphicon glyphicon-eye-open"></i>
              <span class="sr-only btn-label" translate>translateKey + 'details' }}</span>
            </a>

            <a
              {!! $gen->hasSoftDeleteColumn ? '*ngIf="!'.$var.'.deleted_at"' : null !!}
              [routerLink]="[ '/{{ $gen->slugEntityName() }}', {{ $var }}.id, 'edit']"
              tooltip="{{ '{{' }} translateKey + 'edit' | translate }}"
              class="btn btn-sm btn-default">
              <i class="glyphicon glyphicon-pencil"></i>
              <span class="sr-only btn-label" translate>{{ '{{' }} translateKey + 'edit' }}</span>
            </a>
            
            <a
              {!! $gen->hasSoftDeleteColumn ? '*ngIf="!'.$var.'.deleted_at"' : null !!}
              role="button" class="btn btn-sm btn-default"
              tooltip="{{ '{{' }} translateKey + 'delete' | translate }}"
              (click)="deleteBtnClicked.emit({{ $var }}.id)">
              <i class="glyphicon glyphicon-trash"></i>
              <span class="sr-only btn-label" translate>{{ '{{' }} translateKey + 'delete' }}</span>
            </a>
          </td>
        </tr>
        </ng-container>

        <ng-container *ngIf="!{{ $items }} || {{ $items }}.length == 0">
        <tr>
          <td [attr.colspan]="columns.length + 2">
            <div class="alert alert-warning" translate>{{ '{{' }} translateKey + 'msg.no_rows_found' }}</div>
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
      [firstText]="translateKey + 'paginator.first_text' | translate"
      [lastText]="translateKey + 'paginator.last_text' | translate"
      [nextText]="translateKey + 'paginator.next_text' | translate"
      [previousText]="translateKey + 'paginator.previous_text' | translate"
      ></pagination>
  </div>
</div>
