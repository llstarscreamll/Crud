import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { {{ $gen->moduleClass('routing') }} } from './{{ str_replace('.ts', '', $gen->moduleFile('routing')) }}';
// ng2 Translate
import { TranslateService, TranslateModule } from 'ng2-translate';

import { CoreModule } from './../core/core.module';
// shell
import { InspiniaShellModule as Shell } from './../../shells/inspinia/inspinia.module';
// Containers
import { CONTAINERS } from './containers';
// Components
import { COMPONENTS } from './components';
// Language files
import { ES } from './translations/es';
// Effects
import { EFFECTS } from './effects';
// services
import { SERVICES } from './services';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    TranslateModule,
    CoreModule,
    Shell,
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
    translate.setTranslation('es', ES, true);
  }

}
