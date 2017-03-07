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
				<app-dynamic-form [model]="(bookState$ | async)?.bookFormModel"
								  [controls]="bookForm"></app-dynamic-form>
			</app-box-body>
		</app-box>
	</app-page-content>

</app-sidebar-layout>