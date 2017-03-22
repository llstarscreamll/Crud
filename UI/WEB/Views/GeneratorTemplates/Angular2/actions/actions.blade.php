import { Action } from '@ngrx/store';
import { type } from './../../core/util';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { {{ $entitySin.'Pagination' }} } from './../models/{{ camel_case($entitySin)."Pagination" }}';

export const ActionTypes = {
	LOAD_{{ $entitySnakePlu = $gen->entityNameSnakeCase(true) }}: type('[{{ $entitySin }}] Load {{ $entityPlu = $gen->entityName(true) }}'),
	LOAD_{{ $entitySnakePlu }}_SUCCESS: type('[{{ $entitySin }}] Load {{ $entityPlu }} Success'),
	GET_{{ $entitySnakeSin = $gen->entityNameSnakeCase() }}_FORM_DATA: type('[{{ $entitySin }}] Get {{ $entitySin }} Form Data'),
	GET_{{ $entitySnakeSin }}_FORM_DATA_SUCCESS: type('[{{ $entitySin }}] Get {{ $entitySin }} Form Data Success'),
	GET_{{ $entitySnakeSin }}_FORM_MODEL: type('[{{ $entitySin }}] Get {{ $entitySin }} Form Model'),
	GET_{{ $entitySnakeSin }}_FORM_MODEL_SUCCESS: type('[{{ $entitySin }}] Get {{ $entitySin }} Form Model Success'),
	GET_{{ $entitySnakeSin}}: type('[{{ $entitySin }}] Get {{ $entitySin }}'),
	GET_{{ $entitySnakeSin }}_SUCCESS: type('[{{ $entitySin }}] Get {{ $entitySin }} Success'),
	CREATE_{{ $entitySnakeSin }}: type('[{{ $entitySin }}] Create {{ $entitySin }}'),
	CREATE_{{ $entitySnakeSin }}_SUCCESS: type('[{{ $entitySin }}] Create {{ $entitySin }} Success'),
	UPDATE_{{ $entitySnakeSin }}: type('[{{ $entitySin }}] Update {{ $entitySin }}'),
	UPDATE_{{ $entitySnakeSin }}_SUCCESS: type('[{{ $entitySin }}] Update {{ $entitySin }} Success'),
	DELETE_{{ $entitySnakeSin }}: type('[{{ $entitySin }}] Delete {{ $entitySin }}'),
	DELETE_{{ $entitySnakeSin }}_SUCCESS: type('[{{ $entitySin }}] Delete {{ $entitySin }} Success'),
	RESTORE_{{ $entitySnakeSin }}: type('[{{ $entitySin }}] Restore {{ $entitySin }}'),
	RESTORE_{{ $entitySnakeSin }}_SUCCESS: type('[{{ $entitySin }}] Restore {{ $entitySin }} Success'),
}

export class LoadAction implements Action {
	type = ActionTypes.LOAD_{{ $entitySnakePlu }};
	public constructor(public payload: any) { }
}

export class LoadSuccessAction implements Action {
	type = ActionTypes.LOAD_{{ $entitySnakePlu }}_SUCCESS;
	public constructor(public payload: {{ $entitySin.'Pagination' }} ) { }
}

export class GetFormModelAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_FORM_MODEL;
	public constructor(public payload: null) { }
}

export class GetFormModelSuccessAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_FORM_MODEL_SUCCESS;
	public constructor(public payload: Object) { }
}

export class GetFormDataAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_FORM_DATA;
	public constructor(public payload: null) { }
}

export class GetFormDataSuccessAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_FORM_DATA_SUCCESS;
	public constructor(public payload: Object) { }
}

export class GetAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }};
	public constructor(public payload: string) { }
}

export class GetSuccessAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: {{ $entitySin }} | Object) { }
}

export class CreateAction implements Action {
	type = ActionTypes.CREATE_{{ $entitySnakeSin }};
	public constructor(public payload: Object) { }
}

export class CreateSuccessAction implements Action {
	type = ActionTypes.CREATE_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: Object) { }
}

export class UpdateAction implements Action {
	type = ActionTypes.UPDATE_{{ $entitySnakeSin }};
	public constructor(public payload: null) { }
}

export class UpdateSuccessAction implements Action {
	type = ActionTypes.UPDATE_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: null) { }
}

export class DeleteAction implements Action {
	type = ActionTypes.DELETE_{{ $entitySnakeSin }};
	public constructor(public payload: null) { }
}

export class DeleteSuccessAction implements Action {
	type = ActionTypes.DELETE_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: null) { }
}

export class RestoreAction implements Action {
	type = ActionTypes.RESTORE_{{ $entitySnakeSin }};
	public constructor(public payload: null) { }
}

export class RestoreSuccessAction implements Action {
	type = ActionTypes.RESTORE_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: null) { }
}

export type Actions
	= LoadAction
	| LoadSuccessAction
	| GetFormModelAction
	| GetFormModelSuccessAction
	| GetFormDataAction
	| GetFormDataSuccessAction
	| GetAction
	| GetSuccessAction
	| CreateAction
	| CreateSuccessAction
	| UpdateAction
	| UpdateSuccessAction
	| DeleteAction
	| DeleteSuccessAction
	| RestoreAction
	| RestoreSuccessAction;
