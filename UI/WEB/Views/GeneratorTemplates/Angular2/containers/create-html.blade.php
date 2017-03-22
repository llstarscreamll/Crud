<app-sidebar-layout>
  <app-page-header>
    <div class="col-xs-12">
      <h2>
        {{ '{{' }} '{{ $upEntity = $gen->entityNameSnakeCase() }}.module-name-plural' | translate }}
        <small> / {{ '{{' }} '{{ $upEntity.'.create' }}' | translate }}</small>
      </h2>
    </div>
  </app-page-header>

  <app-page-content>
    <app-box>
      <app-box-body>

        <app-alerts [appMessage]="appMessages$ | async"></app-alerts>
          
          <form [formGroup]="{{ $camelEntity = camel_case($gen->entityName()) }}Form"
            (ngSubmit)="submit{{ $gen->entityName() }}Form()">

            <{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('form', false)) }} *ngIf="formConfigured"
              [{{ $form = camel_case($gen->entityName()).'Form' }}]="{{ $camelEntity = camel_case($gen->entityName()) }}Form"
              [{{ $formModel = camel_case($gen->entityName().'FormModel') }}]="{{ camel_case($gen->entityName()).'FormModel$' }} | async"
              [{{ $formData = camel_case($gen->entityName()).'FormData' }}]="{{ camel_case($gen->entityName()).'FormData$' }} | async"
              [errors]="errors$ | async"
              [formType]="formType">
            </{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('form', false)) }}>

            <div class="form-group">
              <button *ngIf="formType == 'create'"
                  class="btn"
                  type="submit"
                  [disabled]="!{{ $camelEntity }}Form.valid"
                  [ngClass]="{'btn-primary': {{ $camelEntity }}Form.valid, 'btn-default': !{{ $camelEntity }}Form.valid}">
                <i class="glyphicon glyphicon-floppy-disk"></i>
                <span class="btn-label" translate>{{ $upEntity }}.create</span>
              </button>

              <button *ngIf="formType == 'edit' || formType == 'details'"
                  class="btn"
                  type="submit"
                  [disabled]="!{{ $camelEntity }}Form.valid"
                  [ngClass]="{'btn-warning': {{ $camelEntity }}Form.valid, 'btn-default': !{{ $camelEntity }}Form.valid}">
                <i class="glyphicon glyphicon-pencil"></i>
                <span class="btn-label" translate>{{ $upEntity }}.edit</span>
              </button>

              <button *ngIf="formType == 'edit' || formType == 'details'"
                  [disabled]="{{ $camelEntity }}Form.get('id') && {{ $camelEntity }}Form.get('id').value == ''"
                  (click)="triggerDeleteBtn()"
                  type="button"
                  class="btn btn-default">
                <i class="glyphicon glyphicon-trash"></i>
                <span class="btn-label" translate>{{ $upEntity }}.delete</span>
              </button>

              <a  class="btn btn-default" 
                [routerLink]="['/{{ $gen->slugEntityName() }}']">
                <i class="glyphicon glyphicon-th-list"></i>
                <span class="btn-label" translate>{{ $upEntity }}.see_all</span>
              </a>
            </div>

            <div class="clearfix"></div>

          </form>

      </app-box-body>
    </app-box>
  </app-page-content>

</app-sidebar-layout>