import { Injectable } from '@angular/core';
import { Actions, Effect } from '@ngrx/effects';
import { Action, Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import { of } from 'rxjs/observable/of';
import { go } from '@ngrx/router-store';
import { empty } from 'rxjs/observable/empty';
import 'rxjs/add/operator/withLatestFrom';

import * as fromRoot from './../../reducers';
import * as appMsgActions from './../../core/actions/app-message.actions';
import * as book from './../actions/book.actions';
import * as reason from './../../library/actions/reason.actions';
import * as user from './../../library/actions/user.actions';
import { Book } from './../models/book';
import { BookPagination } from './../models/bookPagination';
import { AppMessage } from './../../core/models/appMessage';
import { FormModelParserService } from './../../dynamic-form/services/form-model-parser.service';
import { BookService } from './../services/book.service';

import { Effects } from './../../core/effects/abstract.effects';

/**
 * BookEffects Class.
 *
 * @author  [name] <[<email address>]>
 */
@Injectable()
export class BookEffects extends Effects {
  /**
   * BookEffects contructor.
   */
  public constructor(
    private actions$: Actions,
    private bookService: BookService,
    private FormModelParserService: FormModelParserService,
    private store: Store<fromRoot.State>
  ) { super(); }

  protected setMessages(message: AppMessage): Action {
    return new book.SetMessagesAction(message);
  }

  @Effect()
  getFormModel$: Observable<Action> = this.actions$
    .ofType(book.GET_FORM_MODEL)
    .withLatestFrom(this.store.select(fromRoot.getBookState))
    .switchMap(([action, state]) => {
      // prevent API call if we have the form model already
      if (state.bookFormModel !== null) {
        return of(new book.GetFormModelSuccessAction(state.bookFormModel));
      }

      return this.bookService.getFormModel()
        .map((data) => this.FormModelParserService.parse(data, this.bookService.fieldsLangKey))
        .map((data) => { return new book.GetFormModelSuccessAction(data)})
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  getFormData$: Observable<Action> = this.actions$
    .ofType(book.GET_FORM_DATA)
    .map((action: Action) => action.payload)
    .mergeMap((force: boolean) => {
      return [
        new reason.ListAction(force),
        new user.ListAction(force),
      ];
    });

  @Effect()
  setSearchQuery$: Observable<Action> = this.actions$
    .ofType(book.SET_SEARCH_QUERY)
    .map((action: Action) => action.payload)
    .map((searchQuery) => new book.PaginateAction());

  @Effect()
  paginate$: Observable<Action> = this.actions$
    .ofType(book.PAGINATE)
    .withLatestFrom(this.store.select(fromRoot.getBookState))
    .switchMap(([action, state]) => {
      return this.bookService.paginate(state.searchQuery)
        .map((data: BookPagination) => { return new book.PaginateSuccessAction(data)})
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  list$: Observable<Action> = this.actions$
    .ofType(book.LIST)
    .withLatestFrom(this.store.select(fromRoot.getBookState))
    .switchMap(([action, state]) => {
      // data already exists and force == false?
      if (state.list && !action.payload) {
        return empty();
      }

      return this.bookService.list()
        .map((data) => { return new book.ListSuccessAction(data)})
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  create$: Observable<Action> = this.actions$
    .ofType(book.CREATE)
    .map((action: Action) => action.payload)
    .switchMap((payload: { item: Book, redirect: boolean}) => {
      let actions: Array<Action> = [];

      return this.bookService.create(payload.item)
        .mergeMap((createdItem: Book) => {
          actions.push(
            new book.SetSelectedAction(createdItem),
            new book.SetMessagesAction(this.bookService.getMessage('create_success'))
          );

          if (payload.redirect === true) {
            actions.push(go(['book', createdItem.id, 'details']));
          }

          return actions;
        })
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  getById$: Observable<Action> = this.actions$
    .ofType(book.GET_BY_ID)
    .withLatestFrom(this.store.select(fromRoot.getBookState))
    .switchMap(([action, state]) => {
      // prevent API call if we have the selected item object in the store already
      if (state.selectedBook && action.payload == state.selectedBook.id) {
        return of(new book.SetSelectedAction(state.selectedBook));
      }

      return this.bookService.getById(action.payload)
        .mergeMap((item: Book) => {
          return [
            new book.SetSelectedAction(item),
          ];
        })
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  setSelectedItem$: Observable<Action> = this.actions$
    .ofType(book.SET_SELECTED)
    .map((action: Action) => action.payload)
    .switchMap((item: Book) => {
      // if the selected item is trashed, then flash a msg to notify the user
      if(item && item.deleted_at) {
        let msg = this.bookService.getMessage('item_trashed', 'warning');
        return of(new book.SetMessagesAction(msg));
      }

      return empty();
    });

  @Effect()
  update$: Observable<Action> = this.actions$
    .ofType(book.UPDATE)
    .map((action: Action) => action.payload)
    .switchMap((payload: { id: string | number, item: Book, redirect: boolean}) => {
      let actions: Array<Action> = [];

      return this.bookService.update(payload.id, payload.item)
        .mergeMap((updatedItem: Book) => {
          actions.push(
            new book.SetSelectedAction(updatedItem),
            new book.SetMessagesAction(this.bookService.getMessage('update_success'))
          );

          // make redirection to details page if desired
          if (payload.redirect === true) {
            actions.push(go(['book', updatedItem.id, 'details']));
          }

          return actions;
        })
        .catch((error: AppMessage) => this.handleError(error));
    });

  @Effect()
  delete$: Observable<Action> = this.actions$
    .ofType(book.DELETE)
    .map((action: Action) => action.payload)
    .switchMap(action => {
      return this.bookService.delete(action.id)
        .mergeMap(() => {
          let actions = [
            new book.SetMessagesAction(this.bookService.getMessage('delete_success')),
            go(['book'])
          ];

          if(action.reloadListQuery) {
            actions.push(new book.PaginateAction(action.reloadListQuery));
          }

          return actions;
        })
        .catch((error: AppMessage) => this.handleError(error));
    });
}
