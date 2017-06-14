<app-loader *ngIf="!ready; else searchForm" loader="ball-grid-pulse">{{ '{{' }} langKey + 'loading_form' | translate }}</app-loader>

<ng-template #searchForm>
  <div class="row">

    <form [formGroup]="form" (ngSubmit)="onAdvancedSearch(); search.emit()">

      <app-alerts [appMessage]="messages$ | async" (closed)="cleanMessages()"></app-alerts>
    
    	<tabset class="tabs-container">
        <!-- columns options -->
        <tab>
          <ng-template tabHeading>
            <i class="fa fa-columns" aria-hidden="true"></i>
            <span translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.options_tab_title</span>
          </ng-template>
          <div class="panel-body">
            <dynamic-form-fields
              [form]="form.get('options')"
              [formModel]="formModel.options.controls"
              [formData]="{}"
              [errors]="(messages$ | async)?.errors || {}"
              [visibility]="'search'"
              ></dynamic-form-fields>
          </div>
        </tab>
        
    		<!-- advanced search -->
        <tab>
        	<ng-template tabHeading>
            <i class="fa fa-search-plus" aria-hidden="true"></i>
            <span translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.search_tab_title</span>
          </ng-template>
        	<div class="panel-body">
    	    	<dynamic-form-fields
    	    		[form]="form.get('search')"
              [formModel]="formModel.search.controls"
              [formData]="formData$ | async"
              [errors]="(messages$ | async)?.errors || {}"
              [visibility]="'search'"
    	    		></dynamic-form-fields>
        	</div>
        </tab>

        <!-- debug info -->
        <tab *ngIf="debug">
          <ng-template tabHeading>
            <i class="fa fa-bug" aria-hidden="true"></i>
            <span>Debug</span>
          </ng-template>
          <div class="col-sm-6">
            <strong>Form Values</strong>
            <pre>{{ '{{ ' }} form.value | json }}</pre>
            <strong>Form Data</strong>
            <pre>{{ '{{ ' }} formData$ | async | json }}</pre>
          </div>
          <div class="col-sm-6">
            <strong>Form Model</strong>
            <pre>{{ '{{ ' }} formModel$ | async | json }}</pre>
          </div>
        </tab>
      </tabset>
      
      <button type="submit" class="btn btn-lg btn-primary btn-block m-t-xs" translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.apply_btn</button>

    </form>
  </div>
</ng-template>
