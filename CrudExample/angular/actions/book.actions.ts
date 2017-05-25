import { Action } from '@ngrx/store';
import { Book } from './../models/book';
import { BookPagination } from './../models/bookPagination';
import { AppMessage } from './../../core/models/appMessage';

/**
 * Book Actions.
 *
 * @author  [name] <[<email address>]>
 */
export const GET_FORM_MODEL = '[Book] Get Form Model';
export const GET_FORM_MODEL_SUCCESS = '[Book] Get Form Model Success';
export const GET_FORM_DATA = '[Book] Get Form Data';
export const SET_SEARCH_QUERY = '[Book] Set Search Query';
export const PAGINATE = '[Book] Paginate';
export const PAGINATE_SUCCESS = '[Book] Paginate Success';
export const LIST = '[Book] List';
export const LIST_SUCCESS = '[Book] List Success';
export const CREATE = '[Book] Create';
export const GET_BY_ID = '[Book] Get';
export const UPDATE = '[Book] Update';
export const DELETE = '[Book] Delete';
export const RESTORE = '[Book] Restore';
export const SET_SELECTED = '[Book] Set Selected';
export const SET_MESSAGES = '[Book] Set Messages';

export class GetFormModelAction implements Action {
  readonly type = GET_FORM_MODEL;
  public constructor(public payload: null = null) { }
}

export class GetFormModelSuccessAction implements Action {
  readonly type = GET_FORM_MODEL_SUCCESS;
  public constructor(public payload: Object) { }
}

export class GetFormDataAction implements Action {
  readonly type = GET_FORM_DATA;
  public constructor(public payload: boolean = false) { }
}

export class SetSearchQueryAction implements Action {
  readonly type = SET_SEARCH_QUERY;
  public constructor(public payload: Object = {}) { }
}

export class PaginateAction implements Action {
  readonly type = PAGINATE;
  public constructor(public payload: Object = {}) { }
}

export class PaginateSuccessAction implements Action {
  readonly type = PAGINATE_SUCCESS;
  public constructor(public payload: BookPagination ) { }
}

export class ListAction implements Action {
  readonly type = LIST;
  public constructor(public payload: boolean = false) { }
}

export class ListSuccessAction implements Action {
  readonly type = LIST_SUCCESS;
  public constructor(public payload: Array<any> ) { }
}

export class GetByIdAction implements Action {
  readonly type = GET_BY_ID;
  public constructor(public payload: string) { }
}

export class CreateAction implements Action {
  readonly type = CREATE;
  public constructor(public payload: { item: Book, redirect: boolean }) { }
}

export class UpdateAction implements Action {
  readonly type = UPDATE;
  public constructor(public payload: { id: string | number, item: Book, redirect: boolean }) { }
}

export class DeleteAction implements Action {
  readonly type = DELETE;
  public constructor(public payload: { id: string, reloadListQuery: Object | null }) { }
}

export class RestoreAction implements Action {
  readonly type = RESTORE;
  public constructor(public payload: { id: string, reloadListQuery: Object | null }) { }
}

export class SetSelectedAction implements Action {
  readonly type = SET_SELECTED;
  public constructor(public payload: Book = null) { }
}

export class SetMessagesAction implements Action {
  readonly type = SET_MESSAGES;
  public constructor(public payload: AppMessage = null) { }
}

export type Actions
  = GetFormModelAction
  | GetFormModelSuccessAction
  | GetFormDataAction
  | SetSearchQueryAction
  | ListAction
  | ListSuccessAction
  | PaginateAction
  | PaginateSuccessAction
  | CreateAction
  | GetByIdAction
  | UpdateAction
  | DeleteAction
  | RestoreAction
  | SetSelectedAction
  | SetMessagesAction;
