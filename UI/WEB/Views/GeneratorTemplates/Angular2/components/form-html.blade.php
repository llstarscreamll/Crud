<app-dynamic-form
	[model]="{{ camel_case($gen->entityName()).'FormModel' }}"
	[controls]="{{ camel_case($gen->entityName()) }}Form"
	[data]="{{ camel_case($gen->entityName()).'FormData' }}"
	[errors]="errors"
	[visibility]="formType"
	[disabled]="formType == 'details'"
	[debug]="false"
	></app-dynamic-form>
