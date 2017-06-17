/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, getTestBed, inject, tick } from '@angular/core/testing';
import { Location } from '@angular/common';
import { Router, ActivatedRoute } from '@angular/router';
import { Store, StoreModule } from '@ngrx/store';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { Observable } from 'rxjs/Observable';

import * as fromRoot from './../../../reducers';

import * as utils from './../../utils/{{ $crud->slugEntityName() }}-testing.util';
import { {{ $model = $crud->entityName() }} } from './../../models/{{ camel_case($crud->entityName()) }}';
import { {{ $crud->getLanguageKey(true) }} } from './../../translations/{{ $crud->getLanguageKey() }}';
import { {{ $cpmClass = $crud->containerClass('form', false, true) }} } from './{{ str_replace('.ts', '', $crud->containerFile('form', false, true)) }}';
import { {{ $components = $crud->entityName().'Components' }} } from './../../components/{{ $crud->slugEntityName().'' }}';
import { {{ $pages = $crud->entityName().'Pages' }} } from './../../pages/{{ $crud->slugEntityName().'' }}';
import { {{ $service = $crud->entityName().'Service' }} } from './../../services/{{ $crud->slugEntityName() }}.service';
import { AUTH_TESTING_COMPONENTS } from "app/auth/utils/auth-testing-utils";

/**
 * {{ $crud->containerClass('form', false, true) }} Tests.
 *
 * @author [name] <[<email address>]>
 */
describe('{{ $cpmClass }}', () => {
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let fixture: ComponentFixture<{{ $cpmClass }}>;
  let component: {{ $cpmClass }};
  let router: Router;
  let location: Location;
  let service: {{ $service }};
  let testModel: {{ $crud->entityName() }} = utils.{{ $crud->entityName() }}One;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [
        ...AUTH_TESTING_COMPONENTS,
        ...{{ $components }},
        ...{{ $pages }},
      ],
      imports: [
        ...utils.IMPORTS,
      ],
      providers: [
        ...utils.PROVIDERS,
      ]
    }).compileComponents();

    store = getTestBed().get(Store);
    router = getTestBed().get(Router);
    location = getTestBed().get(Location);
    service = getTestBed().get({{ $service }});

    mockBackend = getTestBed().get(MockBackend);
    utils.setupMockBackend(mockBackend);
    
    fixture = getTestBed().createComponent({{ $cpmClass }});
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

  it('should have certain elements', () => {
    fixture.detectChanges();
    let html = fixture.nativeElement;

    // should have sidebar-layout
    expect(html.querySelector('app-sidebar-layout')).not.toBeNull();

    // should have page header
    expect(html.querySelector('app-page-header')).not.toBeNull();

    // should have page content
    expect(html.querySelector('app-page-content')).not.toBeNull();

    // should have box where the form is located
    expect(html.querySelector('app-box app-box-body')).not.toBeNull();

    // should have form component inside app-box-body
    expect(html.querySelector('app-box-body {{ $crud->slugEntityName() }}-form-component')).not.toBeNull();
  });

  it('should have default form type = create', () => {
    fixture.detectChanges();
    expect(component.formType).toBe('create');
  });

  it('should set form type = create based on current url', () => {
    spyOn(location, 'path').and.returnValue('{{ $crud->slugEntityName() }}/create');
    fixture.detectChanges();

    expect(component.formType).toBe('create');
  });

  it('should set form type = details based on current url', () => {
    spyOn(location, 'path').and.returnValue('{{ $crud->slugEntityName() }}/a1/details');
    fixture.detectChanges();

    expect(component.formType).toBe('details');
  });

  it('should set form type = edit based on current url', () => {
    spyOn(location, 'path').and.returnValue('{{ $crud->slugEntityName() }}/a1/edit');
    fixture.detectChanges();

    expect(component.formType).toBe('edit');
  });
});
