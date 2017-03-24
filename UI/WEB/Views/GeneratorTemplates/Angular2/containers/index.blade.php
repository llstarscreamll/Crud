import { {{ $gen->containerClass('list-and-search', true) }} } from './{{ str_replace('.ts', '', $gen->containerFile('list-and-search', true)) }}';
import { {{ $gen->containerClass('form', false, true) }} } from './{{ str_replace('.ts', '', $gen->containerFile('form', false, true)) }}';

export const {{ $gen->entityName() }}Containers = [
	{{ $gen->containerClass('list-and-search', true) }},
	{{ $gen->containerClass('form', false, true) }},
];