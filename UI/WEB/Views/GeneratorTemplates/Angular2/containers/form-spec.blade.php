/* tslint:disable:no-unused-variable */
import { Component } from '@angular/core';
import { Location } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { Ng2BootstrapModule } from 'ngx-bootstrap';
import { async, ComponentFixture, fakeAsync, TestBed, getTestBed, inject, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Router, ActivatedRoute } from '@angular/router';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { Store, StoreModule } from '@ngrx/store';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { Observable } from 'rxjs/Observable';

import { environment } from './../../../../environments/environment';
import { CoreModule } from './../../../core/core.module';
import { DynamicFormModule } from './../../../dynamic-form/dynamic-form.module';
import * as fromRoot from './../../../reducers';
import { AuthGuard } from './../../../auth/guards/auth.guard';
import { AuthService } from './../../../auth/services/auth.service';

import * as utils from './../../utils/{{ $gen->slugEntityName() }}-testing.util';
import { {{ $model = $gen->entityName() }} } from './../../models/{{ camel_case($gen->entityName()) }}';
import { {{ $gen->getLanguageKey(true) }} } from './../../translations/{{ $gen->getLanguageKey() }}';
import { {{ $cpmClass = $gen->containerClass('form', false, true) }} } from './{{ str_replace('.ts', '', $gen->containerFile('form', false, true)) }}';
import { {{ $components = $gen->entityName().'Components' }} } from './../../components/{{ $gen->slugEntityName().'' }}';
import { {{ $containers = $gen->entityName().'Containers' }} } from './../../containers/{{ $gen->slugEntityName().'' }}';
import { {{ $routes = $gen->entityName().'Routes' }} } from './../../routes/{{ $gen->slugEntityName().'' }}.routes';
import { EFFECTS } from './../../effects/';
import { SERVICES } from './../../services';

fdescribe('{{ $cpmClass }}', () => {
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let fixture: ComponentFixture<{{ $cpmClass }}>;
  let component: {{ $cpmClass }};
  let router: Router;
  let location: Location;
  let authGuard: AuthGuard;
  let testModel: {{ $gen->entityName() }} = utils.{{ $gen->entityName() }}One;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [
        ...{{ $components }},
        ...{{ $containers }},
      ],
      imports: [
        RouterTestingModule,
        HttpModule,
        StoreModule.provideStore(fromRoot.reducer),
        ...EFFECTS,
        TranslateModule.forRoot(),
        CoreModule,
        environment.theme,
        ReactiveFormsModule,
        Ng2BootstrapModule.forRoot(),
        DynamicFormModule,
      ],
      providers: [
        MockBackend,
        BaseRequestOptions,
        AuthGuard,
        AuthService,
        {
          provide: Http,
          useFactory: (backend, defaultOptions) => new Http(backend, defaultOptions),
          deps: [MockBackend, BaseRequestOptions]
        },
        { provide: ActivatedRoute, useValue: { 'params': Observable.from([{ 'id': testModel.id }]) } },
        ...SERVICES
      ]
    }).compileComponents();

    store = getTestBed().get(Store);
    router = getTestBed().get(Router);
    location = getTestBed().get(Location);
    authGuard = getTestBed().get(AuthGuard);

    mockBackend = getTestBed().get(MockBackend);
    utils.setupMockBackend(mockBackend);
    
    fixture = getTestBed().createComponent({{ $cpmClass }});
    component = fixture.componentInstance;

    spyOn(authGuard, 'canActivate').and.returnValue(true);
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

  it('should have correct setup for create', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/create');

    fixture.detectChanges();
    tick();
    
    expect(component.formType).toBe('create');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('create form should exists');

@foreach ($fields as $field)
@if ($field->on_create_form)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]')).not.toBeNull('{{ $field->name }} field');
@endif
@endforeach
  }));

  it('should have correct setup for details', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/' + testModel.id + '/details');

    fixture.detectChanges();
    tick();
    
    expect(component.formType).toBe('details');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('details form should exists');

@foreach ($fields as $field)
@if (!$field->hidden)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]:disabled')).not.toBeNull('{{ $field->name }} field should exists');
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]:disabled').value).toBe(testModel.{{ $field->name }} ? testModel.{{ $field->name }} : '', '{{ $field->name }} field value');
@endif
@endforeach
  }));

  it('should have correct setup for edit', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/' + testModel.id + '/edit');

    fixture.detectChanges();
    tick();
    
    expect(component.formType).toBe('edit');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('edit form should exists');

@foreach ($fields as $field)
@if (!$field->hidden && $field->on_update_form)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]')).not.toBeNull('{{ $field->name }} field should exists');
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]').value).toBe(testModel.{{ $field->name }} ? testModel.{{ $field->name }} : '', '{{ $field->name }} field value');
@endif
@endforeach
  }));
});
