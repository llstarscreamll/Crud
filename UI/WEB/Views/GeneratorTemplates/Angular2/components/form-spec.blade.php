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

import { {{ $cmpClass = $crud->componentClass('form', $plural = false) }} } from './{{ str_replace('.ts', '', $crud->componentFile('form', false)) }}';
import { {{ $crud->getLanguageKey(true) }} } from './../../translations/{{ $crud->getLanguageKey() }}';
import { {{ $service = $crud->entityName().'Service' }} } from './../../services/{{ $crud->slugEntityName() }}.service';
import { {{ $model = $crud->entityName() }} } from './../../models/{{ camel_case($crud->entityName()) }}';
import * as utils from './../../utils/{{ $crud->slugEntityName() }}-testing.util';
import { AUTH_TESTING_COMPONENTS } from "app/auth/utils/auth-testing-utils";

/**
 * {{ $crud->componentClass('form', $plural = false) }} Tests.
 *
 * @author [name] <[<email address>]>
 */
describe('{{ $cmpClass }}', () => {
  let fixture: ComponentFixture<{{ $cmpClass }}>;
  let component: {{ $cmpClass }};
  let formModel;
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

  // setup language translations
  beforeEach(inject([TranslateService], (translateService: TranslateService) => {
    translateService.setTranslation('es', ES, true);
    translateService.setDefaultLang('es');
    translateService.use('es');
  }));

  it('should create', () => {
    fixture.detectChanges();
    expect(component).toBeTruthy();
  });

  it('should have certain elements on create form', fakeAsync(() => {
    component.formType = 'create';

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();

    let html = fixture.nativeElement;

    expect(component.formType).toBe('create', 'form type = create');
    expect(html.querySelector('form')).toBeTruthy('create form should exists');

@foreach ($fields as $field)
@if ($field->on_create_form)
    expect(html.querySelector('[name={{ $field->name }}]')).toBeTruthy('{{ $field->name }} field exists');
@endif
@endforeach
  
    // form links/buttons
    expect(html.querySelector('form button.btn.create-row')).toBeTruthy('create form btn should exists');
    expect(html.querySelector('form a.btn.show-all-rows')).toBeTruthy('show all form link should exists');
  }));

  it('should have certain elements on details form', fakeAsync(() => {
    component.formType = 'details';

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();

    let html = fixture.nativeElement;

    expect(component.formType).toBe('details', 'form type = details');
    expect(html.querySelector('form')).toBeTruthy('details form should exists');

@foreach ($fields as $field)
@if (!$field->hidden)
    expect(html.querySelector('[name={{ $field->name }}]{{ $field->key == 'MUL' || $field->type == 'enum' ? null : ':disabled' }}')).toBeTruthy('{{ $field->name }} field exists');
@endif
@endforeach
  
    // form links/buttons
    expect(html.querySelector('form button.btn.edit-row')).toBeTruthy('edit form btn exists');
    expect(html.querySelector('form button.btn.delete-row')).toBeTruthy('delete form btn exists');
    expect(html.querySelector('form a.btn.show-all-rows')).toBeTruthy('show all form link exists');
  }));

  it('should have certain elements on edit form', fakeAsync(() => {
    component.formType = 'edit';

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();

    let html = fixture.nativeElement;
    
    expect(component.formType).toBe('edit', 'form type = edit');
    expect(html.querySelector('form')).toBeTruthy('edit form exists');

@foreach ($fields as $field)
@if (!$field->hidden && $field->on_update_form)
    expect(html.querySelector('[name={{ $field->name }}]')).toBeTruthy('{{ $field->name }} field exists');
    expect(html.querySelector('[name={{ $field->name }}]{{ $field->type == 'enum' ? ':checked' : null }}').{!! $field->key == 'MUL' ? "getAttribute('value')" : 'value' !!}).to{{ in_array($field->type, ['double', 'int', 'float', 'bigint']) ? 'Contain' : 'Be' }}(testModel.{{ $field->name }}, '{{ $field->name }} field value');

@endif
@endforeach    
    // form links/buttons
    expect(html.querySelector('form button.btn.edit-row')).toBeTruthy('edit form btn exists');
    expect(html.querySelector('form button.btn.delete-row')).toBeTruthy('delete form btn exists');
    expect(html.querySelector('form a.btn.show-all-rows')).toBeTruthy('show all form link exists');
  }));

  it('should make certains {{ $crud->entityName() }}Service calls on create form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));
    component.formType = 'create';

    fixture.detectChanges();
    tick();

    // should make form model/data api service calls
    expect(service.getFormModel).toHaveBeenCalled();
  }));

  it('should make certains {{ $crud->entityName() }}Service calls on details form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getById').and.returnValue(Observable.from([{}]));
    component.formType = 'details';

    fixture.detectChanges();
    tick();

    // should make form model/data/item api service calls
    expect(service.getFormModel).toHaveBeenCalled();
    expect(service.getById).toHaveBeenCalled();
  }));

  it('should make certains {{ $crud->entityName() }}Service calls on edit form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getById').and.returnValue(Observable.from([{}]));
    component.formType = 'edit';

    fixture.detectChanges();
    tick();

    // should make form model/data/item api service calls
    expect(service.getFormModel).toHaveBeenCalled();
    expect(service.getById).toHaveBeenCalled();
  }));

  it('should make api call when create form submitted', fakeAsync(() => {
    spyOn(service, 'create').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getMessage');
    component.formType = 'create';

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();
    
    expect(component.form.valid).toBe(false, 'for is invalid');
    expect(fixture.nativeElement.querySelector('form button.create-row').disabled).toBe(true);
    component.form.patchValue(testModel);

    fixture.detectChanges();

    expect(component.form.valid).toBe(true, 'form is now valid');
    fixture.nativeElement.querySelector('form button.create-row').click();

    fixture.detectChanges();
    tick();

    // should make create post api call
    expect(service.create).toHaveBeenCalled();
    expect(service.getMessage).toHaveBeenCalledWith('create_success');
  }));

  it('should make update api call when edit form submitted', fakeAsync(() => {
    spyOn(service, 'update').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getMessage');
    component.formType = 'edit';

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();
    
    expect(component.form.valid).toBe(true, 'form is valid');
    fixture.nativeElement.querySelector('form button.edit-row').click();

    fixture.detectChanges();
    tick();

    // should make edit post api call
    expect(service.update).toHaveBeenCalled();
    expect(service.getMessage).toHaveBeenCalledWith('update_success');
  }));

  it('should make delete api call when delete btn clicked', fakeAsync(() => {
    spyOn(service, 'delete').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getMessage');
    component.formType = 'details';

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();
    
    expect(component.form.valid).toBe(true, 'form is valid');
    fixture.nativeElement.querySelector('form button.delete-row').click();

    fixture.detectChanges();

    // should open sweetalert2 for confirmation
    fixture.nativeElement.querySelector('button.swal2-confirm').click();

    fixture.detectChanges();
    tick(200);

    // should make delete api call on service
    expect(service.delete).toHaveBeenCalled();
    expect(service.getMessage).toHaveBeenCalledWith('delete_success');
  }));

  it('should navigate when show all btn clicked', fakeAsync(() => {
    component.formType = 'details';

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();

    spyOn(router, 'navigateByUrl');
    fixture.nativeElement.querySelector('a.btn.show-all-rows').click();

    fixture.detectChanges();

    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/{{ $crud->slugEntityName() }}'),
      { skipLocationChange: false, replaceUrl: false }
    );
  }));
});
