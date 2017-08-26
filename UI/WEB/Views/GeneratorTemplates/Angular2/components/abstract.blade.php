import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';
import { Router, ActivatedRoute } from '@angular/router';
import swal from 'sweetalert2';
import { forOwn, isNull } from 'lodash';

import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import { AppMessage } from './../../../core/models/appMessage';
import * as fromRoot from './../../../reducers';

import * as {{ $actions = camel_case($crud->entityName()).'Actions' }} from './../../actions/{{ $crud->slugEntityName() }}.actions';
import { {{ $entitySin = $crud->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';
import { {{ $pagModel = $entitySin.'Pagination' }} } from './../../models/{{ camel_case($entitySin) }}Pagination';

export interface SearchQuery {
  filter: string[];
  include: {};
  orderBy: string;
  sortedBy: string;
  page: number;
}

/**
 * {{ $crud->componentClass('abstract', false, true) }} Abstract Class.
 *
 * @author [name] <[<email address>]>
 */
export abstract class {{ $crud->componentClass('abstract', false, true) }} {

  // Dependencies.
  protected abstract store: Store<fromRoot.State>;
  protected abstract translateService: TranslateService;
  protected abstract formModelParserService: FormModelParserService;
  protected activedRoute: ActivatedRoute;

  // subscriptions
  protected activedRouteSubscription$: Subscription;
  protected formModelSubscription$: Subscription;
  protected formDataSubscription$: Subscription;
  protected itemsListSubscription$: Subscription;
  protected searchQuerySubscription$: Subscription;
  protected selectedItemSubscription$: Subscription;
  
  /**
   * Form model.
   * @type Observable<Object>
   */
  public formModel$: Observable<any[]>;

  /**
   * Form data loaded from API.
   * @type Observable<Object>
   */
  public formData$: Observable<Object>;

  /**
   * Search query.
   * @type Observable<SearchQuery>
   */
  public searchQuery$: Observable<SearchQuery>;

  /**
   * Items pagination loaded from API.
   * @type Observable<{{ $pagModel }}>
   */
  public itemsPagination$: Observable<{{ $pagModel }}>;

  /**
   * Selected item loaded from API.
   * @type Observable<{{ $crud->entityName() }} | null>
   */
  public selectedItem$: Observable<{{ $crud->entityName() }} | null>;

  /**
   * Loading state.
   * @type Observable<boolean>
   */
  public loading$: Observable<boolean>;

  /**
   * The messages from this entity, like validation errors, warnings, etc.
   * @type Observable<AppMessage>
   */
  public messages$: Observable<AppMessage>;

  /**
   * The search query options.
   */
  public searchQuery: SearchQuery;

  /**
   * The sweet alert options.
   * @type any
   */
  protected swalOptions: any;

  /**
   * Flags that tell as if the form is ready to be shown or not.
   * @type  boolean
   */
  public formReady: boolean = false;
  public formModelReady: boolean = false;
  public formDataReady: boolean = false;
  public selectedItemReady: boolean = false;

  /**
   * Language key access.
   * @type string
   */
  public langKey: string = '{{ $crud->entityNameSnakeCase() }}.';

  /**
   * Form type (create|details|update). Used as an @Input() param on components.
   * @type string
   */
  public formType: string = 'create';

  /**
   * The item id to load. Mainly given by the {id} url param, but is used as an
   * @Input() param too on components.
   * @type string
   */
  public selectedItemId: string;

  /**
   * Available table columns to show.
   * @type Array<string>
   */
  public tableColumns: Array<string> = [
@foreach ($fields as $field)
@if (!$field->hidden)
    '{{ $crud->tableName.'.'.$field->name }}',
@endif
@endforeach
  ];

  /**
   * {{ $crud->componentClass('abstract', false, true) }} constructor.
   */
  public constructor() { }

  /**
   * Init the store selects.
   */
  public setupStoreSelects() {
    this.formModel$ = this.store.select(fromRoot.get{{ $crud->entityName().'FormModel' }});
    {{ !$crud->hasRelations ? '// ' : null }}this.formData$ = this.store.select(fromRoot.get{{ $crud->entityName().'FormData' }});
    this.searchQuery$ = this.store.select(fromRoot.get{{ $crud->entityName().'SearchQuery' }});
    this.itemsPagination$ = this.store.select(fromRoot.get{{ studly_case($crud->entityName(false)).'Pagination' }});
    this.selectedItem$ = this.store.select(fromRoot.get{{ $crud->entityName().'Selected' }});
    this.loading$ = this.store.select(fromRoot.get{{ $crud->entityName().'Loading' }});
    this.messages$ = this.store.select(fromRoot.get{{ $crud->entityName().'Messages' }});

    this.searchQuerySubscription$ = this.searchQuery$.subscribe(query => this.searchQuery = query);
  }

  /**
   * Handle the form data stuff.
   */
  public setupFormData() {
    {{ !$crud->hasRelations ? "/* we have not form data" : '// form data' }}
    this.formDataSubscription$ = this.formData$
      .subscribe(data => {
        if (data) {
          let ready = true;
          
          forOwn(data, (item) => {
            if (isNull(item)) {
              ready = false;
              return false;
            }
          });

          this.formDataReady = ready;
        }
      });{{ !$crud->hasRelations ? '*/' : null }}
    {{ !$crud->hasRelations ? 'this.formDataReady = true;' : null }}
  }

  /**
   * Trigger the basic search based on the given data.
   */
  public onSearch(data: Object = {}) {
    let query = Object.assign({}, this.searchQuery, data, { advanced_search: false });
    this.store.dispatch(new {{ $actions }}.SetSearchQueryAction(query));
  }

  /**
   * Load the form model and form data.
   */
  public initForm() {
    this.store.dispatch(new {{ $actions }}.GetFormDataAction(null));
    this.store.dispatch(new {{ $actions }}.GetFormModelAction(null));
  }

  /**
   * Load {{ str_replace('_', ' ', $crud->tableName) }} by the given id on url, if any.
   */
  public loadSelectedItem() {
    if ((this.formType == 'details' || this.formType == 'edit')) {
      this.activedRouteSubscription$ = this.activedRoute.params.subscribe(params => {
        this.selectedItemId = !this.selectedItemId ? params['id'] : this.selectedItemId;
        this.store.dispatch(new {{ $actions }}.GetByIdAction(this.selectedItemId));
      });
    }
  }

  /**
   * Delete item by the given id. Show an sweet alert to confirm the action.
   */
  public deleteRow(id: string) {
    this.translateService
      .get(this.langKey + 'delete-alert')
      .subscribe(val => this.swalOptions = val);

    swal({
      title: this.swalOptions.title,
      text: this.swalOptions.text,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: this.swalOptions.confirm_btn_text,
      cancelButtonText: this.swalOptions.cancel_btn_text,
      confirmButtonColor: '#ed5565',
      target: 'form#{{ $crud->slugEntityName() }}-form'
    }).then(() => {
      this.store.dispatch(new {{ $actions }}.DeleteAction({ id: id, reloadListQuery: this.searchQuery }));
    }).catch(swal.noop);
  }

  /**
   * Clean messages. Mainly called when <app-alerts> trigger the closed event or
   * ngOnDestroy() hook.
   */
  public cleanMessages(){
    this.store.dispatch(new {{ $actions }}.SetMessagesAction(null));
  }

  /**
   * Clean the component canceling the background taks. This is called before the
   * component instance is funally destroyed.
   */
  public ngOnDestroy() {
    this.cleanMessages();
    this.activedRouteSubscription$ ? this.activedRouteSubscription$.unsubscribe() : null;
    this.formModelSubscription$ ? this.formModelSubscription$.unsubscribe() : null;
    this.formDataSubscription$ ? this.formDataSubscription$.unsubscribe() : null;
    this.searchQuerySubscription$ ? this.searchQuerySubscription$.unsubscribe() : null;
    this.selectedItemSubscription$ ? this.selectedItemSubscription$.unsubscribe() : null;
  }
}
