import { {{ $crud->entityName().'Components' }} } from './{{ $crud->slugEntityName().'' }}';

export const COMPONENTS = [
	{{ $crud->entityName().'Components' }},
];
