import { {{ $routesClass = $gen->entityName().'Routes' }} } from './{{ $gen->slugEntityName().'.routes' }}';

export const ROUTES = [
	...{{ $routesClass }},
];