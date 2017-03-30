<div class="row">
	<tabset class="tabs-container">
		<!-- advanced search -->
    <tab>
    	<template tabHeading>
        <i class="fa fa-search-plus" aria-hidden="true"></i>
        <span translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.search_tab_title</span>
      </template>
    	<div class="panel-body">
	    	<dynamic-search-form
	    		class="dynamic-search-form"
	    		[formModel]="formModel"
	    		[formData]="formData"
	    		[formGroup]="formGroup"
	    		></dynamic-search-form>
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
  </tabset>
</div>
