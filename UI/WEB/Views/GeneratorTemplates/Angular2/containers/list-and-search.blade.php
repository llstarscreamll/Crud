import { Location } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { Router } from '@angular/router';
import { Title } from '@angular/platform-browser';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';
import { isEmpty } from 'lodash';

import * as fromRoot from './../../../reducers';
import * as appMessage from './../../../core/reducers/app-message.reducer';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../../reducers/{{ $gen->slugEntityName() }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';
import { {{ $abstractClass = $gen->containerClass('abstract', false, true) }}, SearchQuery } from './{{ str_replace('.ts', '', $gen->containerFile('abstract', false, true)) }}';

/**
 * {{ $gen->containerClass('list-and-search', $plural = true) }} Class.
 *
 * @author [name] <[<email address>]>
 */
{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('list-and-search', true)) }}',
  templateUrl: './{{ $gen->containerFile('list-and-search-html', true) }}',
  styleUrls: ['./{{ $gen->containerFile('list-and-search-css', true) }}']
})
export class {{ $gen->containerClass('list-and-search', $plural = true) }} extends {{ $abstractClass }} implements OnInit {
  protected title: string = 'module-name-plural';
  public formType: string = 'search';
  public showSearchOptions: boolean = false;
  public formConfigured: boolean = false;
  public advancedSearchFormModel: Object;
  public form: FormGroup;
  public advancedSearchForm: FormGroup;

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

  public constructor(
    protected store: Store<fromRoot.State>,
    protected location: Location,
    protected titleService: Title,
    protected translateService: TranslateService,
    protected formModelParserService: FormModelParserService
  ) { super(); }

  public ngOnInit() {
    this.setDocumentTitle();
    this.setupStoreSelects();
    this.initForm();
    this.setupForm();
  	this.onSearch();
  }

  private setupForm() {
    this.formModelSubscription$ = this.formModel$
      .subscribe((model) => {
        if (model) {
          this.form = this.formModelParserService.toFormGroup(model);
          this.setupAdvancedSearchForm(model);
          this.formConfigured = true;
        }
      });
  }

  public setupAdvancedSearchForm(model: Object) {
    this.advancedSearchFormModel = this.formModelParserService.parseToSearch(model, this.tableColumns, this.translateKey);
    this.advancedSearchForm = this.formModelParserService.toFormGroup(this.advancedSearchFormModel);
    this.advancedSearchForm.get('options').patchValue(this.searchQuery);
    this.advancedSearchForm.get('search').patchValue(this.searchQuery);
  }

  public onSearch(data: Object = {}) {
    this.searchQuery = Object.assign({}, this.searchQuery, data, { advanced_search: false });
    this.store.dispatch(new {{ $actions }}.LoadAction(this.searchQuery));
  }

  public onAdvancedSearch() {
    let options = {};

    if (!this.advancedSearchForm.get('search').pristine) {
      Object.assign(options, this.advancedSearchForm.get('search').value, { advanced_search: true, page: 1 });
    }

    if (!this.advancedSearchForm.get('options').pristine) {
      Object.assign(options, this.advancedSearchForm.get('options').value);
    }

    if (!isEmpty(options)) {
      this.searchQuery = Object.assign({}, this.searchQuery, options);
      this.store.dispatch(new {{ $actions }}.LoadAction(this.searchQuery));
    }
  }
}
