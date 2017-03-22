import { Component, OnInit, OnDestroy } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';
import { Router, ActivatedRoute } from '@angular/router';

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

  public {{ $formModel = camel_case($gen->entityName()).'FormModel$' }}: Observable<Object>;
  public {{ $formData = camel_case($gen->entityName()).'FormData$' }}: Observable<Object>;
  public {{ $selected = 'selected'.$gen->entityName().'$' }}: Observable<{{ $gen->entityName() }} | null>;
  public {{ $loading = 'loading$' }}: Observable<boolean>;
  public {{ $errors = 'errors$' }}: Observable<Object>;
  public appMessages$: Observable<appMessage.State>;

  private formModelSubscription$: Subscription;
  private activedRouteSubscription$: Subscription;
  
  public {{ $form = camel_case($gen->entityName()).'Form' }}: FormGroup;
  public formType: string = "create";
  public id: string = null;
  public formConfigured: boolean = false;

  public constructor(
  	private store: Store<fromRoot.State>,
  	private formModelParser: FormModelParser,
    private router: Router,
    private activedRoute: ActivatedRoute
  ) { }

  public ngOnInit() {
    // trigger the selects
    this.appMessages$ = this.store.select(fromRoot.getAppMessagesState);
    this.{{ $formModel }} = this.store.select(fromRoot.get{{ $gen->entityName().'FormModel' }});
    this.{{ $formData }} = this.store.select(fromRoot.get{{ $gen->entityName().'FormData' }});
    this.{{ $selected }} = this.store.select(fromRoot.get{{ 'Selected'.$gen->entityName() }});
    this.{{ $loading }} = this.store.select(fromRoot.get{{ $gen->entityName().'Loading' }});
    this.{{ $errors }} = this.store.select(fromRoot.get{{ $gen->entityName().'Errors' }});

    // download the form model
    this.store.dispatch(new {{ $actions }}.GetFormModelAction(null));
    
    // determine the form type based on the url location
    this.setFormType();

    // download the form data depending on the form type (create|update)
    this.downloadFormData();

    // if form type is details|update, then download the {{ $gen->entityName() }} data from API by the given id
    this.load{{ $gen->entityName() }}();
    
    // setup the form
    this.setupForm();
  }

  private setupForm() {
    this.formModelSubscription$ = this.{{ $formModel }}
      .subscribe((model) => {
        this.{{ $form }} = this.formModelParser.toFormGroup(model);
      });
    if (this.formType == 'details' || this.formType == 'edit') {
      this.patchForm();
    } else {
      this.formConfigured = true;
    }
  }

  private patchForm() {
    this.{{ $selected }}.subscribe(({{ $model = camel_case($gen->entityName()) }}) => {
      if ({{ $model }} != null && {{ $model }}.id) {
        if (this.formType.includes('edit')) {
          this.{{ $form }}.patchValue({{ $model }});
        }

        if (this.formType.includes('details')) {
          this.{{ $form }}.patchValue({
            ...{{ camel_case($gen->entityName()) }},
@foreach ($fields as $field)
@if ($field->namespace)
            {{ $field->name }}: {{ camel_case($gen->entityName()) }}.{{ $gen->relationNameFromField($field) }} ? {{ camel_case($gen->entityName()) }}.{{ $gen->relationNameFromField($field) }}.data.name : null,
@endif
@if (in_array($field->type, ['timestamp', 'datetime']))
            {{ $field->name }}: {{ camel_case($gen->entityName()) }}.{{ $field->name }} ? {{ camel_case($gen->entityName()) }}.{{ $field->name }}.date : null,
@endif
@endforeach
          });
        }

        this.formConfigured = true;
      }
    });
  }

  private setFormType() {
    if (this.router.url.search(/{{ $gen->slugEntityName() }}\/+[a-z0-9]+\/details+$/i) > -1)
      this.formType = "details";
    
    if (this.router.url.search(/{{ $gen->slugEntityName() }}\/+[a-z0-9]+\/edit+$/i) > -1)
      this.formType = "edit";
    
    if (this.router.url.search(/{{ $gen->slugEntityName() }}\/create$/i) > -1)
      this.formType = "create";
  }

  private downloadFormData() {
    if (this.formType.includes('create') || this.formType.includes('edit')) {
      this.store.dispatch(new {{ $actions }}.GetFormDataAction(null));
    }
  }

  private load{{ $gen->entityName() }}() {
    if (this.formType.includes('details') || this.formType.includes('edit')) {
      this.activedRouteSubscription$ = this.activedRoute.params.subscribe(params => {
        this.id = params['id'];
        this.store.dispatch(new {{ $actions }}.GetAction(this.id));
      });
    }
  }

  public submit{{ $gen->entityName() }}Form() {
    if (this.formType == 'create')
      this.store.dispatch(new {{ $actions }}.CreateAction(this.{{ $form }}.value));

    if (this.formType == 'edit')
      this.store.dispatch(new {{ $actions }}.UpdateAction(this.{{ $form }}.value));

    if (this.formType == 'details')
      this.formType = 'edit';
  }

  public triggerDeleteBtn() {
    this.store.dispatch(new {{ $actions }}.DeleteAction(this.{{ $form }}.get('id').value));
  }

  public ngOnDestroy() {
    this.formModelSubscription$.unsubscribe();
    this.activedRouteSubscription$ ? this.activedRouteSubscription$.unsubscribe() : null;
    // clean the selected {{ str_replace('_', ' ', (str_singular($gen->tableName))) }}
    this.store.dispatch(new {{ $actions }}.GetSuccessAction({}));
  }
}
