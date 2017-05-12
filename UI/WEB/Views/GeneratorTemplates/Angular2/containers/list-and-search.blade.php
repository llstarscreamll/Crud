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
  /**
   * Page title.
   * @type string
   */
  protected title: string = 'module-name-plural';

  /**
   * Form type to render (create|update|details). Because some fields could not
   * be shown based on the form type.
   * @type string
   */
  public formType: string = 'search';

  /**
   * Flag that tell as if the advanced search form should be shown or not.
   * @type boolean
   */
  public showAdvancedSearchForm: boolean = false;

  /**
   * Flag that tell as if the form is ready to be shown or not.
   * @type boolean
   */
  public formConfigured: boolean = false;

  /**
   * Advanced search form model, this form is based on the main form model. Have
   * the object config fields to show on advanced search form.
   * @type Object
   */
  public advancedSearchFormModel: Object;
  
  /**
   * Advanced search form group.
   * @type FormGrop
   */
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

  /**
   * {{ $gen->containerClass('list-and-search', $plural = true) }} constructor.
   */
  public constructor(
    protected store: Store<fromRoot.State>,
    protected location: Location,
    protected titleService: Title,
    protected translateService: TranslateService,
    protected formModelParserService: FormModelParserService
  ) { super(); }

  /**
   * The component is ready, this is called after the constructor and after the
   * first ngOnChanges(). This is invoked only once when the component is
   * instantiated.
   */
  public ngOnInit() {
    this.setDocumentTitle();
    this.setupStoreSelects();
    this.initForm();
    this.setupForm();
  	this.onSearch();
  }

  /**
   * Parse the default form model to advanced search form model and parse the
   * last one to form group.
   */
  private setupForm() {
    this.formModelSubscription$ = this.formModel$
      .subscribe((model) => {
        if (model) {
          // parse form model to advenced search form model
          this.advancedSearchFormModel = this.formModelParserService
            .parseToSearch(model, this.tableColumns, this.translateKey);
          this.advancedSearchForm = this.formModelParserService
            .toFormGroup(this.advancedSearchFormModel);
          
          // patch form values
          this.advancedSearchForm.get('options').patchValue(this.searchQuery);
          this.advancedSearchForm.get('search').patchValue(this.searchQuery);

          this.formConfigured = true;
        }
      });
  }

  /**
   * Trigger the basic search based on the given data.
   */
  public onSearch(data: Object = {}) {
    this.searchQuery = Object.assign({}, this.searchQuery, data, { advanced_search: false });
    this.store.dispatch(new {{ $actions }}.LoadAction(this.searchQuery));
  }

  /**
   * Trigger the advenced search based on the given data.
   */
  public onAdvancedSearch() {
    let options = {};

    // any advanced search field have changed?
    if (!this.advancedSearchForm.get('search').pristine) {
      Object.assign(options, this.advancedSearchForm.get('search').value, { advanced_search: true, page: 1 });
    }

    // any option search field have changed?
    if (!this.advancedSearchForm.get('options').pristine) {
      Object.assign(options, this.advancedSearchForm.get('options').value);
    }

    // are there something to search?
    if (!isEmpty(options)) {
      this.searchQuery = Object.assign({}, this.searchQuery, options);
      this.store.dispatch(new {{ $actions }}.LoadAction(this.searchQuery));
    }
  }
}
