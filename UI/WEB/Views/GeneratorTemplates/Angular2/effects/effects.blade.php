import { Injectable } from '@angular/core';
import { Actions, Effect } from '@ngrx/effects';
import { Action, Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { go } from '@ngrx/router-store';
import { empty } from 'rxjs/observable/empty';
import 'rxjs/add/operator/withLatestFrom';

import * as fromRoot from './../../reducers';
import * as {{ $actions = camel_case($crud->entityName()) }} from './../actions/{{ $crud->slugEntityName() }}.actions';
@foreach ($fields->unique('namespace') as $field)
@if($field->namespace)
import * as {{ camel_case(class_basename($field->namespace)) }} from './../../{{ $crud->ngSlugModuleFromNamespace($field->namespace) }}/actions/{{ str_slug(snake_case(class_basename($field->namespace))) }}.actions';
@endif
@endforeach
import { {{ $entitySin = $crud->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { {{ ($entitySin = $crud->entityName()).'Pagination' }} } from './../models/{{ $camelEntity = camel_case($entitySin) }}Pagination';
import { AppMessage } from './../../core/models/appMessage';
import { FormModelParserService } from './../../dynamic-form/services/form-model-parser.service';
import { {{ $entitySin }}Service } from './../services/{{ $crud->slugEntityName() }}.service';

import { Effects } from './../../core/effects/abstract.effects';

/**
 * {{ $entitySin }}Effects Class.
 *
 * @author [name] <[<email address>]>
 */
@Injectable()
export class {{ $entitySin }}Effects extends Effects {

  @Effect()
  getFormModel$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.GET_FORM_MODEL)
    .withLatestFrom(this.store.select(fromRoot.get{{ $crud->entityName() }}State))
    .switchMap(([action, state]) => {
      // prevent API call if we have the form model already
      if (state.formModel !== null) {
        return of(new {{ $actions }}.GetFormModelSuccessAction(state.formModel));
      }

      return this.{{ $service = camel_case($entitySin).'Service' }}.getFormModel()
        .map((data) => this.FormModelParserService.parse(data, this.{{ $service }}.fieldsLangKey))
        .map((data) => { return new {{ $actions }}.GetFormModelSuccessAction(data)})
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  getFormData$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.GET_FORM_DATA)
    .map((action: Action) => action.payload)
    .mergeMap((force: boolean) => {
      return [
@foreach ($fields->unique('namespace') as $field)
@if($field->namespace)
        new {{ camel_case(class_basename($field->namespace)) }}.ListAction(force),
@endif
@endforeach
      ];
    });

  @Effect()
  setSearchQuery$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.SET_SEARCH_QUERY)
    .map((action: Action) => action.payload)
    .map((searchQuery) => new {{ $actions }}.PaginateAction());

  @Effect()
  paginate$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.PAGINATE)
    .withLatestFrom(this.store.select(fromRoot.get{{ $crud->entityName() }}State))
    .switchMap(([action, state]) => {
      return this.{{ $service }}.paginate(state.searchQuery)
        .map((data: {{ $entitySin.'Pagination' }}) => { return new {{ $actions }}.PaginateSuccessAction(data)})
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  list$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.LIST)
    .withLatestFrom(this.store.select(fromRoot.get{{ $crud->entityName() }}State))
    .switchMap(([action, state]) => {
      // data already exists and force == false?
      if (state.list && !action.payload) {
        return empty();
      }

      return this.{{ $service }}.list()
        .map((data) => { return new {{ $actions }}.ListSuccessAction(data)})
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  create$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.CREATE)
    .map((action: Action) => action.payload)
    .switchMap((payload: { item: {{ $entitySin }}, redirect: boolean}) => {
      let actions: Array<Action> = [];

      return this.{{ $service }}.create(payload.item)
        .mergeMap((createdItem: {{ $entitySin }}) => {
          actions.push(
            // this will refresh the list if anybody needs it later
            new {{ $actions }}.ListSuccessAction(null),
            new {{ $actions }}.SetSelectedAction(createdItem),
            new {{ $actions }}.SetMessagesAction(this.{{ $service }}.getMessage('create_success'))
          );

          if (payload.redirect === true) {
            actions.push(go(['{{ $crud->slugEntityName() }}', createdItem.id, 'details']));
          }

          return actions;
        })
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  getById$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.GET_BY_ID)
    .withLatestFrom(this.store.select(fromRoot.get{{ $crud->entityName() }}State))
    .switchMap(([action, state]) => {
      // prevent API call if we have the selected item object in the store already
      if (state.selected && action.payload == state.selected.id) {
        return of(new {{ $actions }}.SetSelectedAction(state.selected));
      }

      return this.{{ $service }}.getById(action.payload)
        .mergeMap((item: {{ $entitySin }}) => {
          return [
            new {{ $actions }}.SetSelectedAction(item),
          ];
        })
        .catch((error: AppMessage) => this.handleError(error));
    });

@if ($crud->hasSoftDeleteColumn)
  @Effect()
  setSelectedItem$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.SET_SELECTED)
    .map((action: Action) => action.payload)
    .switchMap((item: {{ $entitySin }}) => {
      // if the selected item is trashed, then flash a msg to notify the user
      if(item && item.deleted_at) {
        let msg = this.{{ $service }}.getMessage('item_trashed', 'warning');
        return of(new {{ $actions }}.SetMessagesAction(msg));
      }

      return empty();
    });
@endif

  @Effect()
  update$: Observable<Action> = this.actions$
    .ofType({{ $actions }}.UPDATE)
    .map((action: Action) => action.payload)
    .switchMap((payload: { id: string | number, item: {{ $entitySin }}, redirect: boolean}) => {
      let actions: Array<Action> = [];

      return this.{{ $service }}.update(payload.id, payload.item)
        .mergeMap((updatedItem: {{ $entitySin }}) => {
          actions.push(
            // this will refresh the list if anybody needs it later
            new {{ $actions }}.ListSuccessAction(null),
            new {{ $actions }}.SetSelectedAction(updatedItem),
            new {{ $actions }}.SetMessagesAction(this.{{ $service }}.getMessage('update_success'))
          );

          // make redirection to details page if desired
          if (payload.redirect === true) {
            actions.push(go(['{{ $crud->slugEntityName() }}', updatedItem.id, 'details']));
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
            // this will refresh the list if anybody needs it later
            new {{ $actions }}.ListSuccessAction(null),
            new {{ $actions }}.SetMessagesAction(this.{{ $service }}.getMessage('delete_success')),
            go(['{{ $crud->slugEntityName() }}'])
          ];

          if(action.reloadListQuery) {
            actions.push(new {{ $actions }}.PaginateAction(action.reloadListQuery));
          }

          return actions;
        })
        .catch((error: AppMessage) => this.handleError(error));
    });

  /**
   * {{ $entitySin }}Effects contructor.
   */
  public constructor(
    private actions$: Actions,
    private {{ $service }}: {{ $entitySin }}Service,
    private FormModelParserService: FormModelParserService,
    private store: Store<fromRoot.State>
  ) { super(); }

  protected setMessages(message: AppMessage): Action {
    return new {{ $actions }}.SetMessagesAction(message);
  }

}
