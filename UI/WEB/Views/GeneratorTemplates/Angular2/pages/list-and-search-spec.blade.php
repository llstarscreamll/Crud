/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, getTestBed, inject, tick } from '@angular/core/testing';
import { Location } from '@angular/common';
import { Router, ActivatedRoute } from '@angular/router';
import { Http } from '@angular/http';
import { Store, StoreModule } from '@ngrx/store';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { Observable } from 'rxjs/Observable';

import * as fromRoot from './../../../reducers';

import * as utils from './../../utils/{{ $crud->slugEntityName() }}-testing.util';
import { {{ $model = $crud->entityName() }} } from './../../models/{{ camel_case($crud->entityName()) }}';
import { {{ $crud->getLanguageKey(true) }} } from './../../translations/{{ $crud->getLanguageKey() }}';
import { {{ $cpmClass = $crud->containerClass('list-and-search', true) }} } from './{{ str_replace('.ts', '', $crud->containerFile('list-and-search', true)) }}';
import { {{ $components = $crud->entityName().'Components' }} } from './../../components/{{ $crud->slugEntityName().'' }}';
import { {{ $pages = $crud->entityName().'Pages' }} } from './../../pages/{{ $crud->slugEntityName().'' }}';
import { {{ $service = $crud->entityName().'Service' }} } from './../../services/{{ $crud->slugEntityName() }}.service';
import { AUTH_TESTING_COMPONENTS } from "app/auth/utils/auth-testing-utils";

/**
 * {{ $crud->containerClass('list-and-search', $plural = true) }} Tests.
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
  let http: Http;
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
    http = getTestBed().get(Http);
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

  it('should have certain html components', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    let html = fixture.nativeElement;

    expect(html.querySelector('{{ $crud->slugEntityName() }}-search-basic-component')).not.toBeNull('basic search component');
    expect(html.querySelector('{{ $crud->slugEntityName(true) }}-table-component')).not.toBeNull('table list component');
    expect(html.querySelector('{{ $crud->slugEntityName() }}-search-advanced-component')).toBeNull('advanced search component');

    // click btn to display advanced search form
    html.querySelector('{{ $crud->slugEntityName() }}-search-basic-component form button.advanced-search-btn').click();

    fixture.detectChanges();
    tick(500);

    expect(html.querySelector('{{ $crud->slugEntityName() }}-search-advanced-component')).not.toBeNull('advanced search component');
  }));

  it('should navigate on create btn click', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    spyOn(router, 'navigateByUrl');
    fixture.nativeElement.querySelector('a.btn i.glyphicon-plus').click();

    fixture.detectChanges();

    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/{{ $crud->slugEntityName() }}/create'),
      { skipLocationChange: false, replaceUrl: false }
    );
  }));

  it('should show advanced search form on btn click', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    expect(component.showAdvancedSearchForm).toBe(false);
    expect(fixture.nativeElement.querySelector('{{ $crud->slugEntityName() }}-search-advanced-component')).toBeNull('advanced search component');

    fixture.nativeElement.querySelector('{{ $crud->slugEntityName() }}-search-basic-component form button.advanced-search-btn').click();

    fixture.detectChanges();
    tick(500);

    expect(component.showAdvancedSearchForm).toBe(true);
    expect(fixture.nativeElement.querySelector('{{ $crud->slugEntityName() }}-search-advanced-component')).not.toBeNull('advanced search component');
  }));
});
