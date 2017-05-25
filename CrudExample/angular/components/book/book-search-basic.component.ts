import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormGroup, FormBuilder } from '@angular/forms';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';

import * as fromRoot from './../../../reducers';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as bookActions from './../../actions/book.actions';

import { Book } from './../../models/book';

import { BookAbstractComponent, SearchQuery } from './book-abstract.component';

/**
 * BookSearchBasicComponent Class.
 *
 * @author  [name] <[<email address>]>
 */
@Component({
  selector: 'book-search-basic-component',
  templateUrl: './book-search-basic.component.html',
  exportAs: 'book-search-basic',
})
export class BookSearchBasicComponent extends BookAbstractComponent implements OnInit {
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
