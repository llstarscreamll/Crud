import { Routes } from '@angular/router';

import { AuthGuard } from './../../auth/guards/auth';

import { {{ $listCmp = $gen->containerClass('list-and-search', true) }} } from './../containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('list-and-search', true)) }}';
import { {{ $createCmp = $gen->containerClass('create', false) }} } from './../containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('create', false)) }}';
import { {{ $detailsCmp = $gen->containerClass('details', false, true) }} } from './../containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('details', false, true)) }}';
import { {{ $editCmp = $gen->containerClass('edit', false) }} } from './../containers/{{ $gen->slugEntityName().'/'.str_replace('.ts', '', $gen->containerFile('edit', false)) }}';

export const {{ $gen->entityName() }}Routes: Routes = [
	{
	  path: '{{ $gen->slugEntityName() }}', canActivate: [AuthGuard], children: [
	      { path: '', component: {{ $listCmp }}, pathMatch: 'full' },
	      { path: 'create', component: {{ $createCmp }} },
	      { path: ':id/edit', component: {{ $createCmp }} },
	      { path: ':id/details', component: {{ $createCmp }} },
	    ]
	  }
];
