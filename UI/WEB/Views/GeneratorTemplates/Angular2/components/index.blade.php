import { {{ $crud->componentClass('table', true) }} } from './{{ str_replace('.ts', '', $crud->componentFile('table', true)) }}';
import { {{ $crud->componentClass('form', false) }} } from './{{ str_replace('.ts', '', $crud->componentFile('form', false)) }}';
import { {{ $crud->componentClass('search-basic', false) }} } from './{{ str_replace('.ts', '', $crud->componentFile('search-basic', false)) }}';
import { {{ $crud->componentClass('search-advanced', false) }} } from './{{ str_replace('.ts', '', $crud->componentFile('search-advanced', false)) }}';

export const {{ $crud->entityName() }}Components = [
	{{ $crud->componentClass('table', true) }},
	{{ $crud->componentClass('form', false) }},
	{{ $crud->componentClass('search-basic', false) }},
	{{ $crud->componentClass('search-advanced', false) }},
];