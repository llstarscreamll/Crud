import { Pagination } from './../../core/models/pagination';
import { {{ $gen->entityName() }} } from './{{ camel_case($gen->entityName()) }}';

/**
 * {{ $gen->entityName() }}Pagination Class.
 *
 * @author [name] <[<email address>]>
 */
export class {{ $gen->entityName() }}Pagination {
	public data: {{ $gen->entityName() }}[];
	public pagination: { pagination: Pagination };
}
