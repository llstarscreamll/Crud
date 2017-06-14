import { NgModule } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';

import { CoreSharedModule } from './../core/core.shared.module';
import { environment } from './../../environments/environment';

import { PAGES } from './pages';
import { COMPONENTS } from './components';
import { EFFECTS } from './effects';
import { SERVICES } from './services';
import { {{ $gen->getLanguageKey(true) }} } from './translations/{{ $gen->getLanguageKey() }}';
import { {{ $gen->moduleClass('routing') }} } from './{{ str_replace('.ts', '', $gen->moduleFile('routing')) }}';

/**
 * {{ $gen->studlyModuleName() }}Module Class.
 *
 * @author [name] <[<email address>]>
 */
@NgModule({
  imports: [
    environment.theme,
    CoreSharedModule,
    {{ $gen->moduleClass('routing') }},
    ...EFFECTS,
  ],
  declarations: [
    ...COMPONENTS,
    ...PAGES,
  ],
  providers: [
    ...SERVICES,
  ]
})
export class {{ $gen->studlyModuleName() }}Module {
  
  public constructor(translate: TranslateService) {
    translate.setTranslation('{{ $gen->getLanguageKey(false) }}', {{ $gen->getLanguageKey(true) }}, true);
  }

}
