/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, getTestBed, inject, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { Store, StoreModule } from '@ngrx/store';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';

import { CoreModule } from './../../../core/core.module';
import * as fromRoot from './../../../reducers';

import * as utils from './../../utils/{{ $gen->slugEntityName() }}-testing.util';
import { {{ $gen->getLanguageKey(true) }} } from './../../translations/{{ $gen->getLanguageKey() }}';
import { {{ $cpmClass = $gen->containerClass('form', false, true) }} } from './{{ str_replace('.ts', '', $gen->containerFile('form', false, true)) }}';
import { {{ $module = $gen->studlyModuleName().'Module' }} } from './../../{{ $gen->slugModuleName(false) }}.module';

describe('{{ $cpmClass }}', () => {
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let fixture: ComponentFixture<{{ $cpmClass }}>;
  let component: {{ $cpmClass }};

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      imports: [
        RouterTestingModule,
        HttpModule,
        StoreModule.provideStore(fromRoot.reducer),
        TranslateModule.forRoot(),
        CoreModule,
        {{ $module }},
      ],
      providers: [
        MockBackend,
        BaseRequestOptions,
        {
          provide: Http,
          useFactory: (backend, defaultOptions) => new Http(backend, defaultOptions),
          deps: [MockBackend, BaseRequestOptions]
        },
      ]
    }).compileComponents();

    fixture = getTestBed().createComponent({{ $cpmClass }});
    component = fixture.componentInstance;
    store = getTestBed().get(Store);
    mockBackend = getTestBed().get(MockBackend);
    utils.setupMockBackend(mockBackend);
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
});
