import { Component, OnInit, OnDestroy } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';
import { ActivatedRoute } from '@angular/router';

import { FormModelParser } from './../../../core/services/formModelParser';
import * as appMessage from './../../../core/reducers/appMessage';
import * as fromRoot from './../../../core/reducers';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../../reducers/{{ camel_case($gen->entityName()) }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('details', false, true)) }}',
  templateUrl: './{{ $gen->containerFile('details-html', false, true) }}',
  styleUrls: ['./{{ $gen->containerFile('details-css', false, true) }}']
})
export class {{ $gen->containerClass('details', false, true) }} implements OnInit, OnDestroy {
	
	public {{ $state = camel_case($gen->entityName()).'State$' }}: Observable<{{ $reducer.'.State' }}>;
	public {{ $form = camel_case($gen->entityName()).'Form' }}: FormGroup;
	private formModelSubscription: Subscription;
	public appMessage$: Observable<appMessage.State>;
	public {{ $book = camel_case($gen->entityName()).'$' }}: Observable<{{ $gen->entityName() }}>;
	private {{ $bookSubscription = camel_case($gen->entityName()).'Subscription$' }}: Subscription;
	private id;

  constructor(
  	private store: Store<fromRoot.State>,
  	private formModelParser: FormModelParser,
  	private route: ActivatedRoute
  ) { }

  ngOnInit() {
  	this.{{ $state }} = this.store.select(fromRoot.get{{ $entitySin }}State);
  	this.{{ $book }} = this.store.select(fromRoot.getSelected{{ $entitySin }});
    this.appMessage$ = this.store.select(fromRoot.getAppMessagesState);
    this.store.dispatch(new {{ $actions }}.GetFormModelAction(null));
  	this.store.dispatch(new {{ $actions }}.GetFormDataAction(null));

  	this.formModelSubscription = this.store.select(fromRoot.get{{ $entitySin }}FormModel)
      .subscribe((model) => {
        this.{{ $form }} = this.formModelParser.toFormGroup(model);
      });

    this.route.params.subscribe(params => {
        this.id = params['id'];
        this.store.dispatch(new {{ $actions }}.GetAction(this.id));
      });

    this.{{ $book }}
  		.subscribe(({{ camel_case($gen->entityName()) }}) => {
  			if ({{ camel_case($gen->entityName()) }} != null)
  			this.{{ $form }}.patchValue(this.get{{ $gen->entityName() }}DetailsFormPatchValues({{ camel_case($gen->entityName()) }}));
  		});
  }

  public ngOnDestroy() {
    this.formModelSubscription.unsubscribe();
  }

  private get{{ $gen->entityName() }}DetailsFormPatchValues({{ camel_case($gen->entityName()) }}: {{ $entitySin }}) {
  	return {
  		...{{ camel_case($gen->entityName()) }},
@foreach ($fields as $field)
@if ($field->namespace)
			{{ $field->name }}: {{ camel_case($gen->entityName()) }}.{{ $gen->relationNameFromField($field) }} ? {{ camel_case($gen->entityName()) }}.{{ $gen->relationNameFromField($field) }}.data.name : null,
@endif
@if (in_array($field->type, ['timestamp', 'datetime']))
			{{ $field->name }}: {{ camel_case($gen->entityName()) }}.{{ $field->name }} ? {{ camel_case($gen->entityName()) }}.{{ $field->name }}.date : null,
@endif
@endforeach
		};
  }
}
