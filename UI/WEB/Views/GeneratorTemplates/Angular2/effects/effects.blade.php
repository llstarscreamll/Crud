import { Injectable } from '@angular/core';
import { Actions, Effect } from '@ngrx/effects';
import { Action, Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { go } from '@ngrx/router-store';
import { empty } from 'rxjs/observable/empty';
import 'rxjs/add/operator/withLatestFrom'

import * as fromRoot from './../../reducers';
import * as appMsgActions from './../../core/actions/app-message.actions';
import { FormModelParserService } from './../../dynamic-form/services/form-model-parser.service';
import { {{ ($entitySin = $gen->entityName()).'Pagination' }} } from './../models/{{ $camelEntity = camel_case($entitySin) }}Pagination';
import { {{ $entitySin }}Service } from './../services/{{ $gen->slugEntityName() }}.service';
import * as {{ $actions = camel_case($gen->entityName()) }} from './../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { AppMessage } from './../../core/models/appMessage';
import { Effects } from './../../core/effects/abstract.effects';

/**
 * {{ $entitySin }}Effects Class.
 *
 * @author [name] <[<email address>]>
 */
@Injectable()
export class {{ $entitySin }}Effects extends Effects {
  
  /**
   * {{ $entitySin }}Effects contructor.
   */
  public constructor(
    private actions$: Actions,
    private {{ $service = camel_case($entitySin).'Service' }}: {{ $entitySin }}Service,
    private FormModelParserService: FormModelParserService,
    private store: Store<fromRoot.State>
  ) { super(); }

  protected setMessages(message: AppMessage): Action {
    return new {{ $actions }}.SetMessagesAction(message);
  }

  @Effect()
  getFormModel$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.GET_FORM_MODEL)
    .withLatestFrom(this.store.select(fromRoot.get{{ $gen->entityName() }}State))
    .switchMap(([action, state]) => {
      // prevent API call if we have the form model already
      if (state.{{ camel_case($gen->entityName()) }}FormModel !== null) {
        return of(new {{ $actions }}.GetFormModelSuccessAction(state.{{ camel_case($gen->entityName()) }}FormModel));
      }

      return this.{{ $service }}.getFormModel()
        .map((data) => this.FormModelParserService.parse(data, this.{{ $service }}.fieldsLangKey))
        .map((data) => { return new {{ $actions }}.GetFormModelSuccessAction(data)})
        .catch((error: AppMessage) => this.handleError(error));
    });

    @Effect()
    getFormData$: Observable<Action> = this.actions$
      .ofType({{ $actions }}.GET_FORM_DATA)
      .withLatestFrom(this.store.select(fromRoot.get{{ $gen->entityName() }}State))
      .switchMap(([action, state]) => {
        // prevent API call if we have the form data already
        if (state.{{ camel_case($gen->entityName()) }}FormData !== null) {
          return of(new {{ $actions }}.GetFormDataSuccessAction(state.{{ camel_case($gen->entityName()) }}FormData));
        }

        return this.{{ $service }}.getFormData()
          .map((data) => { return new {{ $actions }}.GetFormDataSuccessAction(data)})
          .catch((error: AppMessage) => this.handleError(error));
      });

  @Effect()
  setSearchQuery$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.SET_SEARCH_QUERY)
    .map((action: Action) => action.payload)
    .map((searchQuery) => new {{ $actions }}.LoadAction());

  @Effect()
  load$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.LOAD)
    .map((action: Action) => action.payload)
    .withLatestFrom(this.store.select(fromRoot.get{{ $gen->entityName() }}State))
    .switchMap(([action, state]) => {
      return this.{{ $service }}.load(state.searchQuery)
        .map((data: {{ $entitySin.'Pagination' }}) => { return new {{ $actions }}.LoadSuccessAction(data)})
        .catch((error: AppMessage) => this.handleError(error));
    });

@if ($gen->hasSoftDeleteColumn)
  @Effect()
    setSelectedItem$: Observable<Action> = this.actions$
      .ofType({{ $actions }}.SET_SELECTED)
      .map((action: Action) => action.payload)
      .switchMap((item: {{ $entitySin }}) => {
        // if the selected item is trashed, then flash a msg to notify the user
        if(item.deleted_at) {
          let msg = this.{{ $service }}.getMessage('item_trashed', 'warning');
          return of(new {{ $actions }}.SetMessagesAction(msg));
        }

        return empty();
      });
@endif

    @Effect()
    create$: Observable<Action> = this.actions$
      .ofType({{ $actions }}.CREATE)
      .map((action: Action) => action.payload)
      .switchMap((payload: { item: {{ $entitySin }}, redirect: boolean}) => {
        let actions: Array<Action> = [];

        return this.{{ $service }}.create(payload.item)
          .mergeMap((createdItem: {{ $entitySin }}) => {
            actions.push(
              new {{ $actions }}.SetSelectedAction(createdItem),
              new {{ $actions }}.SetMessagesAction(this.{{ $service }}.getMessage('create_success'))
            );

            if (payload.redirect === true) {
              actions.push(go(['{{ $gen->slugEntityName() }}', createdItem.id, 'details']));
            }

            return actions;
          })
          .catch((error: AppMessage) => this.handleError(error));
      });

    @Effect()
    getById$: Observable<Action> = this.actions$
      .ofType({{ $actions }}.GET_BY_ID)
      .withLatestFrom(this.store.select(fromRoot.get{{ $gen->entityName() }}State))
      .switchMap(([action, state]) => {
        // prevent API call if we have the selected item object in the store already
        if (state.selected{{ $gen->entityName() }} && action.payload == state.selected{{ $gen->entityName() }}.id) {
          return of(new {{ $actions }}.SetSelectedAction(state.selected{{ $gen->entityName() }}));
        }

        return this.{{ $service }}.getById(action.payload)
          .mergeMap((item: {{ $entitySin }}) => {
            return [
              new {{ $actions }}.SetSelectedAction(item),
            ];
          })
          .catch((error: AppMessage) => this.handleError(error));
      });

    @Effect()
    update$: Observable<Action> = this.actions$
      .ofType({{ $actions }}.UPDATE)
      .map((action: Action) => action.payload)
      .switchMap((payload: { id: string | number, item: {{ $entitySin }}, redirect: boolean}) => {
        let actions: Array<Action> = [];

        return this.{{ $service }}.update(payload.id, payload.item)
          .mergeMap((updatedItem: {{ $entitySin }}) => {
            actions.push(
              new {{ $actions }}.SetSelectedAction(updatedItem),
              new {{ $actions }}.SetMessagesAction(this.{{ $service }}.getMessage('update_success'))
            );

            // make redirection to details page if desired
            if (payload.redirect === true) {
              actions.push(go(['{{ $gen->slugEntityName() }}', updatedItem.id, 'details']));
            }

            return actions;
          })
          .catch((error: AppMessage) => this.handleError(error));
      });

    @Effect()
    delete$: Observable<Action> = this.actions$
      .ofType({{ $actions }}.DELETE)
      .map((action: Action) => action.payload)
      .switchMap(action => {
        return this.{{ $service }}.delete(action.id)
          .mergeMap(() => {
            let actions = [
              new {{ $actions }}.SetMessagesAction(this.{{ $service }}.getMessage('delete_success')),
              go(['{{ $gen->slugEntityName() }}'])
            ];

            if(action.reloadListQuery) {
              actions.push(new {{ $actions }}.LoadAction(action.reloadListQuery));
            }

            return actions;
          })
          .catch((error: AppMessage) => this.handleError(error));
      });
}
