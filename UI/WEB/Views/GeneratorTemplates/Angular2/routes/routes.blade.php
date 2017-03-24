import { Routes } from '@angular/router';

import { AuthGuard } from './../../auth/guards/auth.guard';

import { {{ $listCmp = $gen->containerClass('list-and-search', true) }} } from './../containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('list-and-search', true)) }}';
import { {{ $formCmp = $gen->containerClass('form', false, true) }} } from './../containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('form', false, true)) }}';

export const {{ $gen->entityName() }}Routes: Routes = [
	{
	  path: '{{ $gen->slugEntityName() }}', canActivate: [AuthGuard], children: [
	      { path: '', component: {{ $listCmp }}, pathMatch: 'full' },
	      { path: 'create', component: {{ $formCmp }} },
	      { path: ':id/edit', component: {{ $formCmp }} },
	      { path: ':id/details', component: {{ $formCmp }} },
	    ]
	  }
];
