<app-alerts [appMessage]="messages$ | async" (closed)="cleanMessages()"></app-alerts>

<app-loader *ngIf="!ready; else dynamicForm" loader="ball-grid-pulse">{{ '{{' }} langKey + 'loading_form' | translate }}</app-loader>

<ng-template #dynamicForm>
  <form
    id="{{ $crud->slugEntityName() }}-form"
    [formGroup]="form"
    (ngSubmit)="submitForm()">

    <dynamic-form-fields
      *ngIf="formReady"
      class="row"
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
        userCan="{{ $crud->slugEntityName(true) }}.create"
        class="btn create-row"
        type="submit"
        [disabled]="!form.valid || (loading$ | async)"
        [ngClass]="{'btn-primary': form.valid, 'btn-default': !form.valid}">
        <i class="glyphicon glyphicon-floppy-disk"></i>
        <span class="btn-label" translate>{{ $upEntity = $crud->entityNameSnakeCase() }}.create</span>
      </button>

      <button
        *ngIf="(formType == 'edit' || formType == 'details'){!! $crud->hasSoftDeleteColumn ? ' && !('.('selectedItem$').' | async)?.deleted_at' : null !!}"
        userCan="{{ $crud->slugEntityName(true) }}.update"
        class="btn edit-row"
        type="submit"
        [disabled]="!form.valid || (loading$ | async)"
        [ngClass]="{'btn-warning': form.valid, 'btn-default': !form.valid}">
        <i class="glyphicon glyphicon-pencil"></i>
        <span class="btn-label" translate>{{ $upEntity }}.edit</span>
      </button>

      <button
        *ngIf="(formType == 'edit' || formType == 'details'){!! $crud->hasSoftDeleteColumn ? ' && !('.('selectedItem$').' | async)?.deleted_at' : null !!}"
        userCan="{{ $crud->slugEntityName(true) }}.delete"
        [disabled]="!selectedItemId || (loading$ | async)"
        (click)="deleteRow(selectedItemId)"
        type="button"
        class="btn btn-default delete-row">
        <i class="glyphicon glyphicon-trash"></i>
        <span class="btn-label" translate>{{ $upEntity }}.delete</span>
      </button>

      <a  class="btn btn-default show-all-rows"
        userCan="{{ $crud->slugEntityName(true) }}.list_and_search"
        [routerLink]="['/{{ $crud->slugEntityName() }}']">
        <i class="glyphicon glyphicon-th-list"></i>
        <span class="btn-label" translate>{{ $upEntity }}.see_all</span>
      </a>
    </div>

    <div class="clearfix"></div>

  </form>
</ng-template>
