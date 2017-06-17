import { EffectsModule } from '@ngrx/effects';
import { {{ $crud->entityName().'Effects' }} } from './{{ $crud->slugEntityName().'.effects' }}';

export const EFFECTS = [
  EffectsModule.run({{ $crud->entityName().'Effects' }}),
];
