import { Pagination } from './../../core/models/pagination';
import { {{ $gen->entityName() }} } from './{{ camel_case($gen->entityName()) }}';

export class {{ $gen->entityName() }}Pagination {
	public data: {{ $gen->entityName() }}[];
	public meta: { pagination: Pagination };
}
