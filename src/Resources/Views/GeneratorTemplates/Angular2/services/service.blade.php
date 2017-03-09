import { Injectable } from '@angular/core';
import { Http, URLSearchParams } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';
import { TranslateService } from 'ng2-translate';

import { Service } from './../../core/abstracts/service';
import { LocalStorageService } from './../../core/services/localStorage';
import { {{ ($entitySin = $gen->entityName()).'Pagination' }} } from './../models/{{ camel_case($entitySin)."Pagination" }}';
import { {{ $entitySin }} } from './../models/{{ camel_case($entitySin) }}';
import { AppMessage } from './../../core/models/appMessage';

@Injectable()
export class {{ $entitySin }}Service extends Service {
	
	protected API_ENDPOINT: string = '{{ str_slug($gen->tableName, $separator = "-") }}';
  protected langNamespace: string = '{{ strtoupper($gen->entityName()) }}';

	public constructor(
    private http: Http,
    private localStorageService: LocalStorageService,
    private translate: TranslateService,
  ) {
    super();
    this.headers.set('authorization', 'Bearer ' + this.localStorageService.getItem('token'));
  }

  /**
   * Process the load {{ $entitySin }} request to the API.
   */
  public load(data: Object = {}): Observable<{{ $entitySin.'Pagination' }}> {
    let searchParams = this.parseGetParams(data);

    return this.http
      .get(this.apiEndpoint(), { headers: this.headers, search: searchParams })
      .map(res => {return res.json()})
      .catch(this.handleError);
  }

  public create(data: Object) {
    return this.http
      .post(this.apiEndpoint('create'), data, { headers: this.headers })
      .map(res => {return res.json().data})
      .catch(this.handleError);
  }

  public get{{ $gen->entityName() }}FormModel() {
    return this.http
      .get(this.apiEndpoint('form-model/{{ $gen->slugEntityName() }}'), { headers: this.headers })
      .map(res => {return res.json()})
      .catch(this.handleError);
  }

  public get{{ $gen->entityName() }}(id) {
    let urlParams: URLSearchParams = new URLSearchParams;
    urlParams.set('include', '{{ $fields->filter(function ($field) { return !empty($field->namespace); })->transform(function($field) use ($gen) { return $gen->relationNameFromField($field); })->implode(',') }}');
    return this.http
      .get(this.apiEndpoint(id), { headers: this.headers, search: urlParams })
      .map(res => {return res.json().data})
      .catch(this.handleError);
  }

  public get{{ $gen->entityName() }}FormData() {
    return this.http
      .get(this.apiEndpoint('form-data/{{ $gen->slugEntityName() }}'), { headers: this.headers })
      .map(res => {return res.json()})
      .catch(this.handleError);
  }

  public getSuccessCreationMessage(): AppMessage {
    let msg: string;

    this.translate.get(this.langNamespace + '.msg.create_succcess').subscribe(val => msg = val);

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