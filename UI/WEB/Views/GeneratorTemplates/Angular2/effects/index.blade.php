import { {{ $gen->entityName().'Effects' }} } from '{{ camel_case($gen->entityName()).'.effects' }}';

export const EFFECTS = [
  {{ $gen->entityName().'Effects' }},
];
