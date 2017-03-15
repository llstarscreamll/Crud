import { {{ $gen->containerClass('list-and-search', true) }} } from '{{ str_replace('.ts', '', $gen->containerFile('list-and-search', true)) }}';
import { {{ $gen->containerClass('create', false) }} } from '{{ str_replace('.ts', '', $gen->containerFile('create', false)) }}';
import { {{ $gen->containerClass('details', false) }} } from '{{ str_replace('.ts', '', $gen->containerFile('details', false)) }}';
import { {{ $gen->containerClass('details', false) }} } from '{{ str_replace('.ts', '', $gen->containerFile('details', false)) }}';
import { {{ $gen->containerClass('edit', false) }} } from '{{ str_replace('.ts', '', $gen->containerFile('edit', false)) }}';

export const {{ $gen->entityName() }}Components = [
	{{ $gen->containerClass('list-and-search', true) }},
	{{ $gen->containerClass('details', false) }},
	{{ $gen->containerClass('edit', false) }},
	{{ $gen->containerClass('create', false) }},
];