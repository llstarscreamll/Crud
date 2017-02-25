import { Action } from '@ngrx/store';
import { type } from '../../core/util';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';

export const ActionTypes = {
	LOAD_{{ $entitySnakePlu = $gen->entityNameSnakeCase(true) }}: type('[{{ $entitySin }}] Load {{ $entityPlu = $gen->entityName(true) }}'),
	LOAD_{{ $entitySnakePlu }}_SUCCESS: type('[{{ $entitySin }}] Load {{ $entityPlu }} Success'),
	GET_{{ $entitySnakeSin = $gen->entityNameSnakeCase() }}: type('[{{ $entitySin }}] Get {{ $entitySin }}'),
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
	type = ActionTypes.LOAD_{{ $entitySnakePlu = $gen->entityNameSnakeCase(true) }};
	public constructor(public payload: {}) {}
}

export class LoadSuccessAction implements Action {
	type = ActionTypes.LOAD_{{ $entitySnakePlu }}_SUCCESS;
	public constructor(public payload: {{ $entitySin }}[] ) {}
}

export class GetAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin = $gen->entityNameSnakeCase() }};
	public constructor(public payload: {}) {}
}

export class GetSuccessAction implements Action {
	type = ActionTypes.GET_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: {}) {}
}

export class CreateAction implements Action {
	type = ActionTypes.CREATE_{{ $entitySnakeSin }};
	public constructor(public payload: {}) {}
}

export class CreateSuccessAction implements Action {
	type = ActionTypes.CREATE_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: {}) {}
}

export class UpdateAction implements Action {
	type = ActionTypes.UPDATE_{{ $entitySnakeSin }};
	public constructor(public payload: {}) {}
}

export class UpdateSuccessAction implements Action {
	type = ActionTypes.UPDATE_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: {}) {}
}

export class DeleteAction implements Action {
	type = ActionTypes.DELETE_{{ $entitySnakeSin }};
	public constructor(public payload: {}) {}
}

export class DeleteSuccessAction implements Action {
	type = ActionTypes.DELETE_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: {}) {}
}

export class RestoreAction implements Action {
	type = ActionTypes.RESTORE_{{ $entitySnakeSin }};
	public constructor(public payload: {}) {}
}

export class RestoreSuccessAction implements Action {
	type = ActionTypes.RESTORE_{{ $entitySnakeSin }}_SUCCESS;
	public constructor(public payload: {}) {}
}

export type Actions
	= LoadAction
	| LoadSuccessAction
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
