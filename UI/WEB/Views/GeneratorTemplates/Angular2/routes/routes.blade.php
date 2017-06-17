import { Routes } from '@angular/router';

import { AuthGuard } from './../../auth/guards/auth.guard';

import { {{ $listCmp = $crud->containerClass('list-and-search', true) }} } from './../pages/{{ $crud->slugEntityName().'/'.str_replace('.ts', '', $crud->containerFile('list-and-search', true)) }}';
import { {{ $formCmp = $crud->containerClass('form', false, true) }} } from './../pages/{{ $crud->slugEntityName().'/'.str_replace('.ts', '', $crud->containerFile('form', false, true)) }}';

/**
 * {{ $crud->entityName() }}Routes.
 *
 * @author [name] <[<email address>]>
 */
export const {{ $crud->entityName() }}Routes: Routes = [
	{
	  path: '{{ $crud->slugEntityName() }}', canActivate: [AuthGuard], children: [
	      { path: '', component: {{ $listCmp }}, pathMatch: 'full' },
	      { path: 'create', component: {{ $formCmp }} },
	      { path: ':id/edit', component: {{ $formCmp }} },
	      { path: ':id/details', component: {{ $formCmp }} },
	    ]
	  }
];
