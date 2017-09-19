import { NgModule } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { FormsModule } from '@angular/forms';

import { CoreSharedModule } from './../core/core.shared.module';
import { THEME } from './../themes';

import { PAGES } from './pages';
import { COMPONENTS } from './components';
import { EFFECTS } from './effects';
import { SERVICES } from './services';
import { {{ $crud->getLanguageKey(true) }} } from './translations/{{ $crud->getLanguageKey() }}';
import { {{ $crud->moduleClass('routing') }} } from './{{ str_replace('.ts', '', $crud->moduleFile('routing')) }}';

/**
 * {{ $crud->studlyModuleName() }}Module Class.
 *
 * @author [name] <[<email address>]>
 */
@NgModule({
  imports: [
    FormsModule,
    THEME.default,
    CoreSharedModule,
    {{ $crud->moduleClass('routing') }},
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
export class {{ $crud->studlyModuleName() }}Module {
  
  public constructor(translate: TranslateService) {
    translate.setTranslation('{{ $crud->getLanguageKey(false) }}', {{ $crud->getLanguageKey(true) }}, true);
  }

}
