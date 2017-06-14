import { Injectable } from '@angular/core';
import { Http, URLSearchParams } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
import { TranslateService } from '@ngx-translate/core';

import { AbstractService } from './../../core/services/abstract.service';
import { LocalStorageService } from './../../core/services/local-storage.service';
import { BookPagination } from './../models/bookPagination';
import { Book } from './../models/book';
import { AppMessage } from './../../core/models/appMessage';

/**
 * BookService Class.
 *
 * @author  [name] <[<email address>]>
 */
@Injectable()
export class BookService extends AbstractService {
	/**
   * API endpoint.
   * @type  string
   */
	protected API_ENDPOINT: string = 'v1/books';

  /**
   * The key to access language strings.
   * @type  string
   */
  public langKey: string = 'BOOK';

  /**
   * Langage key to access form fields translations.
   * @type  string
   */
  public fieldsLangKey: string = this.langKey + '.fields.books.';

  /**
   * The required columns to include on each API call.
   * @type  Array<string>
   */
  protected required_columns = [
    'books.id',
    'books.deleted_at',
  ];

  /**
   * BookService contructor.
   */
	public constructor(
    private http: Http,
    private localStorageService: LocalStorageService,
    private translateService: TranslateService,
  ) { super(); }

  /**
   * Get the Book form model.
   */
  public getFormModel(): Observable<Object> {
    this.setAuthorizationHeader();

    return this.http
      .get(this.apiEndpoint('form-model'), { headers: this.headers })
      .map(res => { return res.json() })
      .catch(this.handleError);
  }

  /**
   * Get the Book form data.
   */
  public getFormData(): Observable<Object> {
    this.setAuthorizationHeader();

    return this.http
      .get(this.apiEndpoint('form-data'), { headers: this.headers })
      .map(res => { return res.json() })
      .catch(this.handleError);
  }

  /**
   * List Books.
   */
  public list(): Observable<Array<any>> {
    this.setAuthorizationHeader();

    return this.http
      .get(this.apiEndpoint('form/select-list'), { headers: this.headers })
      .map(res => { return res.json(); })
      .catch(this.handleError);
  }

  /**
   * Paginate Books.
   */
  public paginate(query: Object = {}): Observable<BookPagination> {
    this.setAuthorizationHeader();
    let searchParams = this.parseGetParams(query);

    return this.http
      .get(this.apiEndpoint(), { headers: this.headers, search: searchParams })
      .map(res => {
        let response = res.json();

        return {
          data: response.data.map(item => Object.assign(new Book, item)),
          pagination: response.meta.pagination
        };
      }).catch(this.handleError);
  }

  /**
   * Create Book.
   */
  public create(item: Book): Observable<Book> {
    this.setAuthorizationHeader();

    return this.http
      .post(this.apiEndpoint('create'), item, { headers: this.headers })
      .map(res => { return Object.assign(new Book, res.json().data); })
      .catch(this.handleError);
  }

  /**
   * Get Book by id.
   */
  public getById(id: string | number): Observable<Book> {
    this.setAuthorizationHeader();

    let urlParams: URLSearchParams = new URLSearchParams;
    urlParams.set('include', 'reason,approvedBy');
    return this.http
      .get(this.apiEndpoint(id), { headers: this.headers, search: urlParams })
      .map(res => { return Object.assign(new Book, res.json().data); })
      .catch(this.handleError);
  }

  /**
   * Update Book.
   */
  public update(id: string | number, item: Book): Observable<Book> {
    this.setAuthorizationHeader();

    return this.http
      .put(this.apiEndpoint(id), item, { headers: this.headers })
      .map(res => { return Object.assign(new Book, res.json().data); })
      .catch(this.handleError);
  }

  /**
   * Delete Book by id.
   */
  public delete(id: string): Observable<any> {
    this.setAuthorizationHeader();
    
    return this.http
      .delete(this.apiEndpoint(id), { headers: this.headers })
      .map(res => { return res.json().data })
      .catch(this.handleError);
  }

  /**
   * Get translated message.
   */
  public getMessage(msgKey: string = 'create_success', type: string = 'success'): AppMessage {
    let msg: string;

    this.translateService
      .get(this.langKey + '.msg.' + msgKey)
      .subscribe(trans => msg = trans);

    let appMessage: AppMessage = {
      message: msg,
      date: new Date(),
      errors: {},
      type: type,
      status_code: 200
    };

    return appMessage;
  }
}