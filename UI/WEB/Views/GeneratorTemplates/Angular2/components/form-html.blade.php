<app-alerts [appMessage]="messages$ | async" (closed)="cleanMessages()"></app-alerts>

<app-loader *ngIf="!(formModel$ | async) || !(formData$ | async) || !form || !formReady; else dynamicForm" loader="ball-grid-pulse">{{ '{{' }} langKey + 'loading_form' | translate }}</app-loader>

<ng-template #dynamicForm>
  <form
    id="{{ $gen->slugEntityName() }}-form"
    [formGroup]="form"
    (ngSubmit)="submitForm()">

    <dynamic-form-fields
      *ngIf="formReady"
      class="dynamic-form-fields row"
      [form]="form"
      [formModel]="formModel$ | async"
      [formData]="formData$ | async"
      [errors]="(messages$ | async)?.errors || {}"
      [visibility]="formType"
      [disabled]="formType == 'details'">
    </dynamic-form-fields>

    <div class="form-group">
      <button
        *ngIf="formType == 'create'"
        class="btn create-row"
        type="submit"
        [disabled]="!form.valid || (loading$ | async)"
        [ngClass]="{'btn-primary': form.valid, 'btn-default': !form.valid}">
        <i class="glyphicon glyphicon-floppy-disk"></i>
        <span class="btn-label" translate>{{ $upEntity = $gen->entityNameSnakeCase() }}.create</span>
      </button>

      <button
        *ngIf="(formType == 'edit' || formType == 'details'){!! $gen->hasSoftDeleteColumn ? ' && !('.('selectedItem$').' | async)?.deleted_at' : null !!}"
        class="btn edit-row"
        type="submit"
        [disabled]="!form.valid || (loading$ | async)"
        [ngClass]="{'btn-warning': form.valid, 'btn-default': !form.valid}">
        <i class="glyphicon glyphicon-pencil"></i>
        <span class="btn-label" translate>{{ $upEntity }}.edit</span>
      </button>

      <button
        *ngIf="(formType == 'edit' || formType == 'details'){!! $gen->hasSoftDeleteColumn ? ' && !('.('selectedItem$').' | async)?.deleted_at' : null !!}"
        [disabled]="!selectedItemId || (loading$ | async)"
        (click)="deleteRow(selectedItemId)"
        type="button"
        class="btn btn-default delete-row">
        <i class="glyphicon glyphicon-trash"></i>
        <span class="btn-label" translate>{{ $upEntity }}.delete</span>
      </button>

      <a  class="btn btn-default show-all-rows" 
        [routerLink]="['/{{ $gen->slugEntityName() }}']">
        <i class="glyphicon glyphicon-th-list"></i>
        <span class="btn-label" translate>{{ $upEntity }}.see_all</span>
      </a>
    </div>

    <div class="clearfix"></div>

  </form>
</ng-template>
