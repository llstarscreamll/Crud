import * as {{ $actions = camel_case($gen->entityName()) }} from '../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { {{ $paginationModel = $gen->entityName().'Pagination' }} } from './../models/{{ camel_case($entitySin) }}Pagination';

import { AppMessage } from './../../core/models/appMessage';
import { SearchQuery } from './../components/{{ $gen->slugEntityName() }}/{{ str_replace('.ts', '', $gen->componentFile('abstract', false, true)) }}';

/**
 * {{ $gen->entityName() }} Reducer.
 *
 * @author [name] <[<email address>]>
 */
export interface State {
  {{ $formModel = camel_case($gen->entityName()).'FormModel' }}: Object;
  {{ $formData = camel_case($gen->entityName()).'FormData' }}: Object;
  {{ $pagination = camel_case($gen->entityName(true)).'Pagination' }}: {{ $gen->entityName() }}Pagination | null;
  {{ $selected = 'selected'.$gen->entityName() }}: {{ $gen->entityName() }} | null;
  searchQuery: SearchQuery;
  loading: boolean;
  messages: AppMessage;
}

const initialState: State = {
  {{ $formModel }}: null,
  {{ $formData }}: null,
  {{ $pagination }}: null,
  {{ $selected }}: null,
  searchQuery: {
    // columns to retrive from API
    filter: [
@foreach ($fields as $field)
@if ($field->on_index_table && !$field->hidden)
      '{{ $gen->tableName.'.'.$field->name }}',
@endif
@endforeach
    ],
    // the relations map, we need some fields for eager load certain relations
    include: {
@foreach ($fields as $field)
@if ($field->namespace && !$field->hidden)
      '{{ $gen->tableName.'.'.$field->name }}': '{{  $gen->relationNameFromField($field)  }}',
@endif
@endforeach
    },
    orderBy: "{{ $gen->hasLaravelTimestamps ? $gen->tableName.'.created_at' : $gen->tableName.'.id' }}",
    sortedBy: "desc",
    page: 1
  },
  loading: true,
  messages: null
};

export function reducer(state = initialState, action: {{ $actions }}.Actions): State {
  switch (action.type) {
    case {{ $actions }}.GET_FORM_MODEL: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.GET_FORM_MODEL_SUCCESS: {
      return { ...state, {{ camel_case($gen->entityName()) }}FormModel: action.payload, loading: false };
    }
    
    case {{ $actions }}.GET_FORM_DATA: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.GET_FORM_DATA_SUCCESS: {
      return { ...state, {{ camel_case($gen->entityName()) }}FormData: action.payload, loading: false };
    }

    case {{ $actions }}.SET_SEARCH_QUERY: {
      let searchQuery = Object.assign({}, state.searchQuery, action.payload);
      return { ...state, searchQuery: searchQuery };
    }

    case {{ $actions }}.PAGINATE: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.PAGINATE_SUCCESS: {
      return { ...state, {{ $pagination }}: action.payload as {{ $paginationModel }}, loading: false };
    }
    
    case {{ $actions }}.CREATE: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.GET_BY_ID: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.UPDATE: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.DELETE: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.RESTORE: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.SET_SELECTED: {
      return { ...state, selected{{ $gen->entityName() }}: action.payload as {{ $entitySin }}, loading: false };
    }

    case {{ $actions }}.SET_MESSAGES: {
      let msg = action.payload;

      // if messages already exists and you want to clean that messages,
      // exists messages must have been shown at least for 2 seconds
      // before they can be removed
      if(state.messages && state.messages.date && !msg) {
        let endTime = new Date().getTime();
        let startTime = state.messages.date.getTime();

        // at least 2 seconds must have happened to set the messages no null
        msg = ((endTime - startTime) / 1000 > 2) ? msg : state.messages ;
      }

      return { ...state, messages: msg };
    }

    default: {
      return state;
    }
  }
 }

export const getFormModel = (state: State) => state.{{ $formModel }};
export const getFormData = (state: State) => state.{{ $formData }};
export const getLoading = (state: State) => state.{{ 'loading' }};
export const getItemsPagination = (state: State) => state.{{ $pagination }};
export const getSelectedItem = (state: State) => state.{{ $selected }};
export const getSearchQuery = (state: State) => state.searchQuery;
export const getMessages = (state: State) => state.messages;

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
export const get{{ $entity }}SearchQuery = createSelector(get{{ $entity }}State, from{{ $entity }}.getSearchQuery);
export const get{{ studly_case($formModel) }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getFormModel);
export const get{{ studly_case($formData) }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getFormData);
export const get{{ studly_case($pagination) }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getItemsPagination);
export const get{{ studly_case($selected) }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getSelectedItem);
export const get{{ $gen->entityName().studly_case('loading') }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getLoading);
export const get{{ $gen->entityName().studly_case('messages') }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getMessages);

----------------------------------------------------------------------------- */
