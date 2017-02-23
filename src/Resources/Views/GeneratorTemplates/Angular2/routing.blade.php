import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';

const routes: Routes = [
  {
    path: '{{ $gen->slugEntityName() }}', children: [
      { path: '', component: Foo, pathMatch: 'full' },
      { path: 'create', component: Foo },
      { path: ':id', component: Foo },
      { path: ':id/edit', component: Foo },
    ]
  }
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
  providers: []
})
export class {{ $gen->moduleClass('routing') }} { }
