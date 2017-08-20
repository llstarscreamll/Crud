export const {{ $crud->entityName() }}FormModel = {!! json_encode($crud->getFormModelConfigArray($fields)) !!};
