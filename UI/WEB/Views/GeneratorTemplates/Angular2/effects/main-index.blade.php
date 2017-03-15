import { EffectsModule } from '@ngrx/effects';
import { {{ $gen->entityName().'Effects' }} } from './{{ $gen->slugEntityName().'.effects' }}';

export const EFFECTS = [
  EffectsModule.run({{ $gen->entityName().'Effects' }}),
];
