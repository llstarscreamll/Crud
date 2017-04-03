import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { FormBuilder, FormControl, FormGroup, ReactiveFormsModule } from '@angular/forms';

import { FormModelParserService } from './../../../core/services/form-model-parser.service';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('search-advanced', false)) }}',
  templateUrl: './{{ $gen->componentFile('search-advanced-html', false) }}',
  styleUrls: ['./{{ $gen->componentFile('search-advanced-css', false) }}']
})
export class {{ $gen->componentClass('search-advanced', $plural = false) }} implements OnInit {
  @Input()
  public translateKey: string;

  @Input()
  public allTableColumns: string[];

  @Input()
  public selectedTableColumns: string[];

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
  public search = new EventEmitter<Object>();
  
  public constructor(private fb: FormBuilder, private fmp: FormModelParserService) { }

  public ngOnInit() {
  	this.formModel = this.fmp.parseToSearch(this.formModel, this.allTableColumns, this.translateKey);
    this.form = this.fmp.toFormGroup(this.formModel);
  }

  public onSubmit() {
    let options = {};

    if (!this.form.get('search').pristine) {
      Object.assign(options, this.form.get('search').value, { advanced_search: true, page: 1 });
    }

    if (!this.form.get('options').pristine) {
      Object.assign(options, this.form.get('options').value);
    }

    return this.search.emit(options);
  }
}
