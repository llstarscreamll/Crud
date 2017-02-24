import { Component, OnInit } from '@angular/core';

{{ '@' }}Component({
  selector: '{{ $gen->componentFile('list-and-search', true) }}',
  templateUrl: './{{ $gen->componentFile('list-and-search-html', true) }}',
  styleUrls: ['./{{ $gen->componentFile('list-and-search-css', true) }}']
})
export class {{ $gen->componentClass('list-and-search', $plural = true) }} implements OnInit {

  constructor() { }

  ngOnInit() { }

}
