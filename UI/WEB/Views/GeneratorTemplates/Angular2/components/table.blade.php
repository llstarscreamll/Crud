import { Component, EventEmitter, Input, OnInit, Output } from '@angular/core';
import { TranslateService } from 'ng2-translate';

import { {{ $gen->entityName() }} } from './../../models/{{ camel_case($gen->entityName()) }}';
import { Pagination } from './../../../core/models/pagination';
import swal from 'sweetalert2';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}',
  templateUrl: './{{ $gen->componentFile('table-html', $plural = true) }}',
  styleUrls: ['./{{ $gen->componentFile('table-css', $plural = true) }}']
})
export class {{ $gen->componentClass('table', $plural = true) }} implements OnInit {
	
	@Input()
  columns = [];

	@Input()
  {{ camel_case($gen->entityName(true)) }}: {{ $gen->entityName() }}[] = [];

  @Input()
  public sortedBy: string = '';

  @Input()
  public orderBy: string = '';

  @Output()
  public sortLinkClicked = new EventEmitter<Object>();
  
  @Output()
  public deleteBtnClicked = new EventEmitter<string>();
  
  public translateKey: string = '{{ $gen->entityNameSnakeCase() }}';
  private deleteAlert: Object;

  public constructor(private translateService: TranslateService) { }

  public ngOnInit() {
    this.translateService
      .get(this.translateKey+'.delete-alert')
      .subscribe(val => this.deleteAlert = val);
  }

  public showColumn(column): boolean {
  	return this.columns.indexOf(column) > -1;
  }

  public deleteBtnClick(id) {
    swal({
      title: this.deleteAlert.title,
      text: this.deleteAlert.text,
      type: 'warning',
      showCancelButton: true,
      confirmButtonText: this.deleteAlert.confirm_btn_text,
      cancelButtonText: this.deleteAlert.cancel_btn_text,
      confirmButtonColor: '#ed5565'
    }).then(() => {
      this.deleteBtnClicked.emit(id);
    }).catch(swal.noop);
  }
}
