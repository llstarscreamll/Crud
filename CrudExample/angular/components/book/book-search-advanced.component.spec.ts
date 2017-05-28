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

import { BookSearchAdvancedComponent } from './book-search-advanced.component';
import { ES } from './../../translations/es';
import { BookService } from './../../services/book.service';
import { Book } from './../../models/book';
import * as utils from './../../utils/book-testing.util';

/**
 * BookSearchAdvancedComponent Tests.
 *
 * @author  [name] <[<email address>]>
 */
describe('BookSearchAdvancedComponent', () => {
  let fixture: ComponentFixture<BookSearchAdvancedComponent>;
  let component: BookSearchAdvancedComponent;
  let testModel: Book = utils.BookOne;
  let reactiveForm;
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let service: BookService;
  let http: Http;
  let router: Router;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [BookSearchAdvancedComponent],
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

    fixture = getTestBed().createComponent(BookSearchAdvancedComponent);
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

  it('should have certain elements', fakeAsync(() => {
    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();

    let html = fixture.nativeElement;

    // should have app-alerts element
    expect(html.querySelector('app-alerts')).not.toBeNull();

    // should have search columns/options
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.id"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.reason_id"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.name"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.author"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.genre"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.stars"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.published_year"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.enabled"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.status"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.synopsis"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.approved_at"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.approved_by"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.created_at"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.updated_at"]')).not.toBeNull();
    expect(html.querySelector('tabset tab:first-child [name=filter][value="books.deleted_at"]')).not.toBeNull();


    // should have search fields
    expect(html.querySelector('tabset tab:nth-child(2) [name=id]')).not.toBeNull('id field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=reason_id]')).not.toBeNull('reason_id field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=name]')).not.toBeNull('name field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=author]')).not.toBeNull('author field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=genre]')).not.toBeNull('genre field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=stars]')).not.toBeNull('stars field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=published_year]')).not.toBeNull('published_year field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=enabled]')).not.toBeNull('enabled field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=status]')).not.toBeNull('status field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=unlocking_word]')).not.toBeNull('unlocking_word field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=synopsis]')).not.toBeNull('synopsis field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=approved_at_from]')).not.toBeNull('approved_at_from field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=approved_at_to]')).not.toBeNull('approved_at_to field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=approved_by]')).not.toBeNull('approved_by field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=approved_password]')).not.toBeNull('approved_password field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=created_at_from]')).not.toBeNull('created_at_from field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=created_at_to]')).not.toBeNull('created_at_to field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=updated_at_from]')).not.toBeNull('updated_at_from field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=updated_at_to]')).not.toBeNull('updated_at_to field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=deleted_at_from]')).not.toBeNull('deleted_at_from field');
    expect(html.querySelector('tabset tab:nth-child(2) [name=deleted_at_to]')).not.toBeNull('deleted_at_to field');

    // should have submit btn
    expect(html.querySelector('button.btn.btn-lg.btn-block')).not.toBeNull();
  }));

  it('should make certains BookService calls on search form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));

    fixture.detectChanges();
    tick();

    // should make form model/data api service calls
    expect(service.getFormModel).toHaveBeenCalled();
  }));

  it('should make BookService paginate call on form submission', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{}]));

    fixture.detectChanges();
    tick();

    component.formDataReady = true;
    component.formData$ = Observable.from([utils.FORM_DATA]);

    fixture.detectChanges();
    tick();

    // fill input an trigger event to make reactiveForm dirty and touched
    fixture.nativeElement.querySelector('[name=id]').value = testModel.id;
    fixture.nativeElement.querySelector('[name=id]').dispatchEvent(new Event('input'));

    fixture.detectChanges();
    tick();

    // click button to submit form
    fixture.nativeElement.querySelector('form button.btn.btn-lg').click();

    fixture.detectChanges();
    tick();

    expect(component.form.get('search').get('id').value).toBe(testModel.id);
    expect(fixture.nativeElement.querySelector('[name=id]').value).toContain(testModel.id);
    expect(service.paginate).toHaveBeenCalled();
  }));
});
