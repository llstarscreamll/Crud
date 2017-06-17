import { {{ $routesClass = $crud->entityName().'Routes' }} } from './{{ $crud->slugEntityName().'.routes' }}';

export const ROUTES = [
	...{{ $routesClass }},
];