/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, inject, getTestBed, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { Observable } from 'rxjs/Observable';
import { Store } from '@ngrx/store';
import { Router, ActivatedRoute } from '@angular/router';

import * as fromRoot from './../../../reducers';
import { DynamicFormModule } from './../../../dynamic-form/dynamic-form.module';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';

import { {{ $cmpClass = $crud->componentClass('search-basic', $plural = false) }} } from './{{ str_replace('.ts', '', $crud->componentFile('search-basic', false)) }}';
import { {{ $crud->getLanguageKey(true) }} } from './../../translations/{{ $crud->getLanguageKey() }}';
import { {{ $service = $crud->entityName().'Service' }} } from './../../services/{{ $crud->slugEntityName() }}.service';
import { {{ $model = $crud->entityName() }} } from './../../models/{{ camel_case($crud->entityName()) }}';
import * as utils from './../../utils/{{ $crud->slugEntityName() }}-testing.util';
import { AUTH_TESTING_COMPONENTS } from "app/auth/utils/auth-testing-utils";

/**
 * {{ $crud->componentClass('search-basic', $plural = false) }} Tests.
 *
 * @author [name] <[<email address>]>
 */
describe('{{ $cmpClass }}', () => {
  let fixture: ComponentFixture<{{ $cmpClass }}>;
  let component: {{ $cmpClass }};
  let testModel: {{ $crud->entityName() }} = utils.{{ $crud->entityName() }}One;
  let reactiveForm;
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let service: {{ $crud->entityName() }}Service;
  let http: Http;
  let router: Router;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [...AUTH_TESTING_COMPONENTS, {{ $cmpClass }}],
      imports: [
        utils.IMPORTS
      ],
      providers: [
        utils.PROVIDERS
      ]
    }).compileComponents();

    store = getTestBed().get(Store);
    router = getTestBed().get(Router);
    http = getTestBed().get(Http);
    service = getTestBed().get({{ $crud->entityName() }}Service);

    mockBackend = getTestBed().get(MockBackend);
    utils.setupMockBackend(mockBackend);

    fixture = getTestBed().createComponent({{ $cmpClass }});
    component = fixture.componentInstance;
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

  it('should make {{ $crud->entityName() }}Service paginate call on form submission', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{}]));
    fixture.detectChanges();

    let searchField = fixture.nativeElement.querySelector('input[name=search]');
    let searchBtn = fixture.nativeElement.querySelector('button[type=submit]');

    expect(searchBtn).not.toBeNull();
    expect(searchField).not.toBeNull();
    
    searchField.value = 'foo search';
    searchBtn.click();
    
    fixture.detectChanges();
    tick();

    expect(service.paginate).toHaveBeenCalled();
  }));

  it('should emit event on advanced search btn click', () => {    
    spyOn(component.advancedSearchBtnClick, 'emit');
    fixture.detectChanges();
    let advancedSearchBtn = fixture.nativeElement.querySelector('button[type=button].advanced-search-btn');

    expect(advancedSearchBtn).not.toBeNull();

    advancedSearchBtn.dispatchEvent(new Event('click'));
    fixture.detectChanges();

    expect(component.advancedSearchBtnClick.emit).toHaveBeenCalledWith();
  });
});
