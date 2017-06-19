<app-sidebar-layout>
  <app-page-header>
    <div class="col-xs-12">
      <h1>
        {{ '{{' }} '{{ $upEntity = $crud->entityNameSnakeCase() }}.module-name-plural' | translate }}
        <small> / {{ '{{' }} '{{ $upEntity.'.' }}'+formType | translate }}</small>
      </h1>
    </div>
  </app-page-header>

  <app-page-content>
    <app-box>
      <app-box-body>

        <{{ $formSelector = str_replace(['.ts', '.'], ['', '-'], $crud->componentFile('form', false)) }} [formType]="formType">
        </{{ $formSelector }}>

      </app-box-body>
    </app-box>
  </app-page-content>

</app-sidebar-layout>