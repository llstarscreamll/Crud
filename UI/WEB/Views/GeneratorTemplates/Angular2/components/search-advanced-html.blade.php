<div class="row">
	<tabset class="tabs-container">
		<!-- advanced search -->
    <tab>
    	<template tabHeading>
        <i class="fa fa-search-plus" aria-hidden="true"></i>
        <span translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.search_tab_title</span>
      </template>
    	<div class="panel-body">
	    	<dynamic-form-fields
	    		class="dynamic-form-fields"
	    		[formModel]="formModel"
	    		[formData]="formData"
	    		[form]="form"
          [visibility]="'search'"
	    		></dynamic-form-fields>
    	</div>
    </tab>

		<!-- columns options -->
    <tab>
    	<template tabHeading>
        <i class="fa fa-columns" aria-hidden="true"></i>
        <span translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.columns_tab_title</span>
      </template>
      <div class="panel-body">
      	<strong>Show options for show/hide columns here!!</strong>
      </div>
    </tab>

    <!-- debug info -->
    <tab *ngIf="debug">
      <template tabHeading>
        <span>FormValues</span>
      </template>
      <pre>{{ '{{ ' }} form.value | json }}</pre>
    </tab>

    <tab *ngIf="debug">
      <template tabHeading>
        <span>FormModel</span>
      </template>
      <pre>{{ '{{ ' }} formModel | json }}</pre>
    </tab>

    <tab *ngIf="debug">
      <template tabHeading>
        <span>FormData</span>
      </template>
      <pre>{{ '{{ ' }} formData | json }}</pre>
    </tab>

  </tabset>
</div>
