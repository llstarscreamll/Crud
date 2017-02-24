import { Component, Input, OnInit } from '@angular/core';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}',
  templateUrl: './{{ $gen->componentFile('table-html', $plural = true) }}',
  styleUrls: ['./{{ $gen->componentFile('table-css', $plural = true) }}']
})
export class {{ $gen->componentClass('table', $plural = true) }} implements OnInit {
	
	@Input() columns = [
@foreach ($fields as $field)
@if ($field->on_index_table)
		'{{ $field->name }}',
@endif
@endforeach
	];

  constructor() { }

  ngOnInit() { }

  showColumn(column): boolean {
  	return this.columns.indexOf(column) > -1;
  }

}
