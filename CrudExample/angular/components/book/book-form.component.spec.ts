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
import { AUTH_TESTING_COMPONENTS } from "app/auth/utils/auth-testing-utils";

/**
 * BookFormComponent Tests.
 *
 * @author  [name] <[<email address>]>
 */
describe('BookFormComponent', () => {
  let fixture: ComponentFixture<BookFormComponent>;
  let component: BookFormComponent;
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
      declarations: [...AUTH_TESTING_COMPONENTS, BookFormComponent],
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

    let html = fixture.nativeElement;

    expect(component.formType).toBe('create', 'form type = create');
    expect(html.querySelector('form')).toBeTruthy('create form should exists');

    expect(html.querySelector('[name=reason_id]')).toBeTruthy('reason_id field exists');
    expect(html.querySelector('[name=name]')).toBeTruthy('name field exists');
    expect(html.querySelector('[name=author]')).toBeTruthy('author field exists');
    expect(html.querySelector('[name=genre]')).toBeTruthy('genre field exists');
    expect(html.querySelector('[name=stars]')).toBeTruthy('stars field exists');
    expect(html.querySelector('[name=published_year]')).toBeTruthy('published_year field exists');
    expect(html.querySelector('[name=enabled]')).toBeTruthy('enabled field exists');
    expect(html.querySelector('[name=status]')).toBeTruthy('status field exists');
    expect(html.querySelector('[name=unlocking_word]')).toBeTruthy('unlocking_word field exists');
    expect(html.querySelector('[name=synopsis]')).toBeTruthy('synopsis field exists');
    expect(html.querySelector('[name=approved_at]')).toBeTruthy('approved_at field exists');
    expect(html.querySelector('[name=approved_by]')).toBeTruthy('approved_by field exists');
    expect(html.querySelector('[name=approved_password]')).toBeTruthy('approved_password field exists');
  
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

    expect(html.querySelector('[name=id]:disabled')).toBeTruthy('id field exists');
    expect(html.querySelector('[name=reason_id]')).toBeTruthy('reason_id field exists');
    expect(html.querySelector('[name=name]:disabled')).toBeTruthy('name field exists');
    expect(html.querySelector('[name=author]:disabled')).toBeTruthy('author field exists');
    expect(html.querySelector('[name=genre]:disabled')).toBeTruthy('genre field exists');
    expect(html.querySelector('[name=stars]:disabled')).toBeTruthy('stars field exists');
    expect(html.querySelector('[name=published_year]:disabled')).toBeTruthy('published_year field exists');
    expect(html.querySelector('[name=enabled]:disabled')).toBeTruthy('enabled field exists');
    expect(html.querySelector('[name=status]')).toBeTruthy('status field exists');
    expect(html.querySelector('[name=synopsis]:disabled')).toBeTruthy('synopsis field exists');
    expect(html.querySelector('[name=approved_at]:disabled')).toBeTruthy('approved_at field exists');
    expect(html.querySelector('[name=approved_by]')).toBeTruthy('approved_by field exists');
    expect(html.querySelector('[name=created_at]:disabled')).toBeTruthy('created_at field exists');
    expect(html.querySelector('[name=updated_at]:disabled')).toBeTruthy('updated_at field exists');
    expect(html.querySelector('[name=deleted_at]:disabled')).toBeTruthy('deleted_at field exists');
  
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

    expect(html.querySelector('[name=reason_id]')).toBeTruthy('reason_id field exists');
    expect(html.querySelector('[name=reason_id]').getAttribute('value')).toContain(testModel.reason_id, 'reason_id field value');

    expect(html.querySelector('[name=name]')).toBeTruthy('name field exists');
    expect(html.querySelector('[name=name]').value).toBe(testModel.name, 'name field value');

    expect(html.querySelector('[name=author]')).toBeTruthy('author field exists');
    expect(html.querySelector('[name=author]').value).toBe(testModel.author, 'author field value');

    expect(html.querySelector('[name=genre]')).toBeTruthy('genre field exists');
    expect(html.querySelector('[name=genre]').value).toBe(testModel.genre, 'genre field value');

    expect(html.querySelector('[name=stars]')).toBeTruthy('stars field exists');
    expect(html.querySelector('[name=stars]').value).toContain(testModel.stars, 'stars field value');

    expect(html.querySelector('[name=published_year]')).toBeTruthy('published_year field exists');
    expect(html.querySelector('[name=published_year]').value).toBe(testModel.published_year, 'published_year field value');

    expect(html.querySelector('[name=enabled]')).toBeTruthy('enabled field exists');
    expect(html.querySelector('[name=enabled]').value).toBe(testModel.enabled, 'enabled field value');

    expect(html.querySelector('[name=status]')).toBeTruthy('status field exists');
    expect(html.querySelector('[name=status]:checked').value).toBe(testModel.status, 'status field value');

    expect(html.querySelector('[name=synopsis]')).toBeTruthy('synopsis field exists');
    expect(html.querySelector('[name=synopsis]').value).toBe(testModel.synopsis, 'synopsis field value');

    expect(html.querySelector('[name=approved_at]')).toBeTruthy('approved_at field exists');
    expect(html.querySelector('[name=approved_at]').value).toBe(testModel.approved_at, 'approved_at field value');

    expect(html.querySelector('[name=approved_by]')).toBeTruthy('approved_by field exists');
    expect(html.querySelector('[name=approved_by]').getAttribute('value')).toContain(testModel.approved_by, 'approved_by field value');

    
    // form links/buttons
    expect(html.querySelector('form button.btn.edit-row')).toBeTruthy('edit form btn exists');
    expect(html.querySelector('form button.btn.delete-row')).toBeTruthy('delete form btn exists');
    expect(html.querySelector('form a.btn.show-all-rows')).toBeTruthy('show all form link exists');
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
      jasmine.stringMatching('/book'),
      { skipLocationChange: false, replaceUrl: false }
    );
  }));
});
