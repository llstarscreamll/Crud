import * as {{ $actions = camel_case($crud->entityName()) }} from '../actions/{{ $crud->slugEntityName() }}.actions';
import { {{ $entitySin = $crud->entityName() }} } from './../models/{{ camel_case($entitySin) }}';
import { {{ $paginationModel = $crud->entityName().'Pagination' }} } from './../models/{{ camel_case($entitySin) }}Pagination';

import { AppMessage } from './../../core/models/appMessage';
import { SearchQuery } from './../components/{{ $crud->slugEntityName() }}/{{ str_replace('.ts', '', $crud->componentFile('abstract', false, true)) }}';

/**
 * {{ $crud->entityName() }} Reducer.
 *
 * @author [name] <[<email address>]>
 */
export interface State {
  formModel: any[];
  list: Array<any>;
  pagination: {{ $crud->entityName() }}Pagination | null;
  selected: {{ $crud->entityName() }} | null;
  searchQuery: SearchQuery;
  loading: boolean;
  messages: AppMessage;
}

const initialState: State = {
  formModel: null,
  pagination: null,
  list: null,
  selected: null,
  searchQuery: {
    // columns to retrive from API
    filter: [
@foreach ($fields as $field)
@if ($field->on_index_table && !$field->hidden)
      '{{ $crud->tableName.'.'.$field->name }}',
@elseif(!$field->on_index_table && !$field->hidden)
      // '{{ $crud->tableName.'.'.$field->name }}',
@endif
@endforeach
    ],
    // the relations map, we need some fields for eager load certain relations
    include: {
@foreach ($fields as $field)
@if ($field->namespace && !$field->hidden)
      '{{ $crud->tableName.'.'.$field->name }}': '{{  $crud->relationNameFromField($field)  }}',
@endif
@endforeach
    },
    orderBy: "{{ $crud->hasLaravelTimestamps ? $crud->tableName.'.created_at' : $crud->tableName.'.id' }}",
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
      return { ...state, formModel: action.payload, loading: false };
    }

    case {{ $actions }}.SET_SEARCH_QUERY: {
      let searchQuery = Object.assign({}, state.searchQuery, action.payload);
      return { ...state, searchQuery: searchQuery };
    }

    case {{ $actions }}.PAGINATE: {
      return { ...state, loading: true };
    }

    case {{ $actions }}.PAGINATE_SUCCESS: {
      return { ...state, pagination: action.payload as {{ $paginationModel }}, loading: false };
    }

    case {{ $actions }}.LIST: {
      return { ...state };
    }

    case {{ $actions }}.LIST_SUCCESS: {
      return { ...state, list: action.payload };
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
      return { ...state, selected: action.payload as {{ $entitySin }}, loading: false };
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

export const getFormModel = (state: State) => state.formModel;
export const getLoading = (state: State) => state.{{ 'loading' }};
export const getItemsList = (state: State) => state.list;
export const getItemsPagination = (state: State) => state.pagination;
export const getSelectedItem = (state: State) => state.selected;
export const getSearchQuery = (state: State) => state.searchQuery;
export const getMessages = (state: State) => state.messages;

/* -----------------------------------------------------------------------------
Don't forget to import these reducer on the main app reducer!!

import * as from{{ $entity = $crud->entityName() }} from './{{ $crud->slugModuleName() }}/reducers/{{ $crud->slugEntityName().'.reducer' }}';

export interface State {
  {{ camel_case($entity) }}: from{{ $entity }}.State;
}

const reducers = {
  {{ camel_case($entity) }}: from{{ $entity }}.reducer,
};

// {{ $crud->entityName() }} selectors
export const get{{ $entity }}State = (state: State) => state.{{ camel_case($entity) }};
export const get{{ $entity }}SearchQuery = createSelector(get{{ $entity }}State, from{{ $entity }}.getSearchQuery);
export const get{{ $entity }}FormModel = createSelector(get{{ $entity }}State, from{{ $entity }}.getFormModel);
{{ !$crud->hasRelations ? '// ' : null }}export const get{{ $crud->entityName().'FormData' }} = createSelector(@foreach (($filteredFields = $fields->filter(function ($field) { return !empty($field->namespace); })->unique('namespace')) as $field){{ $field->namespace ? 'get'.class_basename($field->namespace).'List,' : null }}@endforeach
(@foreach ($filteredFields as $field){{ $field->namespace ? str_plural(class_basename($field->namespace)).',' : null }}@endforeach) => ({ @foreach ($filteredFields as $field){{ $field->namespace ? str_plural(class_basename($field->namespace)).',' : null }}@endforeach }));
export const get{{ $entity.'List' }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getItemsList);
export const get{{ $entity }}Pagination = createSelector(get{{ $entity }}State, from{{ $entity }}.getItemsPagination);
export const get{{ $entity }}Selected = createSelector(get{{ $entity }}State, from{{ $entity }}.getSelectedItem);
export const get{{ $crud->entityName().'Loading' }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getLoading);
export const get{{ $crud->entityName().'Messages' }} = createSelector(get{{ $entity }}State, from{{ $entity }}.getMessages);

----------------------------------------------------------------------------- */
