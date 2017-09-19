import { Action } from '@ngrx/store';
import { {{ $entitySin = $crud->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { {{ $entitySin.'Pagination' }} } from './../models/{{ camel_case($entitySin)."Pagination" }}';
import { AppMessage } from './../../core/models/appMessage';

/**
 * {{ $crud->entityName() }} Actions.
 *
 * @author [name] <[<email address>]>
 */
export const GET_FORM_MODEL = '[{{ $entitySin }}] Get Form Model';
export const GET_FORM_MODEL_SUCCESS = '[{{ $entitySin }}] Get Form Model Success';
export const GET_FORM_DATA = '[{{ $entitySin }}] Get Form Data';
export const SET_SEARCH_QUERY = '[{{ $entitySin }}] Set Search Query';
export const PAGINATE = '[{{ $entitySin }}] Paginate';
export const PAGINATE_SUCCESS = '[{{ $entitySin }}] Paginate Success';
export const LIST = '[{{ $entitySin }}] List';
export const LIST_SUCCESS = '[{{ $entitySin }}] List Success';
export const CREATE = '[{{ $entitySin }}] Create';
export const GET_BY_ID = '[{{ $entitySin }}] Get';
export const UPDATE = '[{{ $entitySin }}] Update';
export const DELETE = '[{{ $entitySin }}] Delete';
export const RESTORE = '[{{ $entitySin }}] Restore';
export const SET_SELECTED = '[{{ $entitySin }}] Set Selected';
export const SET_MESSAGES = '[{{ $entitySin }}] Set Messages';

export class GetFormModelAction implements Action {
  readonly type = GET_FORM_MODEL;
  public constructor(public payload: null = null) { }
}

export class GetFormModelSuccessAction implements Action {
  readonly type = GET_FORM_MODEL_SUCCESS;
  public constructor(public payload: any[]) { }
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
  public constructor(public payload: {{ $entitySin.'Pagination' }} ) { }
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
  public constructor(public payload: { item: {{ $entitySin }}, redirect: boolean }) { }
}

export class UpdateAction implements Action {
  readonly type = UPDATE;
  public constructor(public payload: { id: string | number, item: {{ $entitySin }}, redirect: boolean }) { }
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
  public constructor(public payload: {{ $entitySin }} = null) { }
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
