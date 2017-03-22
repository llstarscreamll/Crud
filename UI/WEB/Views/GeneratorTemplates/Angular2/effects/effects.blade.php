import { Injectable } from '@angular/core';
import { Actions, Effect } from '@ngrx/effects';
import { Action } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { go } from '@ngrx/router-store';

import { FormModelParser } from './../../core/services/formModelParser';
import * as appMsgActions from './../../core/actions/appMessage';
import { {{ ($entitySin = $gen->entityName()).'Pagination' }} } from './../models/{{ $camelEntity = camel_case($entitySin) }}Pagination';
import { {{ $entitySin }}Service } from './../services/{{ $gen->slugEntityName() }}.service';
import * as {{ $actions = camel_case($gen->entityName()) }} from './../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';

@Injectable()
export class {{ $entitySin }}Effects {

	public constructor(
    private actions$: Actions,
    private {{ $service = camel_case($entitySin).'Service' }}: {{ $entitySin }}Service,
    private formModelParser: FormModelParser
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
        });
    });

  @Effect() get{{ $camelEntity }}FormModel$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.GET_{{ $gen->entityNameSnakeCase() }}_FORM_MODEL)
    .switchMap(() => {
      return this.{{ $service }}.get{{ $gen->entityName() }}FormModel()
        .map((data) => this.formModelParser.parse(data, this.{{ $service }}.fieldsLangNamespace))
        .map((data) => { return new {{ $actions }}.GetFormModelSuccessAction(data)})
        .catch((error) => {
          error.type = 'danger';
          return of(new appMsgActions.Flash(error))
        });
    });

    @Effect() get{{ $camelEntity }}FormData$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.GET_{{ $gen->entityNameSnakeCase() }}_FORM_DATA)
    .switchMap(() => {
      return this.{{ $service }}.get{{ $gen->entityName() }}FormData()
        .map((data) => { return new {{ $actions }}.GetFormDataSuccessAction(data)})
        .catch((error) => {
          error.type = 'danger';
          return of(new appMsgActions.Flash(error))
        });
    });

    @Effect() getAction$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.GET_{{ $gen->entityNameSnakeCase() }})
    .map((action: Action) => action.payload)
    .switchMap((id) => {
      return this.{{ $service }}.get{{ $gen->entityName() }}(id)
        .map((data: {{ $entitySin }}) => { return new {{ $actions }}.GetSuccessAction(data)})
        .catch((error) => {
          error.type = 'danger';
          return of(new appMsgActions.Flash(error))
        });
    });

    @Effect() createAction$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.CREATE_{{ $gen->entityNameSnakeCase() }})
    .map((action: Action) => action.payload)
    .switchMap((data) => {
      return this.{{ $service }}.create(data)
        .map((data: {{ $entitySin }}) => { return new {{ $actions }}.CreateSuccessAction(data)})
        .catch((error) => {
          error.type = 'danger';
          return of(new appMsgActions.Flash(error))
        });
    });

    @Effect() createSuccessAction$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.CREATE_{{ $gen->entityNameSnakeCase() }}_SUCCESS)
    .map((action: Action) => action.payload)
    .mergeMap((data: {{ $entitySin }}) => {
      return [
        new appMsgActions.Flash(this.{{ $service }}.getSuccessMessage('create')),
        go(['{{ $gen->slugEntityName() }}', data.id, 'details'])
      ];
    });

    @Effect() updateAction$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.UPDATE_{{ $gen->entityNameSnakeCase() }})
    .map((action: Action) => action.payload)
    .switchMap((data: {{ $entitySin }}) => {
      return this.{{ $service }}.update(data)
        .map((data: {{ $entitySin }}) => { return new {{ $actions }}.UpdateSuccessAction(data)})
        .catch((error) => {
          error.type = 'danger';
          return of(new appMsgActions.Flash(error))
        });
    });

    @Effect() updateSuccessAction$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.UPDATE_{{ $gen->entityNameSnakeCase() }}_SUCCESS)
    .map((action: Action) => action.payload)
    .mergeMap((data: {{ $entitySin }}) => {
      return [
        new appMsgActions.Flash(this.{{ $service }}.getSuccessMessage('update')),
        go(['{{ $gen->slugEntityName() }}', data.id, 'details'])
      ];
    });

    @Effect() deleteAction$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.DELETE_{{ $gen->entityNameSnakeCase() }})
    .map((action: Action) => action.payload)
    .switchMap(id => {
      return this.{{ $service }}.delete(id)
        .map(() => { return new {{ $actions }}.DeleteSuccessAction()})
        .catch((error) => {
          error.type = 'danger';
          return of(new appMsgActions.Flash(error))
        });
    });

    @Effect() deleteSuccessAction$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.ActionTypes.DELETE_{{ $gen->entityNameSnakeCase() }}_SUCCESS)
    .mergeMap(() => {
      return [
        new appMsgActions.Flash(this.{{ $service }}.getSuccessMessage('delete')),
        go(['{{ $gen->slugEntityName() }}'])
      ];
    });
}
