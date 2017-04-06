import { Action } from '@ngrx/store';
import { type } from './../../core/util';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { {{ $entitySin.'Pagination' }} } from './../models/{{ camel_case($entitySin)."Pagination" }}';

export const ActionTypes = {
	LOAD_{{ $entitySnakePlu = $gen->entityNameSnakeCase(true) }}: type('[{{ $entitySin }}] Load'),
	LOAD_{{ $entitySnakePlu }}_SUCCESS: type('[{{ $entitySin }}] Load Success'),
	GET_{{ $entitySnakeSin = $gen->entityNameSnakeCase() }}_FORM_DATA: type('[{{ $entitySin }}] Get Form Data'),
	GET_{{ $entitySnakeSin }}_FORM_DATA_SUCCESS: type('[{{ $entitySin }}] Get Form Data Success'),
	GET_{{ $entitySnakeSin }}_FORM_MODEL: type('[{{ $entitySin }}] Get Form Model'),
	GET_{{ $entitySnakeSin }}_FORM_MODEL_SUCCESS: type('[{{ $entitySin }}] Get Form Model Success'),
	CREATE_{{ $entitySnakeSin }}: type('[{{ $entitySin }}] Create'),
	GET_{{ $entitySnakeSin}}: type('[{{ $entitySin }}] Get'),
	UPDATE_{{ $entitySnakeSin }}: type('[{{ $entitySin }}] Update'),
	DELETE_{{ $entitySnakeSin }}: type('[{{ $entitySin }}] Delete'),
	RESTORE_{{ $entitySnakeSin }}: type('[{{ $entitySin }}] Restore'),
	SET_SELECTED_{{ $entitySnakeSin }}: type('[{{ $entitySin }}] Set Selected'),
	SET_{{ $entitySnakeSin }}_ERRORS: type('[{{ $entitySin }}] Set Errors'),
}

export class LoadAction implements Action {
	type = ActionTypes.LOAD_{{ $entitySnakePlu }};
	public constructor(public payload: Object = {}) { }
}

export class LoadSuccessAction implements Action {
	type = ActionTypes.LOAD_{{ $entitySnakePlu }}_SUCCESS;
	public constructor(public payload: {{ $entitySin.'Pagination' }} ) { }
}

export class GetFormModelAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_FORM_MODEL;
	public constructor(public payload: null = null) { }
}

export class GetFormModelSuccessAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_FORM_MODEL_SUCCESS;
	public constructor(public payload: Object) { }
}

export class GetFormDataAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_FORM_DATA;
	public constructor(public payload: null = null) { }
}

export class GetFormDataSuccessAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_FORM_DATA_SUCCESS;
	public constructor(public payload: Object) { }
}

export class GetAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }};
	public constructor(public payload: string) { }
}

export class CreateAction implements Action {
	type = ActionTypes.CREATE_{{ $entitySnakeSin }};
	public constructor(public payload: Object) { }
}

export class UpdateAction implements Action {
	type = ActionTypes.UPDATE_{{ $entitySnakeSin }};
	public constructor(public payload: {{ $entitySin }}) { }
}

export class DeleteAction implements Action {
	type = ActionTypes.DELETE_{{ $entitySnakeSin }};
	public constructor(public payload: { id: string, reloadListQuery: Object }) { }
}

export class RestoreAction implements Action {
	type = ActionTypes.RESTORE_{{ $entitySnakeSin }};
	public constructor(public payload: string) { }
}

export class SetSelectedAction implements Action {
	type = ActionTypes.SET_SELECTED_{{ $entitySnakeSin }};
	public constructor(public payload: {{ $entitySin }} | Object = null) { }
}

export class SetErrorsAction implements Action {
	type = ActionTypes.SET_{{ $entitySnakeSin }}_ERRORS;
	public constructor(public payload: {{ $entitySin }} | Object = {}) { }
}

export type Actions
	= LoadAction
	| LoadSuccessAction
	| GetFormModelAction
	| GetFormModelSuccessAction
	| GetFormDataAction
	| GetFormDataSuccessAction
	| CreateAction
	| GetAction
	| UpdateAction
	| DeleteAction
	| RestoreAction
	| SetSelectedAction
	| SetErrorsAction;
