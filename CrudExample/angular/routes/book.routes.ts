import { Routes } from '@angular/router';

import { AuthGuard } from './../../auth/guards/auth.guard';

import { ListAndSearchBooksPage } from './../pages/book/list-and-search-books.page';
import { BookFormPage } from './../pages/book/book-form.page';

/**
 * BookRoutes.
 *
 * @author  [name] <[<email address>]>
 */
export const BookRoutes: Routes = [
	{
	  path: 'book', canActivate: [AuthGuard], children: [
	      { path: '', component: ListAndSearchBooksPage, pathMatch: 'full' },
	      { path: 'create', component: BookFormPage },
	      { path: ':id/edit', component: BookFormPage },
	      { path: ':id/details', component: BookFormPage },
	    ]
	  }
];
