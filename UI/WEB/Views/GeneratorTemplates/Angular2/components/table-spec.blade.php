/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, inject, getTestBed, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Router, ActivatedRoute } from '@angular/router';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { ReactiveFormsModule } from '@angular/forms';
import { Ng2BootstrapModule } from 'ngx-bootstrap';

import * as fromRoot from './../../../reducers';
import * as utils from './../../utils/{{ $gen->slugEntityName() }}-testing.util';
import { {{ $gen->getLanguageKey(true) }} } from './../../translations/{{ $gen->getLanguageKey() }}';

import { {{ $cmpClass = $gen->componentClass('table', $plural = true) }} } from './{{ str_replace('.ts', '', $gen->componentFile('table', true)) }}';

describe('{{ $cmpClass }}', () => {
  let fixture: ComponentFixture<{{ $cmpClass }}>;
  let component: {{ $cmpClass }};
  let router: Router;

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
    router = getTestBed().get(Router);

    component.{{ $camelModelPlural = camel_case($gen->entityName(true)) }} = [];
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

  beforeEach(inject([TranslateService], (translateService: TranslateService) => {
    translateService.setTranslation('es', ES, true);
    translateService.setDefaultLang('es');
    translateService.use('es');
  }));

  it('should create', () => {
    fixture.detectChanges();
    expect(component).toBeTruthy();
  });

  it('should show alert msg on empty list', () => {
    fixture.detectChanges();
    let elem = fixture.nativeElement.querySelector('div.alert');

    expect(elem).not.toBeNull();
    expect(elem.textContent).toContain('{{ trans('crud::templates.no_rows_found') }}');
  });

  it('should have a table', () => {
    fixture.detectChanges();
    let table = fixture.nativeElement.querySelector('table.table-hover');

    // the table should exists
    expect(table).not.toBeNull();

    // and should have entity attributes as headings
@foreach ($fields as $field)
@if (!$field->hidden)
    expect(table.querySelector('thead tr th.{{ $field->name }}'));
@endif
@endforeach
    
    // should have a "actions" column
    expect(table.querySelector('thead tr th.action'));
  });

  it('should have table with action links/buttons', () => {
    component.{{ $camelModelPlural }} = utils.{{ $gen->entityName(false) }}List;
    fixture.detectChanges();

    let table = fixture.nativeElement.querySelector('table.table-hover');

    expect(table.querySelector('tbody').children.length).toEqual(2);
    expect(table.querySelector('tbody tr td a.details-link')).not.toBeNull();
    expect(table.querySelector('tbody tr td a.edit-link')).not.toBeNull();
    expect(table.querySelector('tbody tr td a.delete-link')).not.toBeNull();
  });

  it('should emit event/navigate on links click', () => {
    component.{{ $camelModelPlural }} = utils.{{ $gen->entityName(false) }}List;
    fixture.detectChanges();
    spyOn(router, 'navigateByUrl');
    spyOn(component.deleteBtnClicked, 'emit');
    spyOn(component.updateSearch, 'emit');

    let table = fixture.nativeElement.querySelector('table.table-hover');

    // table heading links
    table.querySelector('thead tr:first-child th.{{ $gen->tableName }}\\.name span').click();
    fixture.detectChanges();
    
    expect(component.updateSearch.emit).toHaveBeenCalledWith({ orderBy: '{{ $gen->tableName }}.name', sortedBy: 'asc' });

    // details button
    table.querySelector('tbody tr:first-child td a.details-link').click();
    fixture.detectChanges();
    
    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/{{ $gen->slugEntityName() }}/' + component.{{ $camelModelPlural }}[0].id + '/details'),
      { skipLocationChange: false, replaceUrl: false }
    );

    // edit button
    table.querySelector('tbody tr:first-child td a.edit-link').click();
    fixture.detectChanges();
    
    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/{{ $gen->slugEntityName() }}/' + component.{{ $camelModelPlural }}[0].id + '/edit'),
      { skipLocationChange: false, replaceUrl: false }
    );

    // delete button
    table.querySelector('tbody tr:first-child td a.delete-link').click();
    fixture.detectChanges();
    
    expect(component.deleteBtnClicked.emit).toHaveBeenCalledWith(component.{{ $camelModelPlural }}[0].id);
  });
});
