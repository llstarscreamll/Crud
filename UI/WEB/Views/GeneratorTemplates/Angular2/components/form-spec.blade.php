/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, inject, getTestBed, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { Observable } from 'rxjs/Observable';
import { Store } from '@ngrx/store';
import { Router, ActivatedRoute } from '@angular/router';
import { Location } from '@angular/common';

import * as fromRoot from './../../../reducers';
import { AuthGuard } from './../../../auth/guards/auth.guard';
import { DynamicFormModule } from './../../../dynamic-form/dynamic-form.module';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';

import { {{ $cmpClass = $gen->componentClass('form', $plural = false) }} } from './{{ str_replace('.ts', '', $gen->componentFile('form', false)) }}';
import { {{ $gen->getLanguageKey(true) }} } from './../../translations/{{ $gen->getLanguageKey() }}';
import { {{ $service = $gen->entityName().'Service' }} } from './../../services/{{ $gen->slugEntityName() }}.service';
import { {{ $model = $gen->entityName() }} } from './../../models/{{ camel_case($gen->entityName()) }}';
import * as utils from './../../utils/{{ $gen->slugEntityName() }}-testing.util';

/**
 * {{ $gen->componentClass('form', $plural = false) }} Tests.
 *
 * @author [name] <[<email address>]>
 */
describe('{{ $cmpClass }}', () => {
  let fixture: ComponentFixture<{{ $cmpClass }}>;
  let component: {{ $cmpClass }}
  let formModel;
  let testModel: {{ $gen->entityName() }} = utils.{{ $gen->entityName() }}One;
  let reactiveForm;
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let authGuard: AuthGuard;
  let service: {{ $gen->entityName() }}Service;
  let http: Http;
  let router: Router;
  let location: Location;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [{{ $cmpClass }}],
      imports: [
        utils.IMPORTS
      ],
      providers: [
        utils.PROVIDERS
      ]
    }).compileComponents();

    store = getTestBed().get(Store);
    router = getTestBed().get(Router);
    location = getTestBed().get(Location);
    authGuard = getTestBed().get(AuthGuard);
    http = getTestBed().get(Http);
    service = getTestBed().get({{ $gen->entityName() }}Service);

    spyOn(authGuard, 'canActivate').and.returnValue(true);

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
    spyOn(service, 'getFormData').and.returnValue(Observable.from([{}]));
    component.formType = 'create';

    fixture.detectChanges();
    tick();

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

  it('should have certain elements on details form', fakeAsync(() => {
    spyOn(service, 'getFormData').and.returnValue(Observable.from([{}]));
    component.formType = 'details';

    fixture.detectChanges();
    tick();

    expect(component.formType).toBe('details');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('details form should exists');

@foreach ($fields as $field)
@if (!$field->hidden)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]{{ $field->key == 'MUL' || $field->type == 'enum' ? null : ':disabled' }}')).not.toBeNull('{{ $field->name }} field');
@endif
@endforeach
  
    // form links/buttons
    expect(fixture.nativeElement.querySelector('form button.btn.edit-row')).not.toBeNull('edit form btn should exists');
    expect(fixture.nativeElement.querySelector('form button.btn.delete-row')).not.toBeNull('delete form btn should exists');
    expect(fixture.nativeElement.querySelector('form a.btn.show-all-rows')).not.toBeNull('show all form link should exists');
  }));

  it('should have certain elements on edit form', fakeAsync(() => {
    spyOn(service, 'getFormData').and.returnValue(Observable.from([{}]));
    component.formType = 'edit';

    fixture.detectChanges();
    tick();
    
    expect(component.formType).toBe('edit');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('edit form should exists');

@foreach ($fields as $field)
@if (!$field->hidden && $field->on_update_form)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]')).not.toBeNull('{{ $field->name }} field should exists');
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]').{!! $field->key == 'MUL' || $field->type == 'enum' ? "getAttribute('value')" : 'value' !!}).to{{ in_array($field->type, ['double', 'int', 'float', 'bigint']) ? 'Contain' : 'Be' }}(testModel.{{ $field->name }} ? testModel.{{ $field->name }} : '', '{{ $field->name }} field value');
@endif
@endforeach
    
    // form links/buttons
    expect(fixture.nativeElement.querySelector('form button.btn.edit-row')).not.toBeNull('edit form btn should exists');
    expect(fixture.nativeElement.querySelector('form button.btn.delete-row')).not.toBeNull('delete form btn should exists');
    expect(fixture.nativeElement.querySelector('form a.btn.show-all-rows')).not.toBeNull('show all form link should exists');
  }));

  it('should make certains {{ $gen->entityName() }}Service calls on create form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getFormData').and.returnValue(Observable.from([{}]));
    component.formType = 'create';

    fixture.detectChanges();
    tick();

    // should make form model/data api service calls
    expect(service.getFormModel).toHaveBeenCalled();
    expect(service.getFormData).toHaveBeenCalled();
  }));

  it('should make certains {{ $gen->entityName() }}Service calls on details form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getFormData').and.returnValue(Observable.from([{}]));
    spyOn(service, 'get').and.returnValue(Observable.from([{}]));
    component.formType = 'details';

    fixture.detectChanges();
    tick();

    // should make form model/data/item api service calls
    expect(service.getFormModel).toHaveBeenCalled();
    expect(service.getFormData).toHaveBeenCalled();
    expect(service.get).toHaveBeenCalled();
  }));

  it('should make certains {{ $gen->entityName() }}Service calls on edit form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getFormData').and.returnValue(Observable.from([{}]));
    spyOn(service, 'get').and.returnValue(Observable.from([{}]));
    component.formType = 'edit';

    fixture.detectChanges();
    tick();

    // should make form model/data/item api service calls
    expect(service.getFormModel).toHaveBeenCalled();
    expect(service.getFormData).toHaveBeenCalled();
    expect(service.get).toHaveBeenCalled();
  }));

  it('should make api call when create form submitted', fakeAsync(() => {
    spyOn(service, 'getFormData').and.returnValue(Observable.from([{}]));
    spyOn(service, 'create').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getMessage');
    component.formType = 'create';

    fixture.detectChanges();
    tick();
    
    expect(component.form.valid).toBe(false);
    expect(fixture.nativeElement.querySelector('form button.create-row').disabled).toBe(true);
    component.form.patchValue(testModel);

    fixture.detectChanges();

    expect(component.form.valid).toBe(true);
    fixture.nativeElement.querySelector('form button.create-row').click();

    fixture.detectChanges();
    tick();

    // should make create post api call
    expect(service.create).toHaveBeenCalled();
    expect(service.getMessage).toHaveBeenCalledWith('create_success');
  }));
});
