/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, getTestBed, inject, tick } from '@angular/core/testing';
import { Location } from '@angular/common';
import { Router, ActivatedRoute } from '@angular/router';
import { Store, StoreModule } from '@ngrx/store';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { Observable } from 'rxjs/Observable';

import * as fromRoot from './../../../reducers';

import * as utils from './../../utils/book-testing.util';
import { Book } from './../../models/book';
import { ES } from './../../translations/es';
import { BookFormPage } from './book-form.page';
import { BookComponents } from './../../components/book';
import { BookPages } from './../../pages/book';
import { BookService } from './../../services/book.service';
import { AUTH_TESTING_COMPONENTS } from "app/auth/utils/auth-testing-utils";

/**
 * BookFormPage Tests.
 *
 * @author  [name] <[<email address>]>
 */
describe('BookFormPage', () => {
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let fixture: ComponentFixture<BookFormPage>;
  let component: BookFormPage;
  let router: Router;
  let location: Location;
  let service: BookService;
  let testModel: Book = utils.BookOne;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [
        ...AUTH_TESTING_COMPONENTS,
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
    service = getTestBed().get(BookService);

    mockBackend = getTestBed().get(MockBackend);
    utils.setupMockBackend(mockBackend);
    
    fixture = getTestBed().createComponent(BookFormPage);
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

  it('should have certain elements', () => {
    fixture.detectChanges();
    let html = fixture.nativeElement;

    // should have sidebar-layout
    expect(html.querySelector('app-sidebar-layout')).not.toBeNull();

    // should have page header
    expect(html.querySelector('app-page-header')).not.toBeNull();

    // should have page content
    expect(html.querySelector('app-page-content')).not.toBeNull();

    // should have box where the form is located
    expect(html.querySelector('app-box app-box-body')).not.toBeNull();

    // should have form component inside app-box-body
    expect(html.querySelector('app-box-body book-form-component')).not.toBeNull();
  });

  it('should have default form type = create', () => {
    fixture.detectChanges();
    expect(component.formType).toBe('create');
  });

  it('should set form type = create based on current url', () => {
    spyOn(location, 'path').and.returnValue('book/create');
    fixture.detectChanges();

    expect(component.formType).toBe('create');
  });

  it('should set form type = details based on current url', () => {
    spyOn(location, 'path').and.returnValue('book/a1/details');
    fixture.detectChanges();

    expect(component.formType).toBe('details');
  });

  it('should set form type = edit based on current url', () => {
    spyOn(location, 'path').and.returnValue('book/a1/edit');
    fixture.detectChanges();

    expect(component.formType).toBe('edit');
  });
});
