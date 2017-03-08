import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { {{ $gen->moduleClass('routing') }} } from './{{ str_replace('.ts', '', $gen->moduleFile('routing')) }}';
import { EffectsModule } from '@ngrx/effects';
// ng2 Translate
import { TranslateService, TranslateModule } from 'ng2-translate';
import { CoreModule } from './../core/core.module';
// shell
import { InspiniaShellModule as Shell } from './../../shells/inspinia/inspinia.module';
// {{ $gen->entityName() }} containers
import { {{ $gen->containerClass('create', false) }} } from './containers/{{ str_replace(['.ts'], [''], $gen->containerFile('create', false)) }}';
import { {{ $gen->containerClass('edit', false) }} } from './containers/{{ str_replace(['.ts'], [''], $gen->containerFile('edit', false)) }}';
import { {{ $gen->containerClass('list-and-search', true) }} } from './containers/{{ str_replace(['.ts'], [''], $gen->containerFile('list-and-search', true)) }}';
// {{ $gen->entityName() }} components
import { {{ $gen->componentClass('form', false) }} } from './components/{{ str_replace(['.ts'], [''], $gen->componentFile('form', false)) }}';
import { {{ $gen->componentClass('table', true) }} } from './components/{{ str_replace(['.ts'], [''], $gen->componentFile('table', true)) }}';
// Language files
import { ES } from './translations/es';
// ngrx
import { {{ $gen->entityName() }}Effects } from './effects/{{ camel_case($gen->entityName()) }}.effects';
// services
import { {{ $service = $gen->entityName().'Service' }} } from './services/{{ camel_case($gen->entityName()) }}.service';

@NgModule({
  imports: [
    CommonModule,
    ReactiveFormsModule,
    EffectsModule.run({{ $gen->entityName() }}Effects),
    TranslateModule,
    CoreModule,
    Shell,
    {{ $gen->moduleClass('routing') }},
  ],
  declarations: [
	  {{ $gen->containerClass('create', false) }},
	  {{ $gen->containerClass('edit', false) }},
	  {{ $gen->containerClass('list-and-search', true) }},
	  {{ $gen->componentClass('form', false) }},
	  {{ $gen->componentClass('table', true) }},
  ],
  providers: [
    {{ $service }}
  ]
})
export class {{ $gen->moduleClass('module') }} {
  
  public constructor(translate: TranslateService) {
    translate.setTranslation('es', ES, true);
  }

}
