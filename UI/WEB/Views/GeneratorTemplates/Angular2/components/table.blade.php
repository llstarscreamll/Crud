import { Component, EventEmitter, Input, OnDestroy, OnInit, Output } from '@angular/core';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';

import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import * as fromRoot from './../../../reducers';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../../reducers/{{ $gen->slugEntityName() }}.reducer';

import { {{ $gen->entityName() }} } from './../../models/{{ camel_case($gen->entityName()) }}';
import { {{ $gen->entityName() }}Pagination } from './../../models/{{ camel_case($gen->entityName()) }}Pagination';
import { Pagination } from './../../../core/models/pagination';

import { {{ $abstractClass = $gen->componentClass('abstract', false, true) }}, SearchQuery } from './{{ str_replace('.ts', '', $gen->componentFile('abstract', false, true)) }}';

/**
 * {{ $gen->componentClass('table', $plural = true) }} Class.
 *
 * @author [name] <[<email address>]>
 */
{{ '@' }}Component({
  selector: '{{ $selector = str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}',
  templateUrl: './{{ $gen->componentFile('table-html', $plural = true) }}',
  exportAs: '{{ str_replace('-component', '', $selector) }}',
})
export class {{ $gen->componentClass('table', $plural = true) }} extends {{ $abstractClass }} implements OnInit, OnDestroy {
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
      .subscribe((itemsList: {{ $gen->entityName() }}Pagination) => {
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

    this.store.dispatch(new {{ $actions }}.SetSearchQueryAction({ 'orderBy': orderBy, 'sortedBy': sortedBy }));
  }

  /**
   * Update the search query with the new page data.
   */
  public pageChanged(data: {page: number,itemsPerPage: number}) {
    this.store.dispatch(new {{ $actions }}.SetSearchQueryAction({page: data.page}));
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
