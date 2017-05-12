import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';

import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';

/**
 * {{ $gen->componentClass('search-advanced', $plural = false) }} Class.
 *
 * @author [name] <[<email address>]>
 */
{{ '@' }}Component({
  selector: '{{ $selector = str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('search-advanced', false)) }}',
  templateUrl: './{{ $gen->componentFile('search-advanced-html', false) }}',
  exportAs: '{{ str_replace('-component', '', $selector) }}',
})
export class {{ $gen->componentClass('search-advanced', $plural = false) }} implements OnInit {
  @Input()
  public formModel: any;

  @Input()
  public formData: any;

  @Input()
  public form: FormGroup;

  @Input()
  public errors: Object = {};

  @Input()
  public debug: boolean = false;

  @Output()
  public search = new EventEmitter<null>();
  
  public constructor() { }

  public ngOnInit() { }
}
