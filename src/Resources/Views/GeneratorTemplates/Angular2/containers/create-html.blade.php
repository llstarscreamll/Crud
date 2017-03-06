<app-sidebar-layout>
	<app-page-header>
		<div class="col-xs-12">
			<h2>
				{{ '{{' }} '{{ $upEntity = $gen->entityNameUppercase() }}.module-name-plural' | translate }}
				<small translate>{{ $upEntity.'.create' }}</small>
			</h2>
		</div>
	</app-page-header>

	<app-page-content>
		<app-box>
			<app-box-body>
				<pre>{{ '{{' }} {{ $state = camel_case($gen->entityName()).'State$' }} | async | json }}</pre>
				<app-dynamic-form></app-dynamic-form>
			</app-box-body>
		</app-box>
	</app-page-content>

</app-sidebar-layout>