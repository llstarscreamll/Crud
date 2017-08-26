import { Injectable } from '@angular/core';
import { Http, URLSearchParams } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
import { TranslateService } from '@ngx-translate/core';

import { AbstractService } from './../../core/services/abstract.service';
import { LocalStorageService } from './../../core/services/local-storage.service';
import { {{ ($entitySin = $crud->entityName()).'Pagination' }} } from './../models/{{ camel_case($entitySin)."Pagination" }}';
import { {{ $entitySin }} } from './../models/{{ camel_case($entitySin) }}';
import { AppMessage } from './../../core/models/appMessage';

/**
 * {{ $entitySin }}Service Class.
 *
 * @author [name] <[<email address>]>
 */
@Injectable()
export class {{ $entitySin }}Service extends AbstractService {
	/**
   * API endpoint.
   * @type string
   */
	protected API_ENDPOINT: string = 'v1/{{ str_slug($crud->tableName, $separator = "-") }}';

  /**
   * The key to access language strings.
   * @type string
   */
  public langKey: string = '{{ $crud->entityNameSnakeCase() }}';

  /**
   * Langage key to access form fields translations.
   * @type string
   */
  public fieldsLangKey: string = this.langKey + '.fields.{{ $crud->tableName }}.';

  /**
   * The required columns to include on each API call.
   * @type Array<string>
   */
  protected required_columns = [
    '{{ $crud->tableName }}.id',
    {!! $crud->hasSoftDeleteColumn ? "'".$crud->tableName.".deleted_at'," : null !!}
  ];

  /**
   * {{ $entitySin }}Service contructor.
   */
	public constructor(
    private http: Http,
    private localStorageService: LocalStorageService,
    private translateService: TranslateService,
  ) { super(); }

  /**
   * Get the {{ $crud->entityName() }} form model.
   */
  public getFormModel(): Observable<any[]> {
    this.setAuthorizationHeader();

    return this.http
      .get(this.apiEndpoint('form-model'), { headers: this.headers })
      .map(res => { return res.json() })
      .catch(this.handleError);
  }

  /**
   * Get the {{ $crud->entityName() }} form data.
   */
  public getFormData(): Observable<Object> {
    this.setAuthorizationHeader();

    return this.http
      .get(this.apiEndpoint('form-data'), { headers: this.headers })
      .map(res => { return res.json() })
      .catch(this.handleError);
  }

  /**
   * List {{ $crud->entityName(true) }}.
   */
  public list(): Observable<Array<any>> {
    this.setAuthorizationHeader();

    return this.http
      .get(this.apiEndpoint('form/select-list'), { headers: this.headers })
      .map(res => { return res.json(); })
      .catch(this.handleError);
  }

  /**
   * Paginate {{ $crud->entityName(true) }}.
   */
  public paginate(query: Object = {}): Observable<{{ $entitySin.'Pagination' }}> {
    this.setAuthorizationHeader();
    let searchParams = this.parseGetParams(query);

    return this.http
      .get(this.apiEndpoint(), { headers: this.headers, search: searchParams })
      .map(res => {
        let response = res.json();

        return {
          data: response.data.map(item => Object.assign(new {{ $entitySin }}, item)),
          pagination: response.meta.pagination
        };
      }).catch(this.handleError);
  }

  /**
   * Create {{ $crud->entityName() }}.
   */
  public create(item: {{ $entitySin }}): Observable<{{ $entitySin }}> {
    this.setAuthorizationHeader();

    return this.http
      .post(this.apiEndpoint('create'), item, { headers: this.headers })
      .map(res => { return Object.assign(new {{ $entitySin }}, res.json().data); })
      .catch(this.handleError);
  }

  /**
   * Get {{ $crud->entityName() }} by id.
   */
  public getById(id: string | number): Observable<{{ $entitySin }}> {
    this.setAuthorizationHeader();

    let urlParams: URLSearchParams = new URLSearchParams;
    urlParams.set('include', '{{ $fields->filter(function ($field) { return !empty($field->namespace); })->transform(function($field) use ($crud) { return $crud->relationNameFromField($field); })->implode(',') }}');
    return this.http
      .get(this.apiEndpoint(id), { headers: this.headers, search: urlParams })
      .map(res => { return Object.assign(new {{ $entitySin }}, res.json().data); })
      .catch(this.handleError);
  }

  /**
   * Update {{ $crud->entityName() }}.
   */
  public update(id: string | number, item: {{ $entitySin }}): Observable<{{ $entitySin }}> {
    this.setAuthorizationHeader();

    return this.http
      .put(this.apiEndpoint(id), item, { headers: this.headers })
      .map(res => { return Object.assign(new {{ $entitySin }}, res.json().data); })
      .catch(this.handleError);
  }

  /**
   * Delete {{ $crud->entityName() }} by id.
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