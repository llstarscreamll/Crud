import { Reason } from './../../reason/models/reason';

/**
 * Book Class.
 *
 * @author  [name] <[<email address>]>
 */
export class Book {
	id: string;
	reason_id: number;
	name: string;
	author: string;
	genre: string;
	stars: number;
	published_year: string;
	enabled: boolean;
	status: string;
	synopsis: string;
	approved_at: string;
	approved_by: number;
	created_at: string;
	updated_at: string;
	deleted_at: string;
	reason: { data: Reason };
}
