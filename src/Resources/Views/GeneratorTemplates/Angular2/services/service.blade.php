import { Injectable } from '@angular/core';
import { Http } from '@angular/http';
import { Observable } from 'rxjs/Observable';
import 'rxjs/add/operator/catch';

import { Service } from './../../core/abstracts/service';
import { LocalStorageService } from './../../core/services/localStorage';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';

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
  public load(): Observable<{{ $entitySin }}[]> {
    console.log('trying to fetch paginated books!!');

    return this.http
      .get(this.apiEndpoint(), {headers: this.headers})
      .map(res => {console.log(res.json().data); return res.json().data as {{ $entitySin }}[]})
      .catch(this.handleError);
  }

}