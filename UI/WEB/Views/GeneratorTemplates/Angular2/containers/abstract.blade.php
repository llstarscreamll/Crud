import { Location } from '@angular/common';
import { Title } from '@angular/platform-browser';
import { Router, ActivatedRoute } from '@angular/router';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';
import swal from 'sweetalert2';

import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as appMessage from './../../../core/reducers/app-message.reducer';
import * as fromRoot from './../../../reducers';

import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';

export interface SearchQuery {
  filter: string[];
  include: {};
  orderBy: string;
  sortedBy: string;
  page: number;
}

export abstract class {{ $gen->containerClass('abstract', false, true) }} {
  protected abstract store: Store<fromRoot.State>;
  protected abstract titleService: Title;
  protected abstract translateService: TranslateService;
  protected abstract formModelParserService: FormModelParserService;
  protected location: Location;
  protected activedRoute: ActivatedRoute;
  
  public {{ $formModel = camel_case($gen->entityName()).'FormModel$' }}: Observable<Object>;
  public {{ $formData = camel_case($gen->entityName()).'FormData$' }}: Observable<Object>;
  public {{ $pagination = camel_case($gen->entityName(true)).'Pagination$' }}: Observable<Object>;
  public {{ $selected = 'selected'.$gen->entityName().'$' }}: Observable<{{ $gen->entityName() }} | null>;
  public {{ $loading = 'loading$' }}: Observable<boolean>;
  public {{ $errors = 'errors$' }}: Observable<Object>;
  public appMessages$: Observable<appMessage.State>;

  protected formModelSubscription$: Subscription;
  protected activedRouteSubscription$: Subscription;

  protected abstract title: string;
  protected deleteAlertOptions: any;

  public translateKey: string = '{{ $gen->entityNameSnakeCase() }}.';
  public searchQuery: SearchQuery = null;
  public formType: string = 'search';
  public id: string = null;
  public tableColumns = [
@foreach ($fields as $field)
@if (!$field->hidden)
      '{{ $gen->tableName.'.'.$field->name }}',
@endif
@endforeach
  ];

  public constructor() { }

  public setupStoreSelects() {
    this.{{ $formModel }} = this.store.select(fromRoot.get{{ $gen->entityName().'FormModel' }});
    this.{{ $formData }} = this.store.select(fromRoot.get{{ $gen->entityName().'FormData' }});
    this.{{ $pagination }} = this.store.select(fromRoot.get{{ studly_case($gen->entityName(true)).'Pagination' }});
    this.{{ $selected }} = this.store.select(fromRoot.get{{ 'Selected'.$gen->entityName() }});
    this.{{ $loading }} = this.store.select(fromRoot.get{{ $gen->entityName().'Loading' }});
    this.{{ $errors }} = this.store.select(fromRoot.get{{ $gen->entityName().'Errors' }});
    this.appMessages$ = this.store.select(fromRoot.getAppMessagesState);
  }

  protected setDocumentTitle() {
    this.translateService
      .get(this.translateKey + this.title)
      .subscribe(val => this.titleService.setTitle(val));
  }

  public initForm() {
    this.setFormType();

    // if form type is details|update, then download the {{ $gen->entityName() }} data from API by the given id
    this.load{{ $gen->entityName() }}();
    
    this.store.dispatch(new {{ $actions }}.GetFormDataAction(null));
    this.store.dispatch(new {{ $actions }}.GetFormModelAction(null));
  }

  protected setFormType() {
    let url: string = this.location.path();
    
    if (url.search(/{{ $gen->slugEntityName() }}\/+[a-z0-9]+\/details+$/i) > -1)
      this.formType = "details";
    
    if (url.search(/{{ $gen->slugEntityName() }}\/+[a-z0-9]+\/edit+$/i) > -1)
      this.formType = "edit";
    
    if (url.search(/{{ $gen->slugEntityName() }}\/create$/i) > -1)
      this.formType = "create";
  }

  private load{{ $gen->entityName() }}() {
    if (this.formType.includes('details') || this.formType.includes('edit')) {
      this.activedRouteSubscription$ = this.activedRoute.params.subscribe(params => {
        this.id = params['id'];
        this.store.dispatch(new {{ $actions }}.GetAction(this.id));
      });
    }
  }

  public deleteRow(id: string) {
    this.translateService
      .get(this.translateKey + 'delete-alert')
      .subscribe(val => this.deleteAlertOptions = val);

    swal({
      title: this.deleteAlertOptions.title,
      text: this.deleteAlertOptions.text,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: this.deleteAlertOptions.confirm_btn_text,
      cancelButtonText: this.deleteAlertOptions.cancel_btn_text,
      confirmButtonColor: '#ed5565'
    }).then(() => {
      this.store.dispatch(new {{ $actions }}.DeleteAction({ id: id, reloadListQuery: this.searchQuery }));
    }).catch(swal.noop);
  }
}
