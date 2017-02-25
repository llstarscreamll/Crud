import { Component, OnInit } from '@angular/core';
import { Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';

import * as fromRoot from './../../core/reducers';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../reducers/{{ camel_case($gen->entityName()) }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../actions/{{ camel_case($gen->entityName()) }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('list-and-search', true)) }}',
  templateUrl: './{{ $gen->containerFile('list-and-search-html', true) }}',
  styleUrls: ['./{{ $gen->containerFile('list-and-search-css', true) }}']
})
export class {{ $gen->containerClass('list-and-search', $plural = true) }} implements OnInit {
	
	public {{ camel_case($gen->entityName(true)) }}$: Observable<{{ $reducer.'.State' }}>;

  public constructor(private store: Store<fromRoot.State>) { }

  public ngOnInit() {
  	this.{{ camel_case($gen->entityName(true)) }}$ = this.store.select(fromRoot.get{{ $gen->entityName() }}State);
  	this.store.dispatch(new {{ $actions  }}.LoadAction(null));
  }

}
