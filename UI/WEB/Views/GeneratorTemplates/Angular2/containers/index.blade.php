import { {{ $gen->containerClass('list-and-search', true) }} } from './{{ str_replace('.ts', '', $gen->containerFile('list-and-search', true)) }}';
import { {{ $gen->containerClass('create', false) }} } from './{{ str_replace('.ts', '', $gen->containerFile('create', false)) }}';
import { {{ $gen->containerClass('details', false, true) }} } from './{{ str_replace('.ts', '', $gen->containerFile('details', false, true)) }}';
import { {{ $gen->containerClass('edit', false) }} } from './{{ str_replace('.ts', '', $gen->containerFile('edit', false)) }}';

export const {{ $gen->entityName() }}Containers = [
	{{ $gen->containerClass('list-and-search', true) }},
	{{ $gen->containerClass('details', false, true) }},
	{{ $gen->containerClass('edit', false) }},
	{{ $gen->containerClass('create', false) }},
];