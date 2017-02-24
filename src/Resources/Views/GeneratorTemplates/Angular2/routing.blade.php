import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { {{ $listCmp = $gen->componentClass('list-and-search', true) }} } from './components/{{ str_replace('.ts', '', $gen->componentFile('list-and-search', true)) }}';

const routes: Routes = [
  {
    path: '{{ $gen->slugEntityName() }}', children: [
      { path: '', component: {{ $listCmp }}, pathMatch: 'full' },
      /*{ path: 'create', component: Foo },
      { path: ':id/edit', component: Foo },*/
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
  providers: []
})
export class {{ $gen->moduleClass('routing') }} { }
