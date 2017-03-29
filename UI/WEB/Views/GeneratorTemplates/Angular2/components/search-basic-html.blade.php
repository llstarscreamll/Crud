<form [formGroup]="searchForm" (ngSubmit)="search.emit(searchForm.value)">
	<div class="input-group">
	  <input formControlName="search" class="form-control" placeholder="{{ '{{ ' }}'{{ $gen->entityNameSnakeCase() }}.search_field_placeholder' | translate }}">
	  <div class="input-group-btn">
	    <button type="submit" class="btn btn-default">
	      <i class="glyphicon glyphicon-search"></i>
	      <span class="sr-only" translate>{{ $gen->entityNameSnakeCase() }}.search_btn</span>
	    </button>
	  </div>
	</div>
</form>
