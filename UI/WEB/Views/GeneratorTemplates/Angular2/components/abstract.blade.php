import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';
import { Router, ActivatedRoute } from '@angular/router';
import swal from 'sweetalert2';

import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as appMessage from './../../../core/reducers/app-message.reducer';
import * as fromRoot from './../../../reducers';

import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';
import { {{ $pagModel = $entitySin.'Pagination' }} } from './../../models/{{ camel_case($entitySin) }}Pagination';

export interface SearchQuery {
  filter: string[];
  include: {};
  orderBy: string;
  sortedBy: string;
  page: number;
}

/**
 * {{ $gen->componentClass('abstract', false, true) }} Abstract Class.
 *
 * @author [name] <[<email address>]>
 */
export abstract class {{ $gen->componentClass('abstract', false, true) }} {
  /**
   * Dependencies.
   */
  protected abstract store: Store<fromRoot.State>;
  protected abstract translateService: TranslateService;
  protected abstract formModelParserService: FormModelParserService;
  protected activedRoute: ActivatedRoute;

  protected activedRouteSubscription$: Subscription;
  
  /**
   * Form model.
   * @type Observable<Object>
   */
  public formModel$: Observable<Object>;

  /**
   * Form data loaded from API.
   * @type Observable<Object>
   */
  public formData$: Observable<Object>;

  /**
   * Items list pagination loaded from API.
   * @type Observable<{{ $pagModel }}>
   */
  public itemsList$: Observable<{{ $pagModel }}>;

  /**
   * Selected item loaded from API.
   * @type Observable<{{ $gen->entityName() }} | null>
   */
  public selectedItem$: Observable<{{ $gen->entityName() }} | null>;

  /**
   * Loading state.
   * @type Observable<boolean>
   */
  public loading$: Observable<boolean>;

  /**
   * The errors from this entity, like validation errors, etc.
   * @type Observable<Object>
   */
  public errors$: Observable<Object>;

  public appMessages$: Observable<appMessage.State>;

  protected formModelSubscription$: Subscription;

  /**
   * The search query options.
   */
  public searchQuery: SearchQuery = {
    // columns to retrive from API
    filter: [
@foreach ($fields as $field)
@if ($field->on_index_table && !$field->hidden)
      '{{ $gen->tableName.'.'.$field->name }}',
@endif
@endforeach
    ],
    // the relations map, we need some fields for eager load certain relations
    include: {
@foreach ($fields as $field)
@if ($field->namespace && !$field->hidden)
      '{{ $gen->tableName.'.'.$field->name }}': '{{  $gen->relationNameFromField($field)  }}',
@endif
@endforeach
    },
    orderBy: "{{ $gen->hasLaravelTimestamps ? $gen->tableName.'.created_at' : $gen->tableName.'.id' }}",
    sortedBy: "desc",
    page: 1
  };

  /**
   * The sweet alert options.
   * @type any
   */
  protected swalOptions: any;

  /**
   * Flag that tell as if the form is ready to be shown or not.
   * @type boolean
   */
  public formConfigured: boolean = false;

  public langKey: string = '{{ $gen->entityNameSnakeCase() }}.';
  public formType: string = 'create';
  public id: string = null;
  public tableColumns = [
@foreach ($fields as $field)
@if (!$field->hidden)
      '{{ $gen->tableName.'.'.$field->name }}',
@endif
@endforeach
  ];

  /**
   * {{ $gen->componentClass('abstract', false, true) }} constructor.
   */
  public constructor() { }

  /**
   * Init the store selects.
   */
  public setupStoreSelects() {
    this.formModel$ = this.store.select(fromRoot.get{{ $gen->entityName().'FormModel' }});
    this.formData$ = this.store.select(fromRoot.get{{ $gen->entityName().'FormData' }});
    this.itemsList$ = this.store.select(fromRoot.get{{ studly_case($gen->entityName(true)).'Pagination' }});
    this.selectedItem$ = this.store.select(fromRoot.get{{ 'Selected'.$gen->entityName() }});
    this.loading$ = this.store.select(fromRoot.get{{ $gen->entityName().'Loading' }});
    this.errors$ = this.store.select(fromRoot.get{{ $gen->entityName().'Errors' }});
    this.appMessages$ = this.store.select(fromRoot.getAppMessagesState);
  }

  /**
   * Trigger the basic search based on the given data.
   */
  public onSearch(data: Object = {}) {
    this.searchQuery = Object.assign({}, this.searchQuery, data, { advanced_search: false });
    this.store.dispatch(new {{ $actions }}.LoadAction(this.searchQuery));
  }

  /**
   * Load the form model and form data.
   */
  public initForm() {
    // if form type is details|update, then download the {{ $gen->entityName() }} data from API by the given id
    this.loadSelectedItem();
    
    this.store.dispatch(new {{ $actions }}.GetFormDataAction(null));
    this.store.dispatch(new {{ $actions }}.GetFormModelAction(null));
  }

  /**
   * Load {{ str_replace('_', '', $gen->tableName) }} by the given id on url, if any.
   */
  private loadSelectedItem() {
    if (this.formType.includes('details') || this.formType.includes('edit')) {
      this.activedRouteSubscription$ = this.activedRoute.params.subscribe(params => {
        this.id = params['id'];
        this.store.dispatch(new {{ $actions }}.GetAction(this.id));
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
      target: 'app-page-content'
    }).then(() => {
      this.store.dispatch(new {{ $actions }}.DeleteAction({ id: id, reloadListQuery: this.searchQuery }));
    }).catch(swal.noop);
  }
}
