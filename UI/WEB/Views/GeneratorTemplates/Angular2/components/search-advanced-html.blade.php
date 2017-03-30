<form class="row" [formGroup]="searchForm" (ngSubmit)="search.emit(searchForm.value)">
	<tabset class="tabs-container">
		<!-- advanced search -->
    <tab heading="Adavenced Search">
    	<div class="panel-body">
	    	<strong>Show advanced search form here!!</strong>
    	</div>
    </tab>

		<!-- columns options -->
    <tab heading="Columns">
      <div class="panel-body">
      	<strong>Show options for show/hide columns here!!</strong>
      </div>
    </tab>
  </tabset>
</form>
