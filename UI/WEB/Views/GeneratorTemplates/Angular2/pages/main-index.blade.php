import { {{ $crud->entityName().'Pages' }} } from './{{ $crud->slugEntityName().'' }}';

export const PAGES = [
	{{ $crud->entityName().'Pages' }},
];
