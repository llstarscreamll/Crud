import { Component, OnInit } from '@angular/core';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('edit', false)) }}',
  templateUrl: './{{ $gen->containerFile('edit-html', false) }}',
  styleUrls: ['./{{ $gen->containerFile('edit-css', false) }}']
})
export class {{ $gen->containerClass('edit', $plural = false) }} implements OnInit {

  constructor() { }

  ngOnInit() { }

}
