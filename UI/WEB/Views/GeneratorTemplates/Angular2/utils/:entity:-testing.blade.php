import { MockBackend, MockConnection } from '@angular/http/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';

export const FORM_MODEL = {!! json_encode($gen->getFormModelConfigArray($fields)) !!};

export let translateKey: string = '{{ $gen->entityNameSnakeCase() }}.';
export let tableColumns = [
@foreach ($fields as $field)
@if (!$field->hidden)
  '{{ $gen->tableName.'.'.$field->name }}',
@endif
@endforeach
];

export function setupMockBackend(mockBackend: MockBackend) {
	mockBackend.connections.subscribe((connection: MockConnection) => {
	  if (connection.request.url.includes('form-model')) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify(FORM_MODEL)
	    })));
	  }
	});
}
