<form [formGroup]="searchForm" (ngSubmit)="search.emit(searchForm.value)">
	<div class="input-group">
	  <input formControlName="search" class="form-control" placeholder="Buscar...">
	  <div class="input-group-btn">
	    <button type="submit" class="btn btn-default">
	      <span class="glyphicon glyphicon-search"></span>
	    </button>
	  </div>
	</div>
</form>
