import { {{ $gen->componentClass('table', true) }} } from './{{ str_replace('.ts', '', $gen->componentFile('table', true)) }}';
import { {{ $gen->componentClass('form-fields', false) }} } from './{{ str_replace('.ts', '', $gen->componentFile('form-fields', false)) }}';
import { {{ $gen->componentClass('search-basic', false) }} } from './{{ str_replace('.ts', '', $gen->componentFile('search-basic', false)) }}';
import { {{ $gen->componentClass('search-advanced', false) }} } from './{{ str_replace('.ts', '', $gen->componentFile('search-advanced', false)) }}';

export const {{ $gen->entityName() }}Components = [
	{{ $gen->componentClass('table', true) }},
	{{ $gen->componentClass('form-fields', false) }},
	{{ $gen->componentClass('search-basic', false) }},
	{{ $gen->componentClass('search-advanced', false) }},
];