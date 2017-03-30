<form class="row" [formGroup]="searchForm" (ngSubmit)="search.emit(searchForm.value)">
	<tabset class="tabs-container">
		<!-- advanced search -->
    <tab>
    	<template tabHeading>
        <i class="fa fa-search-plus" aria-hidden="true"></i>
        <span translate>{{ $gen->entityNameSnakeCase() }}.advanced_search.search_tab_title</span>
      </template>
    	<div class="panel-body">
	    	<strong>Show advanced search form here!!</strong>
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
</form>
