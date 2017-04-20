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
import { AuthGuard } from './../../../auth/guards/auth.guard';

import * as utils from './../../utils/{{ $gen->slugEntityName() }}-testing.util';
import { {{ $model = $gen->entityName() }} } from './../../models/{{ camel_case($gen->entityName()) }}';
import { {{ $gen->getLanguageKey(true) }} } from './../../translations/{{ $gen->getLanguageKey() }}';
import { {{ $cpmClass = $gen->containerClass('form', false, true) }} } from './{{ str_replace('.ts', '', $gen->containerFile('form', false, true)) }}';
import { {{ $components = $gen->entityName().'Components' }} } from './../../components/{{ $gen->slugEntityName().'' }}';
import { {{ $containers = $gen->entityName().'Containers' }} } from './../../containers/{{ $gen->slugEntityName().'' }}';
import { {{ $service = $gen->entityName().'Service' }} } from './../../services/{{ $gen->slugEntityName() }}.service';

describe('{{ $cpmClass }}', () => {
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let fixture: ComponentFixture<{{ $cpmClass }}>;
  let component: {{ $cpmClass }};
  let router: Router;
  let location: Location;
  let authGuard: AuthGuard;
  let service: {{ $service }};
  let http: Http;
  let testModel: {{ $gen->entityName() }} = utils.{{ $gen->entityName() }}One;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [
        ...{{ $components }},
        ...{{ $containers }},
      ],
      imports: [
        ...utils.CONTAINERS_IMPORTS,
      ],
      providers: [
        ...utils.CONTAINERS_PROVIDERS,
      ]
    }).compileComponents();

    store = getTestBed().get(Store);
    router = getTestBed().get(Router);
    location = getTestBed().get(Location);
    authGuard = getTestBed().get(AuthGuard);
    http = getTestBed().get(Http);
    service = getTestBed().get({{ $service }});

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

  it('should have certain setup for create form', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/create');

    fixture.detectChanges();
    tick();

    expect(fixture.nativeElement.querySelector('h1')).not.toBeNull('should have h1 heading');
    expect(fixture.nativeElement.querySelector('h1').textContent).toContain('{{ $gen->request->get('plural_entity_name') }}');
    expect(fixture.nativeElement.querySelector('h1 small')).not.toBeNull('should have small heading');
    expect(fixture.nativeElement.querySelector('h1 small').textContent).toContain('{{ trans('crud::templates.create') }}');
    
    expect(component.formType).toBe('create');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('create form should exists');

@foreach ($fields as $field)
@if ($field->on_create_form)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]')).not.toBeNull('{{ $field->name }} field');
@endif
@endforeach

    // form links/buttons
    expect(fixture.nativeElement.querySelector('form button.btn.create-row')).not.toBeNull('create form btn should exists');
    expect(fixture.nativeElement.querySelector('form a.btn.show-all-rows')).not.toBeNull('show all form link should exists');
  }));

  it('should have certain setup for details form', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/' + testModel.id + '/details');

    fixture.detectChanges();
    tick();

    expect(fixture.nativeElement.querySelector('h1')).not.toBeNull('should have h1 heading');
    expect(fixture.nativeElement.querySelector('h1').textContent).toContain('{{ $gen->request->get('plural_entity_name') }}');
    expect(fixture.nativeElement.querySelector('h1 small')).not.toBeNull('should have small heading');
    expect(fixture.nativeElement.querySelector('h1 small').textContent).toContain('{{ trans('crud::templates.details') }}');
    
    expect(component.formType).toBe('details');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('details form should exists');

@foreach ($fields as $field)
@if (!$field->hidden)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]:disabled')).not.toBeNull('{{ $field->name }} field should exists');
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]:disabled').value).toBe(testModel.{{ $field->name }} ? testModel.{{ $field->name }} : '', '{{ $field->name }} field value');
@endif
@endforeach

    // form links/buttons
    expect(fixture.nativeElement.querySelector('form button.btn.edit-row')).not.toBeNull('edit form btn should exists');
    expect(fixture.nativeElement.querySelector('form button.btn.delete-row')).not.toBeNull('delete form btn should exists');
    expect(fixture.nativeElement.querySelector('form a.btn.show-all-rows')).not.toBeNull('show all form link should exists');
  }));

  it('should have certain setup for edit form', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/' + testModel.id + '/edit');

    fixture.detectChanges();
    tick();

    expect(fixture.nativeElement.querySelector('h1')).not.toBeNull('should have h1 heading');
    expect(fixture.nativeElement.querySelector('h1').textContent).toContain('{{ $gen->request->get('plural_entity_name') }}');
    expect(fixture.nativeElement.querySelector('h1 small')).not.toBeNull('should have small heading');
    expect(fixture.nativeElement.querySelector('h1 small').textContent).toContain('{{ trans('crud::templates.edit') }}');
    
    expect(component.formType).toBe('edit');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('edit form should exists');

@foreach ($fields as $field)
@if (!$field->hidden && $field->on_update_form)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]')).not.toBeNull('{{ $field->name }} field should exists');
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]').value).toBe(testModel.{{ $field->name }} ? testModel.{{ $field->name }} : '', '{{ $field->name }} field value');
@endif
@endforeach
    
    // form links/buttons
    expect(fixture.nativeElement.querySelector('form button.btn.edit-row')).not.toBeNull('edit form btn should exists');
    expect(fixture.nativeElement.querySelector('form button.btn.delete-row')).not.toBeNull('delete form btn should exists');
    expect(fixture.nativeElement.querySelector('form a.btn.show-all-rows')).not.toBeNull('show all form link should exists');
  }));

  it('should make certains {{ $gen->entityName() }}Service calls on create form init', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/create');
    spyOn(service, 'get{{ $gen->entityName() }}FormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'get{{ $gen->entityName() }}FormData').and.returnValue(Observable.from([{}]));

    fixture.detectChanges();
    tick();

    // should make form model/data api service calls
    expect(service.get{{ $gen->entityName() }}FormModel).toHaveBeenCalled();
    expect(service.get{{ $gen->entityName() }}FormData).toHaveBeenCalled();
  }));

  it('should make certains {{ $gen->entityName() }}Service calls on details form init', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/' + testModel.id + '/details');
    spyOn(service, 'get{{ $gen->entityName() }}FormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'get{{ $gen->entityName() }}FormData').and.returnValue(Observable.from([{}]));
    spyOn(service, 'get{{ $gen->entityName() }}').and.returnValue(Observable.from([{}]));

    fixture.detectChanges();
    tick();

    // should make form model/data/row api service calls
    expect(service.get{{ $gen->entityName() }}FormModel).toHaveBeenCalled();
    expect(service.get{{ $gen->entityName() }}FormData).toHaveBeenCalled();
    expect(service.get{{ $gen->entityName() }}FormData).toHaveBeenCalled();
  }));

  it('should make certains {{ $gen->entityName() }}Service calls on edit form init', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/' + testModel.id + '/edit');
    spyOn(service, 'get{{ $gen->entityName() }}FormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'get{{ $gen->entityName() }}FormData').and.returnValue(Observable.from([{}]));
    spyOn(service, 'get{{ $gen->entityName() }}').and.returnValue(Observable.from([{}]));

    fixture.detectChanges();
    tick();

    // should make form model/data/row api service calls
    expect(service.get{{ $gen->entityName() }}FormModel).toHaveBeenCalled();
    expect(service.get{{ $gen->entityName() }}FormData).toHaveBeenCalled();
    expect(service.get{{ $gen->entityName() }}FormData).toHaveBeenCalled();
  }));

  it('should make create api call when create form submitted', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/create');
    spyOn(service, 'create').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getSuccessMessage');

    fixture.detectChanges();
    tick();
    
    expect(component.{{ $form = camel_case($gen->entityName()).'Form' }}.valid).toBe(false);
    component.{{ $form }}.patchValue(testModel);

    fixture.detectChanges();

    expect(component.{{ $form }}.valid).toBe(true);
    fixture.nativeElement.querySelector('form button.create-row').click();

    fixture.detectChanges();
    tick();

    // should make create post api call
    expect(service.create).toHaveBeenCalled();
    expect(service.getSuccessMessage).toHaveBeenCalledWith('create');
  }));

  it('should make update api call when edit form submitted', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/' + testModel.id + '/edit');
    spyOn(service, 'update').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getSuccessMessage');

    fixture.detectChanges();
    tick();
    
    expect(component.{{ $form }}.valid).toBe(true);
    fixture.nativeElement.querySelector('form button.edit-row').click();

    fixture.detectChanges();
    tick();

    // should make edit post api call
    expect(service.update).toHaveBeenCalled();
    expect(service.getSuccessMessage).toHaveBeenCalledWith('update');
  }));

  it('should make delete api call when delete btn clicked', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/' + testModel.id + '/edit');
    spyOn(service, 'delete').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getSuccessMessage');

    fixture.detectChanges();
    tick();
    
    expect(component.{{ $form }}.valid).toBe(true);
    fixture.nativeElement.querySelector('form button.delete-row').click();

    fixture.detectChanges();

    // should open sweetalert2 for confirmation
    fixture.nativeElement.querySelector('button.swal2-confirm').click();

    fixture.detectChanges();
    tick(200);

    // should make edit post api call
    expect(service.delete).toHaveBeenCalled();
    expect(service.getSuccessMessage).toHaveBeenCalledWith('delete');
  }));

  it('should navigate when show all btn clicked', fakeAsync(() => {
    spyOn(location, 'path').and.returnValue('/{{ $gen->slugEntityName() }}/' + testModel.id + '/edit');
    spyOn(service, 'delete').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getSuccessMessage');

    fixture.detectChanges();
    tick();

    spyOn(router, 'navigateByUrl');
    fixture.nativeElement.querySelector('a.btn.show-all-rows').click();

    fixture.detectChanges();

    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/{{ $gen->slugEntityName() }}'),
      Object({ skipLocationChange: false, replaceUrl: false })
      );
  }));
});
