import { {{ $gen->componentClass('table', true) }} } from './{{ str_replace('.ts', '', $gen->componentFile('table', true)) }}';
import { {{ $gen->componentClass('form', false) }} } from './{{ str_replace('.ts', '', $gen->componentFile('form', false)) }}';

export const {{ $gen->entityName() }}Components = [
	{{ $gen->componentClass('table', true) }},
	{{ $gen->componentClass('form', false) }},
];