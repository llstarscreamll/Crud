import { Component, Input, OnInit } from '@angular/core';
import { {{ $gen->entityName() }} } from './../models/{{ camel_case($gen->entityName()) }}';
import { Pagination } from './../../core/models/pagination';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}',
  templateUrl: './{{ $gen->componentFile('table-html', $plural = true) }}',
  styleUrls: ['./{{ $gen->componentFile('table-css', $plural = true) }}']
})
export class {{ $gen->componentClass('table', $plural = true) }} implements OnInit {
	
	@Input() columns = [];
	@Input() {{ camel_case($gen->entityName(true)) }}: {{ $gen->entityName() }}[] = [];
  @Input() pagination: Pagination;
  public translateKey: String = "{{ $gen->entityNameUppercase() }}";

  constructor() { }

  ngOnInit() { }

  showColumn(column): boolean {
  	return this.columns.indexOf(column) > -1;
  }

}
