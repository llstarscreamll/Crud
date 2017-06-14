import { Component, EventEmitter, Input, OnDestroy, OnInit, Output } from '@angular/core';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';

import * as bookActions from './../../actions/book.actions';
import * as fromRoot from './../../../reducers';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as bookReducer from './../../reducers/book.reducer';

import { Book } from './../../models/book';
import { BookPagination } from './../../models/bookPagination';
import { Pagination } from './../../../core/models/pagination';

import { BookAbstractComponent, SearchQuery } from './book-abstract.component';

/**
 * BooksTableComponent Class.
 *
 * @author  [name] <[<email address>]>
 */
@Component({
  selector: 'books-table-component',
  templateUrl: './books-table.component.html',
  exportAs: 'books-table',
})
export class BooksTableComponent extends BookAbstractComponent implements OnInit, OnDestroy {
  /**
   * Pagination info.
   */
  pagination: any;

  public constructor(
    protected store: Store<fromRoot.State>,
    protected translateService: TranslateService,
    protected formModelParserService: FormModelParserService,
  ) { super(); }

  public ngOnInit() {
    this.setupStoreSelects();
    this.onSearch();

    this.itemsListSubscription$ = this.itemsPagination$
      .subscribe((itemsList: BookPagination) => {
        if (itemsList) {
          this.pagination = itemsList.pagination;
        }
      });
  }

  /**
   * Should a certain column be shown?.
   */
  public showColumn(column): boolean {
    return this.searchQuery.filter.indexOf(column) > -1;
  }

  /**
   * Update the search query with the new sortBy and sortedBy data.
   */
  public onSort(column: string) {
    let orderBy = column;
    let sortedBy = this.sortedBy == 'desc' || this.orderBy != column
      ? 'asc'
      : 'desc';

    this.store.dispatch(new bookActions.SetSearchQueryAction({ 'orderBy': orderBy, 'sortedBy': sortedBy }));
  }

  /**
   * Update the search query with the new page data.
   */
  public pageChanged(data: {page: number,itemsPerPage: number}) {
    this.store.dispatch(new bookActions.SetSearchQueryAction({page: data.page}));
  }

  get orderBy() {
    return this.searchQuery.orderBy;
  }

  get sortedBy() {
    return this.searchQuery.sortedBy;
  }

  get columns() {
    return this.searchQuery.filter;
  }

  get currentPage() {
    return this.pagination ? this.pagination.current_page : 1;
  }

  set currentPage(val) {
    val ? val : this.pagination.current_page;
  }

  /**
   * Clean the component canceling the background taks. This is called before the
   * component instance is funally destroyed.
   */
  public ngOnDestroy() {
    super.ngOnDestroy();
  }
}
