import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { Ng2BootstrapModule } from 'ngx-bootstrap';
import { TranslateService, TranslateModule } from '@ngx-translate/core';

import { DynamicFormModule } from './../dynamic-form/dynamic-form.module';
import { CoreSharedModule } from './../core/core.shared.module';
import { environment } from './../../environments/environment';
import { CONTAINERS } from './containers';
import { COMPONENTS } from './components';
import { {{ $gen->getLanguageKey(true) }} } from './translations/{{ $gen->getLanguageKey() }}';
import { EFFECTS } from './effects';
import { SERVICES } from './services';
import { {{ $gen->moduleClass('routing') }} } from './{{ str_replace('.ts', '', $gen->moduleFile('routing')) }}';

/**
 * {{ $gen->studlyModuleName() }}Module Class.
 *
 * @author [name] <[<email address>]>
 */
@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    environment.theme,
    Ng2BootstrapModule.forRoot(),
    TranslateModule,
    DynamicFormModule,
    CoreSharedModule,
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
