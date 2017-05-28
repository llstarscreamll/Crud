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

import { BookFormComponent } from './book-form.component';
import { ES } from './../../translations/es';
import { BookService } from './../../services/book.service';
import { Book } from './../../models/book';
import * as utils from './../../utils/book-testing.util';

/**
 * BookFormComponent Tests.
 *
 * @author  [name] <[<email address>]>
 */
describe('BookFormComponent', () => {
  let fixture: ComponentFixture<BookFormComponent>;
  let component: BookFormComponent
  let formModel;
  let testModel: Book = utils.BookOne;
  let reactiveForm;
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let service: BookService;
  let http: Http;
  let router: Router;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [BookFormComponent],
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
    service = getTestBed().get(BookService);

    mockBackend = getTestBed().get(MockBackend);
    utils.setupMockBackend(mockBackend);
    
    fixture = getTestBed().createComponent(BookFormComponent);
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

    expect(component.formType).toBe('create');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('create form should exists');

    expect(fixture.nativeElement.querySelector('[name=reason_id]')).not.toBeNull('reason_id field');
    expect(fixture.nativeElement.querySelector('[name=name]')).not.toBeNull('name field');
    expect(fixture.nativeElement.querySelector('[name=author]')).not.toBeNull('author field');
    expect(fixture.nativeElement.querySelector('[name=genre]')).not.toBeNull('genre field');
    expect(fixture.nativeElement.querySelector('[name=stars]')).not.toBeNull('stars field');
    expect(fixture.nativeElement.querySelector('[name=published_year]')).not.toBeNull('published_year field');
    expect(fixture.nativeElement.querySelector('[name=enabled]')).not.toBeNull('enabled field');
    expect(fixture.nativeElement.querySelector('[name=status]')).not.toBeNull('status field');
    expect(fixture.nativeElement.querySelector('[name=unlocking_word]')).not.toBeNull('unlocking_word field');
    expect(fixture.nativeElement.querySelector('[name=synopsis]')).not.toBeNull('synopsis field');
    expect(fixture.nativeElement.querySelector('[name=approved_at]')).not.toBeNull('approved_at field');
    expect(fixture.nativeElement.querySelector('[name=approved_by]')).not.toBeNull('approved_by field');
    expect(fixture.nativeElement.querySelector('[name=approved_password]')).not.toBeNull('approved_password field');
  
    // form links/buttons
    expect(fixture.nativeElement.querySelector('form button.btn.create-row')).not.toBeNull('create form btn should exists');
    expect(fixture.nativeElement.querySelector('form a.btn.show-all-rows')).not.toBeNull('show all form link should exists');
  }));

  it('should have certain elements on details form', fakeAsync(() => {
    component.formType = 'details';

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();

    expect(component.formType).toBe('details');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('details form should exists');

    expect(fixture.nativeElement.querySelector('[name=id]:disabled')).not.toBeNull('id field');
    expect(fixture.nativeElement.querySelector('[name=reason_id]')).not.toBeNull('reason_id field');
    expect(fixture.nativeElement.querySelector('[name=name]:disabled')).not.toBeNull('name field');
    expect(fixture.nativeElement.querySelector('[name=author]:disabled')).not.toBeNull('author field');
    expect(fixture.nativeElement.querySelector('[name=genre]:disabled')).not.toBeNull('genre field');
    expect(fixture.nativeElement.querySelector('[name=stars]:disabled')).not.toBeNull('stars field');
    expect(fixture.nativeElement.querySelector('[name=published_year]:disabled')).not.toBeNull('published_year field');
    expect(fixture.nativeElement.querySelector('[name=enabled]:disabled')).not.toBeNull('enabled field');
    expect(fixture.nativeElement.querySelector('[name=status]')).not.toBeNull('status field');
    expect(fixture.nativeElement.querySelector('[name=synopsis]:disabled')).not.toBeNull('synopsis field');
    expect(fixture.nativeElement.querySelector('[name=approved_at]:disabled')).not.toBeNull('approved_at field');
    expect(fixture.nativeElement.querySelector('[name=approved_by]')).not.toBeNull('approved_by field');
    expect(fixture.nativeElement.querySelector('[name=created_at]:disabled')).not.toBeNull('created_at field');
    expect(fixture.nativeElement.querySelector('[name=updated_at]:disabled')).not.toBeNull('updated_at field');
    expect(fixture.nativeElement.querySelector('[name=deleted_at]:disabled')).not.toBeNull('deleted_at field');
  
    // form links/buttons
    expect(fixture.nativeElement.querySelector('form button.btn.edit-row')).not.toBeNull('edit form btn should exists');
    expect(fixture.nativeElement.querySelector('form button.btn.delete-row')).not.toBeNull('delete form btn should exists');
    expect(fixture.nativeElement.querySelector('form a.btn.show-all-rows')).not.toBeNull('show all form link should exists');
  }));

  it('should have certain elements on edit form', fakeAsync(() => {
    component.formType = 'edit';

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();
    
    expect(component.formType).toBe('edit');
    expect(fixture.nativeElement.querySelector('form')).not.toBeNull('edit form should exists');

    expect(fixture.nativeElement.querySelector('[name=reason_id]')).not.toBeNull('reason_id field should exists');
    expect(fixture.nativeElement.querySelector('[name=reason_id]').getAttribute('value')).toContain(testModel.reason_id ? testModel.reason_id : '', 'reason_id field value');
    expect(fixture.nativeElement.querySelector('[name=name]')).not.toBeNull('name field should exists');
    expect(fixture.nativeElement.querySelector('[name=name]').value).toBe(testModel.name ? testModel.name : '', 'name field value');
    expect(fixture.nativeElement.querySelector('[name=author]')).not.toBeNull('author field should exists');
    expect(fixture.nativeElement.querySelector('[name=author]').value).toBe(testModel.author ? testModel.author : '', 'author field value');
    expect(fixture.nativeElement.querySelector('[name=genre]')).not.toBeNull('genre field should exists');
    expect(fixture.nativeElement.querySelector('[name=genre]').value).toBe(testModel.genre ? testModel.genre : '', 'genre field value');
    expect(fixture.nativeElement.querySelector('[name=stars]')).not.toBeNull('stars field should exists');
    expect(fixture.nativeElement.querySelector('[name=stars]').value).toContain(testModel.stars ? testModel.stars : '', 'stars field value');
    expect(fixture.nativeElement.querySelector('[name=published_year]')).not.toBeNull('published_year field should exists');
    expect(fixture.nativeElement.querySelector('[name=published_year]').value).toBe(testModel.published_year ? testModel.published_year : '', 'published_year field value');
    expect(fixture.nativeElement.querySelector('[name=enabled]')).not.toBeNull('enabled field should exists');
    expect(fixture.nativeElement.querySelector('[name=enabled]').value).toBe(testModel.enabled ? testModel.enabled : '', 'enabled field value');
    expect(fixture.nativeElement.querySelector('[name=status]')).not.toBeNull('status field should exists');
    expect(fixture.nativeElement.querySelector('[name=status]').getAttribute('value')).toBe(testModel.status ? testModel.status : '', 'status field value');
    expect(fixture.nativeElement.querySelector('[name=synopsis]')).not.toBeNull('synopsis field should exists');
    expect(fixture.nativeElement.querySelector('[name=synopsis]').value).toBe(testModel.synopsis ? testModel.synopsis : '', 'synopsis field value');
    expect(fixture.nativeElement.querySelector('[name=approved_at]')).not.toBeNull('approved_at field should exists');
    expect(fixture.nativeElement.querySelector('[name=approved_at]').value).toBe(testModel.approved_at ? testModel.approved_at : '', 'approved_at field value');
    expect(fixture.nativeElement.querySelector('[name=approved_by]')).not.toBeNull('approved_by field should exists');
    expect(fixture.nativeElement.querySelector('[name=approved_by]').getAttribute('value')).toContain(testModel.approved_by ? testModel.approved_by : '', 'approved_by field value');
    
    // form links/buttons
    expect(fixture.nativeElement.querySelector('form button.btn.edit-row')).not.toBeNull('edit form btn should exists');
    expect(fixture.nativeElement.querySelector('form button.btn.delete-row')).not.toBeNull('delete form btn should exists');
    expect(fixture.nativeElement.querySelector('form a.btn.show-all-rows')).not.toBeNull('show all form link should exists');
  }));

  it('should make certains BookService calls on create form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));
    component.formType = 'create';

    fixture.detectChanges();
    tick();

    // should make form model/data api service calls
    expect(service.getFormModel).toHaveBeenCalled();
  }));

  it('should make certains BookService calls on details form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getById').and.returnValue(Observable.from([{}]));
    component.formType = 'details';

    fixture.detectChanges();
    tick();

    // should make form model/data/item api service calls
    expect(service.getFormModel).toHaveBeenCalled();
    expect(service.getById).toHaveBeenCalled();
  }));

  it('should make certains BookService calls on edit form init', fakeAsync(() => {
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
    
    expect(component.form.valid).toBe(true);
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
    
    expect(component.form.valid).toBe(true);
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
      jasmine.stringMatching('/book'),
      { skipLocationChange: false, replaceUrl: false }
    );
  }));
});
