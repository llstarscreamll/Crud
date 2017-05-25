import { EffectsModule } from '@ngrx/effects';
import { BookEffects } from './book.effects';

export const EFFECTS = [
  EffectsModule.run(BookEffects),
];
