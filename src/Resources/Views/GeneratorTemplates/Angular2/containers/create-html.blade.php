<app-sidebar-layout>
	<app-page-header>
		<div class="col-xs-12">
			<h2>
				{{ '{{' }} '{{ $upEntity = $gen->entityNameUppercase() }}.module-name-plural' | translate }}
				<small> / {{ '{{' }} '{{ $upEntity.'.create' }}' | translate }}</small>
			</h2>
		</div>
	</app-page-header>

	<app-page-content>
		<app-box>
			<app-box-body>
				<app-dynamic-form [model]="({{ $camelEntity = camel_case($gen->entityName()) }}State$ | async)?.{{ $camelEntity }}FormModel"
								  [data]="({{ $camelEntity }}State$ | async)?.{{ $camelEntity }}FormData"
								  [controls]="{{ $camelEntity }}Form"></app-dynamic-form>
			</app-box-body>
		</app-box>
	</app-page-content>

</app-sidebar-layout>