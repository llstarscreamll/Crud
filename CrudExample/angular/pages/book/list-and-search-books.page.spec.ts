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

import * as utils from './../../utils/book-testing.util';
import { Book } from './../../models/book';
import { ES } from './../../translations/es';
import { ListAndSearchBooksPage } from './list-and-search-books.page';
import { BookComponents } from './../../components/book';
import { BookPages } from './../../pages/book';
import { BookService } from './../../services/book.service';

/**
 * ListAndSearchBooksPage Tests.
 *
 * @author  [name] <[<email address>]>
 */
describe('ListAndSearchBooksPage', () => {
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let fixture: ComponentFixture<ListAndSearchBooksPage>;
  let component: ListAndSearchBooksPage;
  let router: Router;
  let location: Location;
  let service: BookService;
  let http: Http;
  let testModel: Book = utils.BookOne;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [
        ...BookComponents,
        ...BookPages,
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
    service = getTestBed().get(BookService);

    mockBackend = getTestBed().get(MockBackend);
    utils.setupMockBackend(mockBackend);
    
    fixture = getTestBed().createComponent(ListAndSearchBooksPage);
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

    expect(html.querySelector('book-search-basic-component')).not.toBeNull('basic search component');
    expect(html.querySelector('books-table-component')).not.toBeNull('table list component');
    expect(html.querySelector('book-search-advanced-component')).toBeNull('advanced search component');

    // click btn to display advanced search form
    html.querySelector('book-search-basic-component form button.advanced-search-btn').click();

    fixture.detectChanges();
    tick(500);

    expect(html.querySelector('book-search-advanced-component')).not.toBeNull('advanced search component');
  }));

  it('should navigate on create btn click', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    spyOn(router, 'navigateByUrl');
    fixture.nativeElement.querySelector('a.btn i.glyphicon-plus').click();

    fixture.detectChanges();

    expect(router.navigateByUrl).toHaveBeenCalledWith(
      jasmine.stringMatching('/book/create'),
      { skipLocationChange: false, replaceUrl: false }
    );
  }));

  it('should show advanced search form on btn click', fakeAsync(() => {
    spyOn(service, 'paginate').and.returnValue(Observable.from([{data: [], pagination: {}}])); // empty data

    fixture.detectChanges();
    tick();

    expect(component.showAdvancedSearchForm).toBe(false);
    expect(fixture.nativeElement.querySelector('book-search-advanced-component')).toBeNull('advanced search component');

    fixture.nativeElement.querySelector('book-search-basic-component form button.advanced-search-btn').click();

    fixture.detectChanges();
    tick(500);

    expect(component.showAdvancedSearchForm).toBe(true);
    expect(fixture.nativeElement.querySelector('book-search-advanced-component')).not.toBeNull('advanced search component');
  }));
});
