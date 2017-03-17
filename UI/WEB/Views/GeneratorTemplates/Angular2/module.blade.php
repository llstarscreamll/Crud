import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { {{ $gen->moduleClass('routing') }} } from './{{ str_replace('.ts', '', $gen->moduleFile('routing')) }}';
// ng2 Translate
import { TranslateService, TranslateModule } from 'ng2-translate';

import { CoreSharedModule } from './../core/core.shared.module';
// Theme
import { getTheme } from './../theme';
// Containers
import { CONTAINERS } from './containers';
// Components
import { COMPONENTS } from './components';
// Language files
import { {{ $gen->getLanguageKey(true) }} } from './translations/{{ $gen->getLanguageKey() }}';
// Effects
import { EFFECTS } from './effects';
// services
import { SERVICES } from './services';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    TranslateModule,
    CoreSharedModule,
    getTheme(),
    {{ $gen->moduleClass('routing') }},
    ...EFFECTS,
  ],
  declarations: [
    ...COMPONENTS,
	  ...CONTAINERS,
  ],
  providers: [
    ...SERVICES
  ]
})
export class {{ $gen->studlyModuleName() }}Module {
  
  public constructor(translate: TranslateService) {
    translate.setTranslation('{{ $gen->getLanguageKey(false) }}', {{ $gen->getLanguageKey(true) }}, true);
  }

}
