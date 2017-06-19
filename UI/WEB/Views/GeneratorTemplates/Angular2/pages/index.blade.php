import { {{ $crud->containerClass('list-and-search', true) }} } from './{{ str_replace('.ts', '', $crud->containerFile('list-and-search', true)) }}';
import { {{ $crud->containerClass('form', false, true) }} } from './{{ str_replace('.ts', '', $crud->containerFile('form', false, true)) }}';

export const {{ $crud->entityName() }}Pages = [
	{{ $crud->containerClass('list-and-search', true) }},
	{{ $crud->containerClass('form', false, true) }},
];