import { FormGroup } from '@angular/forms';
import * as {{ $actions = camel_case($gen->entityName()) }} from '../actions/{{ camel_case($gen->entityName()) }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { Pagination } from './../../core/models/pagination';

/**
 * Reducers can't be executed from child modules, only from main module reducer:
 * https://github.com/ngrx/store/issues/211
 * 
 * The community have requested this feature but isn't implemented yet, but it's
 * schedule for @ngrx/store version 3:
 * https://gist.github.com/MikeRyan52/5d361681ed0c81e38775dd2db15ae202
 */

export interface State {
  {{ camel_case($gen->entityName()) }}FormModel: Object;
  {{ camel_case($gen->entityName()) }}FormGroup: FormGroup | null;
  {{ camel_case($gen->entityName(true)) }}: {{ $gen->entityName() }}[];
  pagination: Pagination | {};
  {{ camel_case($gen->entityName()) }}: {{ $gen->entityName() }} | null;
  loading: boolean;
  errors: Object
}

const initialState: State = {
  {{ camel_case($gen->entityName()) }}FormModel: {},
  {{ camel_case($gen->entityName()) }}FormGroup: null,
  {{ $modelPlu = camel_case($gen->entityName(true)) }}: [],
  pagination: {},
  {{ $modelSin = camel_case($gen->entityName()) }}: null,
  loading: true,
  errors: {}
};

export function reducer(state = initialState, action: {{ $actions }}.Actions): State {
  switch (action.type) {
    case {{ $actions }}.ActionTypes.LOAD_{{ $entitySnakePlu = $gen->entityNameSnakeCase(true) }}: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.LOAD_{{ $entitySnakePlu }}_SUCCESS: {
      let {{ $modelSin }} = action.payload.data as {{ $gen->entityName() }}[];
      let pagination = action.payload.meta.pagination;
      return { ...state, {{ $modelPlu }}: {{ $modelSin }}, pagination: pagination, loading: false };
    }
    
    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin = $gen->entityNameSnakeCase() }}_FORM_MODEL: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}_FORM_MODEL_SUCCESS: {
      return { ...state, {{ camel_case($gen->entityName()) }}FormModel: action.payload.model, {{ camel_case($gen->entityName()) }}FormGroup: action.payload.formGroup, loading: false };
    }
/*

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}: {
      return {};
    }

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}_SUCCESS: {
      return {};
    }

    case {{ $actions }}.ActionTypes.CREATE_{{ $entitySnakeSin }}: {
      return {};
    }

    case {{ $actions }}.ActionTypes.CREATE_{{ $entitySnakeSin }}_SUCCESS: {
      return {};
    }

    case {{ $actions }}.ActionTypes.UPDATE_{{ $entitySnakeSin }}: {
      return {};
    }

    case {{ $actions }}.ActionTypes.UPDATE_{{ $entitySnakeSin }}_SUCCESS: {
      return {};
    }

    case {{ $actions }}.ActionTypes.DELETE_{{ $entitySnakeSin }}: {
      return {};
    }

    case {{ $actions }}.ActionTypes.DELETE_{{ $entitySnakeSin }}_SUCCESS: {
      return {};
    }

    case {{ $actions }}.ActionTypes.RESTORE_{{ $entitySnakeSin }}: {
      return {};
    }

    case {{ $actions }}.ActionTypes.RESTORE_{{ $entitySnakeSin }}_SUCCESS: {
      return {};
    }*/

    default: {
      return state;
    }
  }
 }

  export const get{{ $entity = $gen->entityName() }}FormModel = (state: State) => state.{{ camel_case($entity) }}FormModel;
  export const get{{ $entity }}FormGroup = (state: State) => state.{{ camel_case($entity) }}FormGroup;

/**
  Don't forget to import these reducer on the main app reducer!!

  import * as from{{ $entity }} from './../../{{ camel_case($entity) }}/reducers/{{ camel_case($entity).'.reducer' }}';

  export interface State {
    {{ camel_case($entity) }}: from{{ $entity }}.State;
  }

  const reducers = {
    {{ camel_case($entity) }}: from{{ $entity }}.reducer,
  };

  // Book selectors
  export const get{{ $entity }}State = (state: State) => state.{{ camel_case($entity) }};
  export const get{{ $entity }}FormModel = createSelector(get{{ $entity }}State, fromBook.get{{ $entity }}FormModel);
  export const get{{ $entity }}FormGroup = createSelector(get{{ $entity }}State, fromBook.get{{ $entity }}FormGroup);
 */
