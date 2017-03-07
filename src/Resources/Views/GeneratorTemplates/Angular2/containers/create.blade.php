import { Component, OnInit, OnDestroy } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';

import { FormModelParser } from './../../core/services/formModelParser';
import * as fromRoot from './../../core/reducers';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../reducers/{{ camel_case($gen->entityName()) }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../actions/{{ camel_case($gen->entityName()) }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('create', false)) }}',
  templateUrl: './{{ $gen->containerFile('create-html', false) }}',
  styleUrls: ['./{{ $gen->containerFile('create-css', false) }}']
})
export class {{ $gen->containerClass('create', $plural = false) }} implements OnInit, OnDestroy {

	public {{ $state = camel_case($gen->entityName()).'State$' }}: Observable<{{ $reducer.'.State' }}>;
	public {{ $form = camel_case($gen->entityName()).'Form' }}: FormGroup;
	private formModelSubscription: Subscription;

  constructor(
  	private store: Store<fromRoot.State>,
  	private formModelParser: FormModelParser
  ) { }

  ngOnInit() {
  	this.bookState$ = this.store.select(fromRoot.getBookState);
  	this.store.dispatch(new bookActions.GetFormModelAction(null));
  	this.formModelSubscription = this.store.select(fromRoot.get{{ $entitySin }}FormModel)
      .subscribe((model) => {
        this.{{ $form }} = this.formModelParser.toFormGroup(model);
      });
  }

  ngOnDestroy() {
    this.formModelSubscription.unsubscribe();
  }
}
