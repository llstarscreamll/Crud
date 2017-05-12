import { Component, EventEmitter, Input, OnDestroy, OnInit, Output } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';
import { Router, ActivatedRoute } from '@angular/router';
import { isEmpty } from 'lodash';

import * as fromRoot from './../../../reducers';
import * as appMessage from './../../../core/reducers/app-message.reducer';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../../reducers/{{ $gen->slugEntityName() }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';

import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';
import { {{ $abstractClass = $gen->componentClass('abstract', false, true) }}, SearchQuery } from './{{ str_replace('.ts', '', $gen->componentFile('abstract', false, true)) }}';

/**
 * {{ $gen->componentClass('search-advanced', $plural = false) }} Class.
 *
 * @author [name] <[<email address>]>
 */
{{ '@' }}Component({
  selector: '{{ $selector = str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('search-advanced', false)) }}',
  templateUrl: './{{ $gen->componentFile('search-advanced-html', false) }}',
  exportAs: '{{ str_replace('-component', '', $selector) }}',
})
export class {{ $gen->componentClass('search-advanced', $plural = false) }} extends {{ $abstractClass }} implements OnInit, OnDestroy {
  @Input()
  public debug: boolean = false;

  @Output()
  public search = new EventEmitter<null>();

  /**
   * Form type to render (create|update|details). Because some fields could not
   * be shown based on the form type.
   * @type string
   */
  public formType: string = 'search';

  /**
   * Advanced search form model, this form is based on the main form model. Have
   * the object config fields to show on advanced search form.
   * @type Object
   */
  public formModel: {search: any, options: any};

  /**
   * Advanced search form group.
   * @type FormGrop
   */
  public form: FormGroup;
  
  public constructor(
    protected store: Store<fromRoot.State>,
    protected formModelParserService: FormModelParserService,
    protected translateService: TranslateService,
    protected activedRoute: ActivatedRoute,
  ) { super(); }

  public ngOnInit() {
    this.setupStoreSelects();
    this.initForm();
    this.setupForm();
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
          this.formModel = this.formModelParserService
            .parseToSearch(model, this.tableColumns, this.langKey);
          this.form = this.formModelParserService
            .toFormGroup(this.formModel);
          
          // patch form values
          this.form.get('options').patchValue(this.searchQuery);
          this.form.get('search').patchValue(this.searchQuery);

          this.formConfigured = true;
        }
      });
  }

  /**
   * Trigger the advenced search based on the given data.
   */
  public onAdvancedSearch() {
    let options = {};

    // any advanced search field have changed?
    if (!this.form.get('search').pristine) {
      Object.assign(options, this.form.get('search').value, { advanced_search: true, page: 1 });
    }

    // any option search field have changed?
    if (!this.form.get('options').pristine) {
      Object.assign(options, this.form.get('options').value);
    }

    // are there something to search?
    if (!isEmpty(options)) {
      this.searchQuery = Object.assign({}, this.searchQuery, options);
      this.store.dispatch(new {{ $actions }}.LoadAction(this.searchQuery));
    }
  }

  /**
   * Clean the component canceling the background taks. This is called before the
   * component instance is funally destroyed.
   */
  public ngOnDestroy() {
    this.formModelSubscription$.unsubscribe();
  }
}
