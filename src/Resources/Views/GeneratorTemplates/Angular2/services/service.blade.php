import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';

import { Service } from './../../core/abstracts/service';
import { LocalStorageService } from './../../core/services/localStorage';
import { {{ ($entitySin = $gen->entityName()).'Pagination' }} } from './../models/{{ camel_case($entitySin)."Pagination" }}';
import { {{ $entitySin }} } from './../models/{{ camel_case($entitySin) }}';

@Injectable()
export class {{ $entitySin }}Service extends Service {
	
	protected API_ENDPOINT: string = '{{ str_slug($gen->tableName, $separator = "-") }}';

	public constructor(
    private http: Http,
    private localStorageService: LocalStorageService
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
      .map(res => {return res.json()})
      .catch(this.handleError);
  }

  public get{{ $gen->entityName() }}FormModel() {
    return this.http
      .get(this.apiEndpoint('form-model/{{ $gen->slugEntityName() }}'), { headers: this.headers })
      .map(res => {return res.json()})
      .catch(this.handleError);
  }

  public get{{ $gen->entityName() }}FormData() {
    return this.http
      .get(this.apiEndpoint('form-data/{{ $gen->slugEntityName() }}'), { headers: this.headers })
      .map(res => {return res.json()})
      .catch(this.handleError);
  }
}