import { Injectable } from '@angular/core';
import { Actions, Effect } from '@ngrx/effects';
import { Action } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';

import * as appMsgActions from './../../core/actions/appMessage';
import { {{ ($entitySin = $gen->entityName()).'Pagination' }} } from './../models/{{ camel_case($entitySin)."Pagination" }}';
import { {{ $entitySin }}Service } from './../services/{{ $camelEntity = camel_case($entitySin) }}.service';
import * as {{ $actions = camel_case($gen->entityName()) }} from './../actions/{{ $camelEntity }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';

@Injectable()
export class {{ $entitySin }}Effects {

	public constructor(
    private actions$: Actions,
    private {{ $service = $camelEntity.'Service' }}: {{ $entitySin }}Service,
  ) { }

  @Effect() load{{ $gen->entityName(true) }}$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.LOAD_{{ $entitySnakePlu = $gen->entityNameSnakeCase(true) }})
    .map((action: Action) => action.payload)
    .switchMap((searchData) => {
      return this.{{ $service }}.load(searchData)
        .map((data: {{ $entitySin.'Pagination' }}) => { return new {{ $actions }}.LoadSuccessAction(data)})
        .catch((error) => {
          error.type = 'danger';
          return of(new appMsgActions.Flash(error))
        })
    });

}
