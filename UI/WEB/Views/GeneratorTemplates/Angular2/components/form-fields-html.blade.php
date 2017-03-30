<dynamic-form-fields
	class="dynamic-form-fields"
	[form]="{{ camel_case($gen->entityName()) }}Form"
	[formModel]="{{ camel_case($gen->entityName()).'FormModel' }}"
	[formData]="{{ camel_case($gen->entityName()).'FormData' }}"
	[errors]="errors"
	[visibility]="formType"
	[disabled]="formType == 'details'"
	[debug]="true"
	></dynamic-form-fields>
