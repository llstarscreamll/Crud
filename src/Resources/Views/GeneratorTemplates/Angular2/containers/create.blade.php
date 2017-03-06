import { Component, OnInit } from '@angular/core';
import { Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';

import * as fromRoot from './../../core/reducers';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../reducers/{{ camel_case($gen->entityName()) }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../actions/{{ camel_case($gen->entityName()) }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('create', false)) }}',
  templateUrl: './{{ $gen->containerFile('create-html', false) }}',
  styleUrls: ['./{{ $gen->containerFile('create-css', false) }}']
})
export class {{ $gen->containerClass('create', $plural = false) }} implements OnInit {

	public {{ $state = camel_case($gen->entityName()).'State$' }}: Observable<{{ $reducer.'.State' }}>;

  constructor(private store: Store<fromRoot.State>) { }

  ngOnInit() {
  	this.bookState$ = this.store.select(fromRoot.getBookState);
  	this.store.dispatch(new bookActions.GetFormModelAction(null));
  }

}
