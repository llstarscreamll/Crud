import { MockBackend, MockConnection } from '@angular/http/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';

export const FORM_MODEL = {!! json_encode($gen->getFormModelConfigArray($fields)) !!};

export function setupMockBackend(mockBackend: MockBackend) {
	mockBackend.connections.subscribe((connection: MockConnection) => {
	  if (connection.request.url.includes('form-model')) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify(FORM_MODEL)
	    })));
	  }
	});
}
