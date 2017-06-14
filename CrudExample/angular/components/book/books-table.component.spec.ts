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

import { BooksTableComponent } from './books-table.component';
import * as bookActions from './../../actions/book.actions';
import { ES } from './../../translations/es';
import { BookService } from './../../services/book.service';
import { Book } from './../../models/book';
import * as utils from './../../utils/book-testing.util';
import { AUTH_TESTING_COMPONENTS } from "app/auth/utils/auth-testing-utils";

/**
 * BooksTableComponent Tests.
 *
 * @author  [name] <[<email address>]>
 */
describe('BooksTableComponent', () => {
  let fixture: ComponentFixture<BooksTableComponent>;
  let component: BooksTableComponent;
  let testModel: Book = utils.BookOne;
  let reactiveForm;
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let service: BookService;
  let http: Http;
  let router: Router;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [...AUTH_TESTING_COMPONENTS, BooksTableComponent],
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

    fixture = getTestBed().createComponent(BooksTableComponent);
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

  it('should make certain BookService calls on ngOnInit', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));

    fixture.detectChanges();
    tick();

    expect(service.paginate).toHaveBeenCalled();
    expect(service.getFormModel).not.toHaveBeenCalled();
  }));

  it('should show alert msg on empty list', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    let msgElem = fixture.nativeElement.querySelector('div.alert');

    expect(msgElem).not.toBeNull();
    expect(msgElem.textContent).toContain('No records found...');
  }));

  it('should have a table', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    let table = fixture.nativeElement.querySelector('table.table-hover');

    // the table should exists
    expect(table).not.toBeNull();

    // and should have entity attributes as headings
    expect(table.querySelector('thead tr th.id'));
    expect(table.querySelector('thead tr th.reason_id'));
    expect(table.querySelector('thead tr th.name'));
    expect(table.querySelector('thead tr th.author'));
    expect(table.querySelector('thead tr th.genre'));
    expect(table.querySelector('thead tr th.stars'));
    expect(table.querySelector('thead tr th.published_year'));
    expect(table.querySelector('thead tr th.enabled'));
    expect(table.querySelector('thead tr th.status'));
    expect(table.querySelector('thead tr th.synopsis'));
    expect(table.querySelector('thead tr th.approved_at'));
    expect(table.querySelector('thead tr th.approved_by'));
    expect(table.querySelector('thead tr th.created_at'));
    expect(table.querySelector('thead tr th.updated_at'));
    expect(table.querySelector('thead tr th.deleted_at'));
    
    // should have a "actions" column
    expect(table.querySelector('thead tr th.action'));
  }));

  it('should have body table with action links/buttons', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: utils.BookList, pagination: {}}]));

    fixture.detectChanges();
    tick();

    let table = fixture.nativeElement.querySelector('table.table-hover');

    expect(table.querySelector('tbody').children.length).toEqual(2); // two rows
    expect(table.querySelector('tbody tr > td a.details-link')).not.toBeNull(); // first row details link
    expect(table.querySelector('tbody tr > td a.edit-link')).not.toBeNull(); // first row edit link
    expect(table.querySelector('tbody tr > td a.delete-link')).not.toBeNull(); // first row delete link
  }));

  it('should emit event/navigate on links click', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: utils.BookList, pagination: {}}]));
    spyOn(router, 'navigateByUrl');

    fixture.detectChanges();
    tick();

    let table = fixture.nativeElement.querySelector('table.table-hover');
    let field = 'reason_id';
    spyOn(store, 'dispatch');

    // table heading links
    table.querySelector('thead tr:first-child th.books\\.' + field + ' span').click();

    fixture.detectChanges();
    tick();
    
    expect(store.dispatch).toHaveBeenCalledWith(new bookActions.SetSearchQueryAction({
      'orderBy': 'books.' + field,
      'sortedBy': 'asc'
    }));

    // details link click
    table.querySelector('tbody tr:first-child td a.details-link').click();
    fixture.detectChanges();
    
    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/book/' + utils.BookList[0].id + '/details'),
      { skipLocationChange: false, replaceUrl: false }
    );

    // edit link click
    table.querySelector('tbody tr:first-child td a.edit-link').click();
    fixture.detectChanges();
    
    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/book/' + utils.BookList[0].id  + '/edit'),
      { skipLocationChange: false, replaceUrl: false }
    );

    // delete link click
    spyOn(component, 'deleteRow');
    table.querySelector('tbody tr:first-child td a.delete-link').click();
    fixture.detectChanges();
    
    // the component.deleteRow method has full test on BookFormComponent
    expect(component.deleteRow).toHaveBeenCalledWith(utils.BookList[0].id);
  }));
});
