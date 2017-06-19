<form [formGroup]="searchForm" (ngSubmit)="onSearch(searchForm.value)">
	<div class="input-group">
	 
	  <input name="search" formControlName="search" class="form-control" placeholder="{{ '{{ ' }}'{{ $crud->entityNameSnakeCase() }}.search_field_placeholder' | translate }}">
	  
	  <div class="input-group-btn">
	    <button
	    	type="submit"
	    	tooltip="{{ '{{' }} '{{ $crud->entityNameSnakeCase() }}.search_btn' | translate }}"
	    	class="btn btn-default">
	      <i class="glyphicon glyphicon-search"></i>
	      <span class="sr-only" translate>{{ $crud->entityNameSnakeCase() }}.search_btn</span>
	    </button>

	    <button
	    	type="button"
	    	tooltip="{{ '{{' }} '{{ $crud->entityNameSnakeCase() }}.advanced_search.title' | translate }}"
	    	class="btn btn-default advanced-search-btn"
	    	(click)="advancedSearchBtnClick.emit()">
	    	<i class="fa fa-filter" aria-hidden="true"></i>
	    	<span class="sr-only" translate>{{ $crud->entityNameSnakeCase() }}.advanced_search.title</span>
	    </button>
	  </div>

	</div>
</form>
