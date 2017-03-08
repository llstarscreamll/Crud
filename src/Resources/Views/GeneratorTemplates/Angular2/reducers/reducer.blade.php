import { FormGroup } from '@angular/forms';
import * as {{ $actions = camel_case($gen->entityName()) }} from '../actions/{{ camel_case($gen->entityName()) }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { Pagination } from './../../core/models/pagination';

export interface State {
  {{ camel_case($gen->entityName()) }}FormModel: Object;
  {{ camel_case($gen->entityName()) }}FormData: Object;
  {{ camel_case($gen->entityName(true)) }}: {{ $gen->entityName() }}[];
  pagination: Pagination | {};
  {{ camel_case($gen->entityName()) }}: {{ $gen->entityName() }} | null;
  loading: boolean;
  errors: Object
}

const initialState: State = {
  {{ camel_case($gen->entityName()) }}FormModel: {},
  {{ camel_case($gen->entityName()) }}FormData: {},
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
      return { ...state, {{ camel_case($gen->entityName()) }}FormModel: action.payload, loading: false };
    }
    
    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin = $gen->entityNameSnakeCase() }}_FORM_DATA: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}_FORM_DATA_SUCCESS: {
      return { ...state, {{ camel_case($gen->entityName()) }}FormData: action.payload, loading: false };
    }

    case {{ $actions }}.ActionTypes.CREATE_{{ $entitySnakeSin }}: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.CREATE_{{ $entitySnakeSin }}_SUCCESS: {
      return {...state, {{ $modelSin }}: action.payload, loading: false };
    }
/*

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}: {
      return {};
    }

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}_SUCCESS: {
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
 */
