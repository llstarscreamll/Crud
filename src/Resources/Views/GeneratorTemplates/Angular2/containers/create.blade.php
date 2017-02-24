import { Component, OnInit } from '@angular/core';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('create', false)) }}',
  templateUrl: './{{ $gen->containerFile('create-html', false) }}',
  styleUrls: ['./{{ $gen->containerFile('create-css', false) }}']
})
export class {{ $gen->containerClass('create', $plural = false) }} implements OnInit {

  constructor() { }

  ngOnInit() { }

}
