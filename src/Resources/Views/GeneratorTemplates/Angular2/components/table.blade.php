import { Component, Input, OnInit } from '@angular/core';
import { {{ $gen->entityName() }} } from './../models/{{ camel_case($gen->entityName()) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}',
  templateUrl: './{{ $gen->componentFile('table-html', $plural = true) }}',
  styleUrls: ['./{{ $gen->componentFile('table-css', $plural = true) }}']
})
export class {{ $gen->componentClass('table', $plural = true) }} implements OnInit {
	
	@Input() columns = [
@foreach ($fields as $field)
@if ($field->on_index_table && !$field->hidden)
		'{{ $field->name }}',
@endif
@endforeach
	];

	@Input() {{ camel_case($gen->entityName(true)) }}: {{ $gen->entityName() }}[] = [];

  constructor() { }

  ngOnInit() { }

  showColumn(column): boolean {
  	return this.columns.indexOf(column) > -1;
  }

}
