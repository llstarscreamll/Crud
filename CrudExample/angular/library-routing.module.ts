import { NgModule } from '@angular/core';
import { Routes, RouterModule } from '@angular/router';
import { AuthGuard } from './../auth/guards/auth.guard';
import { ROUTES } from './routes';

const routes: Routes = [
  ...ROUTES
];

/**
 * LibraryRoutingModule Class.
 *
 * @author  [name] <[<email address>]>
 */
@NgModule({
  imports: [RouterModule.forChild(routes)],
  exports: [RouterModule],
  providers: []
})
export class LibraryRoutingModule { }
