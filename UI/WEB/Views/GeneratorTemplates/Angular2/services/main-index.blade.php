import { {{ $crud->entityName().'Service' }} } from './{{ $crud->slugEntityName().'.service' }}';

export const SERVICES = [
	{{ $crud->entityName().'Service' }},
];
