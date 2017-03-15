import { {{ $gen->entityName().'Service' }} } from './{{ $gen->slugEntityName().'.service' }}';

export const SERVICES = [
	{{ $gen->entityName().'Service' }},
];
