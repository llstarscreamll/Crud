import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from './../auth/guards/auth';
import { {{ $listCmp = $gen->containerClass('list-and-search', true) }} } from './containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('list-and-search', true)) }}';
import { {{ $createCmp = $gen->containerClass('create', false) }} } from './containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('create', false)) }}';
import { {{ $detailsCmp = $gen->containerClass('details', false, true) }} } from './containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('details', false, true)) }}';
import { {{ $editCmp = $gen->containerClass('edit', false) }} } from './containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('edit', false)) }}';

const routes: Routes = [
  {
    path: '{{ $gen->slugEntityName() }}', canActivate: [AuthGuard], children: [
      { path: '', component: {{ $listCmp }}, pathMatch: 'full' },
      { path: 'create', component: {{ $createCmp }} },
      { path: ':id', component: {{ $detailsCmp }} },
      { path: ':id/edit', component: {{ $editCmp }} },
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
  providers: []
})
export class {{ $gen->moduleClass('routing') }} { }
