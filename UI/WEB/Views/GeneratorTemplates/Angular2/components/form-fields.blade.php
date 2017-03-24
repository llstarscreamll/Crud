import { Component, Input, OnInit } from '@angular/core';
import { FormGroup } from '@angular/forms';

import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('form-fields', false)) }}',
  templateUrl: './{{ $gen->componentFile('form-fields-html', false) }}',
  styleUrls: ['./{{ $gen->componentFile('form-fields-css', false) }}']
})
export class {{ $gen->componentClass('form-fields', $plural = false) }} implements OnInit {

  @Input()
  public {{ $form = camel_case($gen->entityName()).'Form' }}: FormGroup;
	
	@Input()
	public {{ $formModel = camel_case($gen->entityName()).'FormModel' }}: Object;

  @Input()
  public {{ $formData = camel_case($gen->entityName()).'FormData' }}: Object;

  @Input()
  public {{ $errors = 'errors' }}: Object;

  @Input()
  public formType: string = 'create';

  constructor() { }

  ngOnInit() { }

}
