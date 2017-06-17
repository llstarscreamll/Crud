import { Pagination } from './../../core/models/pagination';
import { {{ $crud->entityName() }} } from './{{ camel_case($crud->entityName()) }}';

/**
 * {{ $crud->entityName() }}Pagination Class.
 *
 * @author [name] <[<email address>]>
 */
export class {{ $crud->entityName() }}Pagination {
	public data: {{ $crud->entityName() }}[];
	public pagination: Pagination;
}
