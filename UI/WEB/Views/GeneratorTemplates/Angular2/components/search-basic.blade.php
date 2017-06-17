import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormGroup, FormBuilder } from '@angular/forms';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';

import * as fromRoot from './../../../reducers';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as {{ $actions = camel_case($crud->entityName()).'Actions' }} from './../../actions/{{ $crud->slugEntityName() }}.actions';

import { {{ $entitySin = $crud->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';

import { {{ $abstractClass = $crud->componentClass('abstract', false, true) }}, SearchQuery } from './{{ str_replace('.ts', '', $crud->componentFile('abstract', false, true)) }}';

/**
 * {{ $crud->componentClass('search-basic', $plural = false) }} Class.
 *
 * @author [name] <[<email address>]>
 */
{{ '@' }}Component({
  selector: '{{ $selector = str_replace(['.ts', '.'], ['', '-'], $crud->componentFile('search-basic', false)) }}',
  templateUrl: './{{ $crud->componentFile('search-basic-html', false) }}',
  exportAs: '{{ str_replace('-component', '', $selector) }}',
})
export class {{ $crud->componentClass('search-basic', $plural = false) }} extends {{ $abstractClass }} implements OnInit {
  @Output()
  public advancedSearchBtnClick = new EventEmitter<null>();
  
  public searchForm: FormGroup;

  public constructor(
    private fb: FormBuilder,
    protected store: Store<fromRoot.State>,
    protected translateService: TranslateService,
    protected formModelParserService: FormModelParserService,
    ) { super(); }

  public ngOnInit() {
  	this.searchForm = this.fb.group({
      search: [''],
      page: [1]
    });
  }
}
