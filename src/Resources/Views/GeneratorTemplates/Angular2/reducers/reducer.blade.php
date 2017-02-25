import * as {{ $actions = camel_case($gen->entityName()) }} from '../actions/{{ camel_case($gen->entityName()) }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';

/**
 * Reducers can't be executed from child modules, only from main module reducer:
 * https://github.com/ngrx/store/issues/211
 * 
 * The community have requested this feature but isn't implemented yet, but it's
 * schedule for @ngrx/store version 3:
 * https://gist.github.com/MikeRyan52/5d361681ed0c81e38775dd2db15ae202
 */

export interface State {
  {{ camel_case($gen->entityName(true)) }}: {{ $gen->entityName() }}[];
  pagination: Object;
  {{ camel_case($gen->entityName()) }}: {{ $gen->entityName() }} | null;
  loading: boolean;
  errors: Object
}

const initialState: State = {
  {{ $modelPlu = camel_case($gen->entityName(true)) }}: [],
  pagination: {},
  {{ $modelSin = camel_case($gen->entityName()) }}: null,
  loading: true,
  errors: {}
};

export function reducer(state = initialState, action: {{ $actions }}.Actions): State {
  switch (action.type) {
    case {{ $actions }}.ActionTypes.LOAD_{{ $entitySnakePlu = $gen->entityNameSnakeCase(true) }}: {
      return {
        {{ $modelPlu }}: state.{{ $modelPlu }},
        pagination: state.pagination,
        {{ $modelSin }}: state.{{ $modelSin }},
        loading: true,
        errors: state.errors
      };
    }

    case {{ $actions }}.ActionTypes.LOAD_{{ $entitySnakePlu }}_SUCCESS: {
      let {{ $modelSin }} = action.payload.data as {{ $gen->entityName() }}[];
      let pagination = action.payload.meta.pagination;
      return {
        {{ $modelPlu }}: {{ $modelSin }},
        {{ $modelSin }}: state.{{ $modelSin }},
        pagination: pagination,
        loading: false,
        errors: state.errors
      };
    }
/*
    case {{ $actions }}.ActionTypes.GET_{{ $entitySnakeSin = $gen->entityNameSnakeCase() }}: {
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
  }
 }

/**
  Don't forget to import these reducer on the main app reducer!!

  import * as from{{ $entity = $gen->entityName() }} from './../../{{ camel_case($entity) }}/reducers/{{ camel_case($entity).'.reducer' }}';
  export interface State {
    {{ camel_case($entity) }}: from{{ $entity }}.State;
  }
  const reducers = {
    {{ camel_case($entity) }}: from{{ $entity }}.reducer,
  };
  export const get{{ $entity }}State = (state: State) => state.{{ camel_case($entity) }};
 */
