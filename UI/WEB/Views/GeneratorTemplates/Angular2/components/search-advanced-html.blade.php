<div class="row">
  <form [formGroup]="form" (ngSubmit)="onSubmit()">
  
  	<tabset class="tabs-container">
      <!-- columns options -->
      <tab>
        <template tabHeading>
          <i class="fa fa-columns" aria-hidden="true"></i>
          <span translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.options_tab_title</span>
        </template>
        <div class="panel-body">
          <dynamic-form-fields
            class="dynamic-form-fields"
            [form]="form.get('options')"
            [formModel]="formModel.options.controls"
            [formData]="{}"
            [errors]="errors"
            [visibility]="'search'"
            ></dynamic-form-fields>
        </div>
      </tab>
      
  		<!-- advanced search -->
      <tab>
      	<template tabHeading>
          <i class="fa fa-search-plus" aria-hidden="true"></i>
          <span translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.search_tab_title</span>
        </template>
      	<div class="panel-body">
  	    	<dynamic-form-fields
  	    		class="dynamic-form-fields"
  	    		[form]="form.get('search')"
            [formModel]="formModel.search.controls"
            [formData]="formData"
            [errors]="errors"
            [visibility]="'search'"
  	    		></dynamic-form-fields>
      	</div>
      </tab>

      <!-- debug info -->
      <tab *ngIf="debug">
        <template tabHeading>
          <i class="fa fa-bug" aria-hidden="true"></i>
          <span>Debug</span>
        </template>
        <div class="col-sm-6">
          <strong>Form Values</strong>
          <pre>{{ '{{ ' }} form.value | json }}</pre>
          <strong>Form Data</strong>
          <pre>{{ '{{ ' }} formData | json }}</pre>
        </div>
        <div class="col-sm-6">
          <strong>Form Model</strong>
          <pre>{{ '{{ ' }} formModel | json }}</pre>
        </div>
      </tab>
    </tabset>
    
    <button type="submit" class="btn btn-lg btn-primary btn-block m-t-xs" translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.apply_btn</button>

  </form>
</div>
