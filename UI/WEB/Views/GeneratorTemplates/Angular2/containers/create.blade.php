import { Component, OnInit, OnDestroy } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';

import { FormModelParser } from './../../../core/services/formModelParser';
import * as appMessage from './../../../core/reducers/appMessage';
import * as fromRoot from './../../../reducers';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../../reducers/{{ $gen->slugEntityName() }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('create', false)) }}',
  templateUrl: './{{ $gen->containerFile('create-html', false) }}',
  styleUrls: ['./{{ $gen->containerFile('create-css', false) }}']
})
export class {{ $gen->containerClass('create', $plural = false) }} implements OnInit, OnDestroy {

	public {{ $state = camel_case($gen->entityName()).'State$' }}: Observable<{{ $reducer.'.State' }}>;
	public {{ $form = camel_case($gen->entityName()).'Form' }}: FormGroup;
	private formModelSubscription: Subscription;
  public appMessage$: Observable<appMessage.State>;

  public constructor(
  	private store: Store<fromRoot.State>,
  	private formModelParser: FormModelParser
  ) { }

  public ngOnInit() {
  	this.{{ $state }} = this.store.select(fromRoot.get{{ $entitySin }}State);
    this.appMessage$ = this.store.select(fromRoot.getAppMessagesState);
    this.store.dispatch(new {{ $actions }}.GetFormModelAction(null));
  	this.store.dispatch(new {{ $actions }}.GetFormDataAction(null));

  	this.formModelSubscription = this.store.select(fromRoot.get{{ $entitySin }}FormModel)
      .subscribe((model) => {
        this.{{ $form }} = this.formModelParser.toFormGroup(model);
      });
  }

  public ngOnDestroy() {
    this.formModelSubscription.unsubscribe();
  }

  public create{{ $gen->entityName() }}() {
    this.store.dispatch(new {{ $actions }}.CreateAction(this.{{ $form }}.value));
  }
}
