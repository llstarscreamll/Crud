import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from './../auth/guards/auth';
import { {{ $listCmp = $gen->containerClass('list-and-search', $plural = true) }} } from './containers/{{ str_replace('.ts', '', $gen->containerFile('list-and-search', $plural = true)) }}';
import { {{ $createCmp = $gen->containerClass('create', $plural = false) }} } from './containers/{{ str_replace('.ts', '', $gen->containerFile('create', $plural = false)) }}';
import { {{ $editCmp = $gen->containerClass('edit', $plural = false) }} } from './containers/{{ str_replace('.ts', '', $gen->containerFile('edit', $plural = false)) }}';

const routes: Routes = [
  {
    path: '{{ $gen->slugEntityName() }}', canActivate: [AuthGuard], children: [
      { path: '', component: {{ $listCmp }}, pathMatch: 'full' },
      { path: 'create', component: {{ $createCmp }} },
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
