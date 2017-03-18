<app-sidebar-layout>
	<app-page-header>
		<div class="col-xs-12">
			<h2>
				{{ '{{' }} '{{ $upEntity = $gen->entityNameSnakeCase() }}.module-name-plural' | translate }}
				<small> / {{ '{{' }} '{{ $upEntity.'.create' }}' | translate }}</small>
			</h2>
		</div>
	</app-page-header>

	<app-page-content>
		<app-box>
			<app-box-body>

				<app-alerts [appMessage]="appMessage$ | async"></app-alerts>

				<form [formGroup]="{{ $camelEntity = camel_case($gen->entityName()) }}Form"
					  (ngSubmit)="create{{ $gen->entityName() }}()">

					<app-dynamic-form [model]="{{ camel_case($gen->entityName()).'FormModel$' }} | async"
									  [data]="{{ camel_case($gen->entityName()).'FormData$' }} | async"
									  [errors]="appMessage$ | async"
									  [visibility]="formType"
									  [disabled]="formType == 'details'"
									  [debug]="false"
									  [controls]="{{ $camelEntity }}Form"></app-dynamic-form>
					
					<div class="form-group">
						<button class="btn"
								type="submit"
								[disabled]="!{{ $camelEntity }}Form.valid"
								[ngClass]="{'btn-primary': {{ $camelEntity }}Form.valid, 'btn-default': !{{ $camelEntity }}Form.valid}">
							<i class="glyphicon glyphicon-floppy-disk"></i>
							<span class="btn-label">{{ '{{' }} '{{ $upEntity }}.create-btn' | translate }}</span>
						</button>
					</div>

					<div class="clearfix"></div>
				</form>
			</app-box-body>
		</app-box>
	</app-page-content>

</app-sidebar-layout>