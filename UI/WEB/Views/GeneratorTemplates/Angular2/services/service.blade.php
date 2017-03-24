import { Injectable } from '@angular/core';
import { Http, URLSearchParams } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
import { TranslateService } from 'ng2-translate';

import { Service } from './../../core/services/abstract.service';
import { LocalStorageService } from './../../core/services/local-storage.service';
import { {{ ($entitySin = $gen->entityName()).'Pagination' }} } from './../models/{{ camel_case($entitySin)."Pagination" }}';
import { {{ $entitySin }} } from './../models/{{ camel_case($entitySin) }}';
import { AppMessage } from './../../core/models/appMessage';

@Injectable()
export class {{ $entitySin }}Service extends Service {
	
	protected API_ENDPOINT: string = '{{ str_slug($gen->tableName, $separator = "-") }}';
  public langNamespace: string = '{{ $gen->entityNameSnakeCase() }}';
  public fieldsLangNamespace: string = '{{ $gen->entityNameSnakeCase() }}.fields.{{ $gen->tableName }}.';
  protected required_columns = [
    '{{ $gen->tableName }}.id',
    {!! $gen->hasSoftDeleteColumn ? "'".$gen->tableName.".deleted_at'," : null !!}
  ];

	public constructor(
    private http: Http,
    private localStorageService: LocalStorageService,
    private translateService: TranslateService,
  ) {
    super();
  }

  /**
   * Process the load {{ $entitySin }} request to the API.
   */
  public load(data: Object = {}): Observable<{{ $entitySin.'Pagination' }}> {
    this.setAuthorizationHeader();
    let searchParams = this.parseGetParams(data);

    return this.http
      .get(this.apiEndpoint(), { headers: this.headers, search: searchParams })
      .map(res => { return { data: res.json().data, pagination: res.json().meta.pagination } })
      .catch(this.handleError);
  }

  public create(data: Object) {
    this.setAuthorizationHeader();

    return this.http
      .post(this.apiEndpoint('create'), data, { headers: this.headers })
      .map(res => { return res.json().data })
      .catch(this.handleError);
  }

  public get{{ $gen->entityName() }}FormModel() {
    this.setAuthorizationHeader();

    return this.http
      .get(this.apiEndpoint('form-model/{{ $gen->slugEntityName() }}'), { headers: this.headers })
      .map(res => {return res.json()})
      .catch(this.handleError);
  }

  public get{{ $gen->entityName() }}FormData() {
    this.setAuthorizationHeader();

    return this.http
      .get(this.apiEndpoint('form-data/{{ $gen->slugEntityName() }}'), { headers: this.headers })
      .map(res => { return res.json() })
      .catch(this.handleError);
  }

  public get{{ $gen->entityName() }}(id) {
    this.setAuthorizationHeader();

    let urlParams: URLSearchParams = new URLSearchParams;
    urlParams.set('include', '{{ $fields->filter(function ($field) { return !empty($field->namespace); })->transform(function($field) use ($gen) { return $gen->relationNameFromField($field); })->implode(',') }}');
    return this.http
      .get(this.apiEndpoint(id), { headers: this.headers, search: urlParams })
      .map(res => { return res.json().data })
      .catch(this.handleError);
  }

  public update(data: {{ $entitySin }}) {
    this.setAuthorizationHeader();

    return this.http
      .put(this.apiEndpoint(data.id), data, { headers: this.headers })
      .map(res => { return res.json().data })
      .catch(this.handleError);
  }

  public delete(id: string) {
    this.setAuthorizationHeader();
    
    return this.http
      .delete(this.apiEndpoint(id), { headers: this.headers })
      .map(res => { return res.json().data })
      .catch(this.handleError);
  }

  public getSuccessMessage(type: string = 'create'): AppMessage {
    let msg: string;

    this.translateService.get(this.langNamespace + '.msg.'+type+'_succcess').subscribe(val => msg = val);

    let appMessage: AppMessage = {
      message: msg,
      date: new Date(),
      errors: {},
      type: 'success',
      status_code: 200
    };

    return appMessage;
  }
}