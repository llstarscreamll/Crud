import { {{ $crud->entityNameSnakeCase() }} } from './{{ $crud->slugEntityName() }}';

export const {{ $crud->getLanguageKey(true) }} = {
  ...{{ $crud->entityNameSnakeCase() }},
};
