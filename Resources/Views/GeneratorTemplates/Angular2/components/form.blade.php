import { Component, OnInit } from '@angular/core';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('form', false)) }}',
  templateUrl: './{{ $gen->componentFile('form-html', false) }}',
  styleUrls: ['./{{ $gen->componentFile('form-css', false) }}']
})
export class {{ $gen->componentClass('form', $plural = false) }} implements OnInit {

  constructor() { }

  ngOnInit() { }

}
