import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from './../auth/guards/auth';
import { ROUTES } from './routes';

const routes: Routes = [
  ...ROUTES
];

@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
  providers: []
})
export class {{ $gen->moduleClass('routing') }} { }
