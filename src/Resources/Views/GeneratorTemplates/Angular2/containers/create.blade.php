import { Component, OnInit } from '@angular/core';

{{ '@' }}Component({
  selector: '{{ $gen->componentFile('create', false) }}',
  templateUrl: './{{ $gen->componentFile('create-html', false) }}',
  styleUrls: ['./{{ $gen->componentFile('create-css', false) }}']
})
export class {{ $gen->componentClass('create', $plural = false) }} implements OnInit {

  constructor() { }

  ngOnInit() { }

}
