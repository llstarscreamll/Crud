import { FormGroup } from '@angular/forms';
import * as {{ $actions = camel_case($gen->entityName()) }} from '../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { {{ $paginationModel = $gen->entityName().'Pagination' }} } from './../models/{{ camel_case($entitySin) }}Pagination';

export interface State {
  {{ $formModel = camel_case($gen->entityName()).'FormModel' }}: Object;
  {{ $formData = camel_case($gen->entityName()).'FormData' }}: Object;
  {{ $pagination = camel_case($gen->entityName(true)).'Pagination' }}: {{ $gen->entityName() }}Pagination | null;
  {{ $selected = 'selected'.$gen->entityName() }}: {{ $gen->entityName() }} | null;
  loading: boolean;
  errors: Object;
}

const initialState: State = {
  {{ $formModel }}: {},
  {{ $formData }}: {},
  {{ $pagination }}: null,
  {{ $selected }}: null,
  loading: true,
  errors: {}
};

export function reducer(state = initialState, action: {{ $actions }}.Actions): State {
  switch (action.type) {
    case {{ $actions }}.ActionTypes.LOAD_{{ $entitySnakePlu = $gen->entityNameSnakeCase(true) }}: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.LOAD_{{ $entitySnakePlu }}_SUCCESS: {
      return { ...state, {{ $pagination }}: action.payload as {{ $paginationModel }}, loading: false };
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
      return {...state, loading: false };
    }

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin }}_SUCCESS: {
      return { ...state, selected{{ $gen->entityName() }}: action.payload as {{ $entitySin }}, loading: false };
    }

    case {{ $actions }}.ActionTypes.UPDATE_{{ $entitySnakeSin }}: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.UPDATE_{{ $entitySnakeSin }}_SUCCESS: {
      return { ...state, selected{{ $gen->entityName() }}: action.payload as {{ $entitySin }}, loading: false };
    }

    case {{ $actions }}.ActionTypes.DELETE_{{ $entitySnakeSin }}: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.ActionTypes.DELETE_{{ $entitySnakeSin }}_SUCCESS: {
      return { ...state, selected{{ $gen->entityName() }}: null };
    }

/*
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

  export const get{{ studly_case($formModel) }} = (state: State) => state.{{ $formModel }};
  export const get{{ studly_case($formData) }} = (state: State) => state.{{ $formData }};
  export const get{{ studly_case($pagination) }} = (state: State) => state.{{ $pagination }};
  export const get{{ studly_case($selected) }} = (state: State) => state.{{ $selected }};
  export const get{{ studly_case('loading') }} = (state: State) => state.{{ 'loading' }};
  export const get{{ studly_case('errors') }} = (state: State) => state.{{ 'errors' }};

/* -----------------------------------------------------------------------------
Don't forget to import these reducer on the main app reducer!!

import * as from{{ $entity = $gen->entityName() }} from './{{ $gen->slugModuleName() }}/reducers/{{ $gen->slugEntityName().'.reducer' }}';

export interface State {
  {{ camel_case($entity) }}: from{{ $entity }}.State;
}

const reducers = {
  {{ camel_case($entity) }}: from{{ $entity }}.reducer,
};

  
// {{ $gen->entityName() }} selectors
export const get{{ $entity }}State = (state: State) => state.{{ camel_case($entity) }};
export const get{{ studly_case($formModel) }} = createSelector(get{{ $entity }}State, from{{ $entity }}.get{{ studly_case($formModel) }});
export const get{{ studly_case($formData) }} = createSelector(get{{ $entity }}State, from{{ $entity }}.get{{ studly_case($formData) }});
export const get{{ studly_case($pagination) }} = createSelector(get{{ $entity }}State, from{{ $entity }}.get{{ studly_case($pagination) }});
export const get{{ studly_case($selected) }} = createSelector(get{{ $entity }}State, from{{ $entity }}.get{{ studly_case($selected) }});
export const get{{ $gen->entityName().studly_case('loading') }} = createSelector(get{{ $entity }}State, from{{ $entity }}.get{{ studly_case('loading') }});
export const get{{ $gen->entityName().studly_case('errors') }} = createSelector(get{{ $entity }}State, from{{ $entity }}.get{{ studly_case('errors') }});

----------------------------------------------------------------------------- */
