import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';
import { {{ $gen->moduleClass('routing') }} } from './{{ str_replace('.ts', '', $gen->moduleFile('routing')) }}';
// shell
import { InspiniaShellModule as Shell } from './../../shells/inspinia/inspinia.module';
// {{ $gen->entityName() }} components

@NgModule({
  imports: [
    CommonModule,
    Shell,
    {{ $gen->moduleClass('routing') }},
  ]
})
export class {{ $gen->moduleClass('module') }} { }
