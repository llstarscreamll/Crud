<app-sidebar-layout>
	<app-page-header>
		<div class="col-xs-12">
			<h2 translate>{{ $gen->entityNameUppercase() }}.module-name-plural</h2>
		</div>
	</app-page-header>
	
	<app-page-content>
		<app-box>
			<app-box-body>

				<div class="row">
					<div class="col-md-6">
					</div>
					<div class="col-md-6">
						<app-basic-search class="m-b-lg" (search)="onSearch($event)"></app-basic-search>
					</div>
				</div>

				<{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}
					(sortLinkClicked)="onSearch($event)"
					[{{ camel_case($gen->entityName(true)) }}]="({{ $state = camel_case($gen->entityName()).'State$' }} | async)?.{{ camel_case($gen->entityName(true)) }}"
					[orderBy]="queryData.orderBy"
					[sortedBy]="queryData.sortedBy"
					[columns]="queryData.filter"
					[pagination]="({{ $state }} | async)?.pagination">
				</{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}>
			</app-box-body>
		</app-box>
	</app-page-content>
</app-sidebar-layout>