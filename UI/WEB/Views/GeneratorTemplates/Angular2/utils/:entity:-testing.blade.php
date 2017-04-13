import { MockBackend, MockConnection } from '@angular/http/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';

import { {{ $model = $gen->entityName() }} } from './../models/{{ camel_case($gen->entityName()) }}';

export const FORM_MODEL = {!! json_encode($gen->getFormModelConfigArray($fields)) !!};

export let translateKey: string = '{{ $gen->entityNameSnakeCase() }}.';
export let tableColumns = [
@foreach ($fields as $field)
@if (!$field->hidden)
  '{{ $gen->tableName.'.'.$field->name }}',
@endif
@endforeach
];

export let {{ $gen->entityName() }}One: {{ $model }} = {!! json_encode(['id' => 'a1'] + factory('App\Containers\\'.$gen->containerName().'\\Models\\'.$gen->entityName())->make()->toArray()) !!};
export let {{ $gen->entityName() }}Two: {{ $model }} = {!! json_encode(['id' => 'b2'] + factory('App\Containers\\'.$gen->containerName().'\\Models\\'.$gen->entityName())->make()->toArray()) !!};
export let {{ $gen->entityName() }}List: {{ $model }}[] = [
	{{ $gen->entityName() }}One,
	{{ $gen->entityName() }}Two,
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
