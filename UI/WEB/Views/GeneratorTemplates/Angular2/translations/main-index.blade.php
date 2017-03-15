import { {{ $gen->entityNameSnakeCase() }} } from './{{ $gen->slugEntityName() }}';

export const {{ $gen->getLanguageKey(true) }} = {
  ...{{ $gen->entityNameSnakeCase() }},
};
