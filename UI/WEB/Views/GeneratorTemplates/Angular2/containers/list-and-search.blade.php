import { Component, OnInit } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { TranslateService } from 'ng2-translate';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';
import * as _ from 'lodash';
import swal from 'sweetalert2';

import * as fromRoot from './../../../reducers';
import * as appMessage from './../../../core/reducers/app-message.reducer';
import { FormModelParserService } from './../../../core/services/form-model-parser.service';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../../reducers/{{ $gen->slugEntityName() }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';

interface QueryData {
  filter: string[];
  include: {};
  orderBy: string;
  sortedBy: string;
  page: number;
}

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('list-and-search', true)) }}',
  templateUrl: './{{ $gen->containerFile('list-and-search-html', true) }}',
  styleUrls: ['./{{ $gen->containerFile('list-and-search-css', true) }}']
})
export class {{ $gen->containerClass('list-and-search', $plural = true) }} implements OnInit {
	
  public appMessages$: Observable<appMessage.State>;
	public {{ $state = camel_case($gen->entityName()).'State$' }}: Observable<{{ $reducer.'.State' }}>;
  public {{ $formModel = camel_case($gen->entityName()).'FormModel$' }}: Observable<Object>;
  public {{ $formData = camel_case($gen->entityName()).'FormData$' }}: Observable<Object>;
  public {{ $errors = 'errors$' }}: Observable<Object>;

  private formModelSubscription$: Subscription;

  public allTableColumns = [
@foreach ($fields as $field)
@if (!$field->hidden)
      '{{ $gen->tableName.'.'.$field->name }}',
@endif
@endforeach
  ];

  /**
   * The search query options.
   */
  public queryData: QueryData = {
    // here we decide what columns to retrive from API
    filter: [
@foreach ($fields as $field)
@if ($field->on_index_table && !$field->hidden)
      '{{ $gen->tableName.'.'.$field->name }}',
@endif
@endforeach
    ],
    // the relations map, you know, we need some fields for eager load certain relations
    include: {
@foreach ($fields as $field)
@if ($field->namespace && !$field->hidden)
      '{{ $gen->tableName.'.'.$field->name }}': '{{  $gen->relationNameFromField($field)  }}',
@endif
@endforeach
    },
    orderBy: "{{ $gen->tableName.'.created_at' }}",
    sortedBy: "desc",
    page: 1
  };

  public showSearchOptions: boolean = false;
  public {{ $form = camel_case($gen->entityName()).'Form' }}: FormGroup;
  public formConfigured: boolean = false;

  public translateKey: string = '{{ $gen->entityNameSnakeCase() }}.';
  private title: string = 'module-name-plural';
  private deleteAlert: any;

  public constructor(
    private store: Store<fromRoot.State>,
    private titleService: Title,
    private translateService: TranslateService,
    private FormModelParserService: FormModelParserService
  ) {
    this.{{ $formModel }} = this.store.select(fromRoot.get{{ $gen->entityName().'FormModel' }});
    this.{{ $formData }} = this.store.select(fromRoot.get{{ $gen->entityName().'FormData' }});
    this.{{ $errors }} = this.store.select(fromRoot.get{{ $gen->entityName().'Errors' }});

    // download the form model
    this.store.dispatch(new {{ $actions }}.GetFormModelAction(null));
    // download the form data
    this.store.dispatch(new {{ $actions }}.GetFormDataAction(null));

    this.setupForm();

    this.translateService
      .get(this.translateKey + this.title)
      .subscribe(val => this.titleService.setTitle(val));

    this.translateService
      .get(this.translateKey + 'delete-alert')
      .subscribe(val => this.deleteAlert = val);
  }

  public ngOnInit() {
    this.appMessages$ = this.store.select(fromRoot.getAppMessagesState);
  	this.{{ $state }} = this.store.select(fromRoot.get{{ $gen->entityName() }}State);
  	this.onSearch();
  }

  private setupForm() {
    this.formModelSubscription$ = this.{{ $formModel }}
      .subscribe((model) => {
        if (model) {
          this.{{ $form }} = this.FormModelParserService.toFormGroup(model);
          this.formConfigured = true;
        }
      });
  }

  public onSearch(data: Object = {}) {
    this.queryData = _.merge({}, this.queryData, data, { advanced_search: false });
    this.store.dispatch(new {{ $actions }}.LoadAction(this.queryData));
  }

  public onAdvancedSearch(data: Object = {}) {
    if (!_.isEmpty(data)) {
      this.queryData = _.assign({}, this.queryData, data);
      this.store.dispatch(new documentTypeActions.LoadAction(this.queryData));
    }
  }

  public deleteRow(id: string) {
    swal({
      title: this.deleteAlert.title,
      text: this.deleteAlert.text,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: this.deleteAlert.confirm_btn_text,
      cancelButtonText: this.deleteAlert.cancel_btn_text,
      confirmButtonColor: '#ed5565'
    }).then(() => {
      this.store.dispatch(new {{ $actions }}.DeleteAction(id));
    }).catch(swal.noop);
  }
}
