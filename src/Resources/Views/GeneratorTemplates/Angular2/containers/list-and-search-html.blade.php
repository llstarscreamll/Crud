<app-sidebar-layout>
	<app-page-header>
		<div class="col-xs-12">
			<h2 translate>{{ $gen->entityNameUppercase() }}.module-name-plural</h2>
		</div>
	</app-page-header>
	
	<app-page-content>
		<app-box>
			<app-box-body>
				<{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}
					[{{ camel_case($gen->entityName(true)) }}]="({{ $state = camel_case($gen->entityName()).'State$' }} | async)?.{{ camel_case($gen->entityName(true)) }}"
					[pagination]="({{ $state }} | async)?.pagination">
				</{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}>
			</app-box-body>
		</app-box>
	</app-page-content>
</app-sidebar-layout>