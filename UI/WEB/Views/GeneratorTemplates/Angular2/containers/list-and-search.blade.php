import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Title } from '@angular/platform-browser';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { TranslateService } from 'ng2-translate';
import { isEmpty } from 'lodash';

import * as fromRoot from './../../../reducers';
import * as appMessage from './../../../core/reducers/app-message.reducer';
import { FormModelParserService } from './../../../core/services/form-model-parser.service';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../../reducers/{{ $gen->slugEntityName() }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';
import { {{ $abstractClass = $gen->containerClass('abstract', false, true) }}, SearchQuery } from './{{ str_replace('.ts', '', $gen->containerFile('abstract', false, true)) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('list-and-search', true)) }}',
  templateUrl: './{{ $gen->containerFile('list-and-search-html', true) }}',
  styleUrls: ['./{{ $gen->containerFile('list-and-search-css', true) }}']
})
export class {{ $gen->containerClass('list-and-search', $plural = true) }} extends {{ $abstractClass }} implements OnInit {
  protected title: string = 'module-name-plural';
  public formType: string = 'search';
  public showSearchOptions: boolean = false;
  public {{ $form = camel_case($gen->entityName()).'Form' }}: FormGroup;
  public formConfigured: boolean = false;

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
    orderBy: "{{ $gen->tableName.'.created_at' }}",
    sortedBy: "desc",
    page: 1
  };

  public constructor(
    protected store: Store<fromRoot.State>,
    protected router: Router,
    protected titleService: Title,
    protected translateService: TranslateService,
    protected FormModelParserService: FormModelParserService
  ) { super(); }

  public ngOnInit() {
    this.setDocumentTitle();
    this.setupStoreSelects();
    this.setupForm();
  	this.onSearch();
  }

  private setupForm() {
    // download the form model
    this.store.dispatch(new {{ $actions }}.GetFormModelAction(null));
    // download the form data
    this.store.dispatch(new {{ $actions }}.GetFormDataAction(null));

    this.formModelSubscription$ = this.{{ $formModel = camel_case($gen->entityName()).'FormModel$' }}
      .subscribe((model) => {
        if (model) {
          this.{{ $form }} = this.FormModelParserService.toFormGroup(model);
          this.formConfigured = true;
        }
      });
  }

  public onSearch(data: Object = {}) {
    this.searchQuery = Object.assign({}, this.searchQuery, data, { advanced_search: false });
    this.store.dispatch(new {{ $actions }}.LoadAction(this.searchQuery));
  }

  public onAdvancedSearch(data: Object = {}) {
    if (!isEmpty(data)) {
      this.searchQuery = Object.assign({}, this.searchQuery, data);
      this.store.dispatch(new {{ $actions }}.LoadAction(this.searchQuery));
    }
  }
}
