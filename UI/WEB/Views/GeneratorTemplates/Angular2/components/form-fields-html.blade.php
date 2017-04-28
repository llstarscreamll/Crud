<dynamic-form-fields
	*ngIf="{{ camel_case($gen->entityName()).'FormModel' }} && {{ camel_case($gen->entityName()).'FormData' }}"
	class="dynamic-form-fields row"
	[form]="{{ camel_case($gen->entityName()) }}Form"
	[formModel]="{{ camel_case($gen->entityName()).'FormModel' }}"
	[formData]="{{ camel_case($gen->entityName()).'FormData' }}"
	[errors]="errors"
	[visibility]="formType"
	[disabled]="formType == 'details'"
	></dynamic-form-fields>
