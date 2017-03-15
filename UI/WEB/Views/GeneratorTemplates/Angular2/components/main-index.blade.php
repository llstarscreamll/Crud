import { {{ $gen->entityName().'Components' }} } from './{{ $gen->slugEntityName().'' }}';

export const COMPONENTS = [
	{{ $gen->entityName().'Components' }},
];
