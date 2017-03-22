<app-sidebar-layout>
	<app-page-header>
		<div class="col-xs-12">
			<h2 translate>{{ $upEntity = $gen->entityNameSnakeCase() }}.module-name-plural</h2>
		</div>
	</app-page-header>
	
	<app-page-content>
		<app-box>
			<app-box-body>

				<div class="row">
					<div class="col-sm-6 col-md-8">
						<a [routerLink]="[ '/{{ $gen->slugEntityName() }}/create' ]" class="btn btn-primary">
							<i class="glyphicon glyphicon-plus"></i>
							<span translate>{{ $upEntity }}.create</span>
						</a>
					</div>
					<div class="col-sm-6 col-md-4">
						<app-basic-search class="m-b-lg" (search)="onSearch($event)"></app-basic-search>
					</div>
				</div>

				<{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}
					(sortLinkClicked)="onSearch($event)"
					[{{ camel_case($gen->entityName(true)) }}]="({{ $state = camel_case($gen->entityName()).'State$' }} | async)?.{{ camel_case($gen->entityName(true)) }}Pagination?.data"
					[orderBy]="queryData.orderBy"
					[sortedBy]="queryData.sortedBy"
					[columns]="queryData.filter"
					(deleteBtnClicked)="deleteRow($event)">
				</{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}>
				<app-pagination [pagination]="({{ $state }} | async)?.{{ camel_case($gen->entityName(true)) }}Pagination?.pagination"
								(pageLinkClicked)="onSearch($event)"></app-pagination>
			</app-box-body>
		</app-box>
	</app-page-content>
</app-sidebar-layout>