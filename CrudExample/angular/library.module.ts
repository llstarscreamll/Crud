import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { Ng2BootstrapModule } from 'ngx-bootstrap';
import { TranslateService, TranslateModule } from '@ngx-translate/core';

import { DynamicFormModule } from './../dynamic-form/dynamic-form.module';
import { CoreSharedModule } from './../core/core.shared.module';
import { environment } from './../../environments/environment';
import { PAGES } from './pages';
import { COMPONENTS } from './components';
import { ES } from './translations/es';
import { EFFECTS } from './effects';
import { SERVICES } from './services';
import { LibraryRoutingModule } from './library-routing.module';

/**
 * LibraryModule Class.
 *
 * @author  [name] <[<email address>]>
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
