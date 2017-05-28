import * as book from '../actions/book.actions';
import { Book } from './../models/book';
import { BookPagination } from './../models/bookPagination';

import { AppMessage } from './../../core/models/appMessage';
import { SearchQuery } from './../components/book/book-abstract.component';

/**
 * Book Reducer.
 *
 * @author  [name] <[<email address>]>
 */
export interface State {
  bookFormModel: Object;
  list: Array<any>;
  booksPagination: BookPagination | null;
  selectedBook: Book | null;
  searchQuery: SearchQuery;
  loading: boolean;
  messages: AppMessage;
}

const initialState: State = {
  bookFormModel: null,
  booksPagination: null,
  list: null,
  selectedBook: null,
  searchQuery: {
    // columns to retrive from API
    filter: [
      // 'books.id',
      'books.reason_id',
      'books.name',
      'books.author',
      'books.genre',
      'books.stars',
      'books.published_year',
      'books.enabled',
      'books.status',
      'books.synopsis',
      'books.approved_at',
      'books.approved_by',
      // 'books.created_at',
      // 'books.updated_at',
      // 'books.deleted_at',
    ],
    // the relations map, we need some fields for eager load certain relations
    include: {
      'books.reason_id': 'reason',
      'books.approved_by': 'approvedBy',
    },
    orderBy: "books.created_at",
    sortedBy: "desc",
    page: 1
  },
  loading: true,
  messages: null
};

export function reducer(state = initialState, action: book.Actions): State {
  switch (action.type) {
    case book.GET_FORM_MODEL: {
      return { ...state, loading: true };
    }

    case book.GET_FORM_MODEL_SUCCESS: {
      return { ...state, bookFormModel: action.payload, loading: false };
    }

    case book.SET_SEARCH_QUERY: {
      let searchQuery = Object.assign({}, state.searchQuery, action.payload);
      return { ...state, searchQuery: searchQuery };
    }

    case book.PAGINATE: {
      return { ...state, loading: true };
    }

    case book.PAGINATE_SUCCESS: {
      return { ...state, booksPagination: action.payload as BookPagination, loading: false };
    }

    case book.LIST: {
      return { ...state, loading: true };
    }

    case book.LIST_SUCCESS: {
      return { ...state, list: action.payload, loading: false };
    }

    case book.CREATE: {
      return { ...state, loading: true };
    }

    case book.GET_BY_ID: {
      return { ...state, loading: true };
    }

    case book.UPDATE: {
      return { ...state, loading: true };
    }

    case book.DELETE: {
      return { ...state, loading: true };
    }

    case book.RESTORE: {
      return { ...state, loading: true };
    }

    case book.SET_SELECTED: {
      return { ...state, selectedBook: action.payload as Book, loading: false };
    }

    case book.SET_MESSAGES: {
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

export const getFormModel = (state: State) => state.bookFormModel;
export const getLoading = (state: State) => state.loading;
export const getItemsList = (state: State) => state.list;
export const getItemsPagination = (state: State) => state.booksPagination;
export const getSelectedItem = (state: State) => state.selectedBook;
export const getSearchQuery = (state: State) => state.searchQuery;
export const getMessages = (state: State) => state.messages;

/* -----------------------------------------------------------------------------
Don't forget to import these reducer on the main app reducer!!

import * as fromBook from './library/reducers/book.reducer';

export interface State {
  book: fromBook.State;
}

const reducers = {
  book: fromBook.reducer,
};

// Book selectors
export const getBookState = (state: State) => state.book;
export const getBookSearchQuery = createSelector(getBookState, fromBook.getSearchQuery);
export const getBookFormModel = createSelector(getBookState, fromBook.getFormModel);
export const getBookFormData = createSelector(getReasonList,getUserList,(Reasons,Users,) => ({ Reasons,Users, }));
export const getBookList = createSelector(getBookState, fromBook.getItemsList);
export const getBooksPagination = createSelector(getBookState, fromBook.getItemsPagination);
export const getSelectedBook = createSelector(getBookState, fromBook.getSelectedItem);
export const getBookLoading = createSelector(getBookState, fromBook.getLoading);
export const getBookMessages = createSelector(getBookState, fromBook.getMessages);

----------------------------------------------------------------------------- */
