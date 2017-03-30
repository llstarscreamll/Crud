<dynamic-form-fields
	class="dynamic-form-fields"
	[formModel]="{{ camel_case($gen->entityName()).'FormModel' }}"
	[formData]="{{ camel_case($gen->entityName()).'FormData' }}"
	[form]="{{ camel_case($gen->entityName()) }}Form"
	[visibility]="formType"
	[debug]="true"
	></dynamic-form-fields>
