import { NgModule } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';

import { CoreSharedModule } from './../core/core.shared.module';
import { environment } from './../../environments/environment';

import { PAGES } from './pages';
import { COMPONENTS } from './components';
import { EFFECTS } from './effects';
import { SERVICES } from './services';
import { ES } from './translations/es';
import { LibraryRoutingModule } from './library-routing.module';

/**
 * LibraryModule Class.
 *
 * @author  [name] <[<email address>]>
 */
@NgModule({
  imports: [
    environment.theme,
    CoreSharedModule,
    LibraryRoutingModule,
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
export class LibraryModule {
  
  public constructor(translate: TranslateService) {
    translate.setTranslation('es', ES, true);
  }

}
