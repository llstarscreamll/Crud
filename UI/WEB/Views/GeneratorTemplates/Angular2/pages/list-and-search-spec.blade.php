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

import * as utils from './../../utils/{{ $gen->slugEntityName() }}-testing.util';
import { {{ $model = $gen->entityName() }} } from './../../models/{{ camel_case($gen->entityName()) }}';
import { {{ $gen->getLanguageKey(true) }} } from './../../translations/{{ $gen->getLanguageKey() }}';
import { {{ $cpmClass = $gen->containerClass('list-and-search', true) }} } from './{{ str_replace('.ts', '', $gen->containerFile('list-and-search', true)) }}';
import { {{ $components = $gen->entityName().'Components' }} } from './../../components/{{ $gen->slugEntityName().'' }}';
import { {{ $pages = $gen->entityName().'Pages' }} } from './../../pages/{{ $gen->slugEntityName().'' }}';
import { {{ $service = $gen->entityName().'Service' }} } from './../../services/{{ $gen->slugEntityName() }}.service';

/**
 * {{ $gen->containerClass('list-and-search', $plural = true) }} Tests.
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
  let testModel: {{ $gen->entityName() }} = utils.{{ $gen->entityName() }}One;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [
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

    expect(html.querySelector('{{ $gen->slugEntityName() }}-search-basic-component')).not.toBeNull('basic search component');
    expect(html.querySelector('{{ $gen->slugEntityName(true) }}-table-component')).not.toBeNull('table list component');
    expect(html.querySelector('{{ $gen->slugEntityName() }}-search-advanced-component')).toBeNull('advanced search component');

    // click btn to display advanced search form
    html.querySelector('{{ $gen->slugEntityName() }}-search-basic-component form button.advanced-search-btn').click();

    fixture.detectChanges();
    tick(500);

    expect(html.querySelector('{{ $gen->slugEntityName() }}-search-advanced-component')).not.toBeNull('advanced search component');
  }));

  it('should navigate on create btn click', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    spyOn(router, 'navigateByUrl');
    fixture.nativeElement.querySelector('a.btn i.glyphicon-plus').click();

    fixture.detectChanges();

    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/{{ $gen->slugEntityName() }}/create'),
      { skipLocationChange: false, replaceUrl: false }
    );
  }));

  it('should show advanced search form on btn click', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    expect(component.showAdvancedSearchForm).toBe(false);
    expect(fixture.nativeElement.querySelector('{{ $gen->slugEntityName() }}-search-advanced-component')).toBeNull('advanced search component');

    fixture.nativeElement.querySelector('{{ $gen->slugEntityName() }}-search-basic-component form button.advanced-search-btn').click();

    fixture.detectChanges();
    tick(500);

    expect(component.showAdvancedSearchForm).toBe(true);
    expect(fixture.nativeElement.querySelector('{{ $gen->slugEntityName() }}-search-advanced-component')).not.toBeNull('advanced search component');
  }));
});
