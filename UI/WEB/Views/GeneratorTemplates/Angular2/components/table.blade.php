import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';

import { {{ $gen->entityName() }} } from './../../models/{{ camel_case($gen->entityName()) }}';
import { Pagination } from './../../../core/models/pagination';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}',
  templateUrl: './{{ $gen->componentFile('table-html', $plural = true) }}',
  styleUrls: ['./{{ $gen->componentFile('table-css', $plural = true) }}']
})
export class {{ $gen->componentClass('table', $plural = true) }} implements OnInit {
	@Input()
  columns = [];

	@Input()
  {{ camel_case($gen->entityName(true)) }}: {{ $gen->entityName() }}[] = [];

  @Input()
  public sortedBy: string = '';

  @Input()
  public pagination: Pagination;

  @Input()
  public orderBy: string = '';

  @Output()
  public updateSearch = new EventEmitter<Object>();
  
  @Output()
  public deleteBtnClicked = new EventEmitter<string>();
  
  public translateKey: string = '{{ $gen->entityNameSnakeCase() }}.';

  get currentPage() {
    return this.pagination ? this.pagination.current_page : 1;
  }

  set currentPage(val) {
    val ? val : this.pagination.current_page;
  }

  public constructor() { }

  public ngOnInit() { }

  public showColumn(column): boolean {
  	return this.columns.indexOf(column) > -1;
  }
}
