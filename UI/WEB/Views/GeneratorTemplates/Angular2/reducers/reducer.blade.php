import { FormGroup } from '@angular/forms';
import * as {{ $actions = camel_case($gen->entityName()) }} from '../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { {{ $gen->entityName() }}Pagination } from './../models/{{ camel_case($entitySin) }}Pagination';

export interface State {
  {{ $formModel = camel_case($gen->entityName()).'FormModel' }}: Object;
  {{ $formData = camel_case($gen->entityName()).'FormData' }}: Object;
  {{ $pagination = camel_case($gen->entityName(true)).'Pagination' }}: {{ $gen->entityName() }}Pagination | null;
  selected{{ $gen->entityName() }}: {{ $gen->entityName() }} | null;
  loading: boolean;
  errors: Object;
}

const initialState: State = {
  {{ $formModel }}: {},
  {{ $formData }}: {},
  {{ $pagination }}: null,
  selected{{ $gen->entityName() }}: null,
  loading: true,
  errors: {}
};

export function reducer(state = initialState, action: {{ $actions }}.Actions): State {
  switch (action.type) {
    case {{ $actions }}.ActionTypes.LOAD_{{ $entitySnakePlu = $gen->entityNameSnakeCase(true) }}: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.LOAD_{{ $entitySnakePlu }}_SUCCESS: {
      return { ...state, {{ $pagination }}: action.payload, loading: false };
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
      return {...state, selected{{ $gen->entityName() }}: action.payload, loading: false };
    }

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}_SUCCESS: {
      return { ...state, selected{{ $gen->entityName() }}: action.payload, loading: false };
    }

/*
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
  export const getSelected{{ $entity }} = (state: State) => state.selected{{ $entity }};

/* -----------------------------------------------------------------------------
Don't forget to import these reducer on the main app reducer!!

import * as from{{ $entity }} from './../../{{ $gen->slugModuleName() }}/reducers/{{ $gen->slugEntityName().'.reducer' }}';

export interface State {
  {{ camel_case($entity) }}: from{{ $entity }}.State;
}

const reducers = {
  {{ camel_case($entity) }}: from{{ $entity }}.reducer,
};

  
// {{ $gen->entityName() }} selectors
export const get{{ $entity }}State = (state: State) => state.{{ camel_case($entity) }};
export const get{{ $entity }}FormModel = createSelector(get{{ $entity }}State, from{{ $entity }}.get{{ $entity }}FormModel);
export const getSelected{{ $entity }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getSelected{{ $entity }});

----------------------------------------------------------------------------- */
