import { Pagination } from './../../core/models/pagination';
import { Book } from './book';

/**
 * BookPagination Class.
 *
 * @author  [name] <[<email address>]>
 */
export class BookPagination {
	public data: Book[];
	public pagination: Pagination;
}
