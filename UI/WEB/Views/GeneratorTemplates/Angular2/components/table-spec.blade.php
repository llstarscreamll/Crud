/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, inject, getTestBed, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { TranslateModule } from '@ngx-translate/core';
import { ReactiveFormsModule } from '@angular/forms';
import { Ng2BootstrapModule } from 'ngx-bootstrap';

import * as fromRoot from './../../../reducers';
import * as utils from './../../utils/{{ $gen->slugEntityName() }}-testing.util';

import { {{ $cmpClass = $gen->componentClass('table', $plural = true) }} } from './{{ str_replace('.ts', '', $gen->componentFile('table', true)) }}';

describe('{{ $cmpClass }}', () => {
  let fixture: ComponentFixture<{{ $cmpClass }}>;
  let component: {{ $cmpClass }};

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [{{ $cmpClass }}],
      imports: [
        RouterTestingModule,
        HttpModule,
        TranslateModule.forRoot(),
        ReactiveFormsModule,
        Ng2BootstrapModule.forRoot(),
      ],
      providers: []
    }).compileComponents();

    fixture = getTestBed().createComponent({{ $cmpClass }});
    component = fixture.componentInstance;

    component.columns = utils.tableColumns;
    component.translateKey = utils.translateKey;
    component.sortedBy = 'desc';
    component.orderBy = '{{ $gen->tableName.'.created_at' }}';
    component.pagination = {
      count: 0,
      current_page: 0,
      links: {
        next: '',
        previous: '',
      },
      per_page: 15,
      total: 0,
      total_pages: 0
    };
  }));

  it('should create', () => {
    fixture.detectChanges();
    expect(component).toBeTruthy();
  });
});
