/* tslint:disable:no-unused-variable */
import { Location } from '@angular/common';
import { ReactiveFormsModule } from '@angular/forms';
import { Ng2BootstrapModule } from 'ngx-bootstrap';
import { RouterTestingModule } from '@angular/router/testing';
import { Router, ActivatedRoute } from '@angular/router';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { Store, StoreModule } from '@ngrx/store';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { Observable } from 'rxjs/Observable';

import { environment } from './../../../environments/environment';
import { CoreModule } from './../../core/core.module';
import { DynamicFormModule } from './../../dynamic-form/dynamic-form.module';
import * as fromRoot from './../../reducers';
import { AuthGuard } from './../../auth/guards/auth.guard';
import { AuthService } from './../../auth/services/auth.service';

import { {{ $model = $gen->entityName() }} } from './../models/{{ camel_case($gen->entityName()) }}';
import { EFFECTS } from './../effects/';
import { SERVICES } from './../services';

export const FORM_MODEL = {!! json_encode($gen->getFormModelConfigArray($fields)) !!};

export let translateKey: string = '{{ $gen->entityNameSnakeCase() }}.';
export let tableColumns = [
@foreach ($fields as $field)
@if (!$field->hidden)
  '{{ $gen->tableName.'.'.$field->name }}',
@endif
@endforeach
];

// Testing Models
export let {{ $gen->entityName() }}One: {{ $model }} = {!! json_encode(['id' => 'a1'] + factory('App\Containers\\'.$gen->containerName().'\\Models\\'.$gen->entityName())->make()->toArray()) !!};
export let {{ $gen->entityName() }}Two: {{ $model }} = {!! json_encode(['id' => 'b2'] + factory('App\Containers\\'.$gen->containerName().'\\Models\\'.$gen->entityName())->make()->toArray()) !!};
export let {{ $gen->entityName() }}List: {{ $model }}[] = [
	{{ $gen->entityName() }}One,
	{{ $gen->entityName() }}Two,
];

// Mockbackend settings
export function setupMockBackend(mockBackend: MockBackend) {
	mockBackend.connections.subscribe((connection: MockConnection) => {
	  if (connection.request.url.search(/{{ $gen->slugEntityName(true) }}\/form-model/i) > -1) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify(FORM_MODEL),
	      status: 200,
	      statusText: "OK",
	    })));
	    return;
	  }

	  if (connection.request.url.search(/{{ $gen->slugEntityName(true) }}\/a1/i) > -1) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify({data: {{ $gen->entityName() }}One}),
	      status: 200,
	      statusText: "OK",
	    })));
	    return;
	  }

	  if (connection.request.url.search(/{{ $gen->slugEntityName(true) }}\/b2/i) > -1) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify({data: {{ $gen->entityName() }}Two}),
	      status: 200,
	      statusText: "OK",
	    })));
	    return;
	  }
	});
}

// Containers Testbed Imports
export const CONTAINERS_IMPORTS = [
	RouterTestingModule,
  HttpModule,
  StoreModule.provideStore(fromRoot.reducer),
  ...EFFECTS,
  TranslateModule.forRoot(),
  CoreModule,
  environment.theme,
  ReactiveFormsModule,
  Ng2BootstrapModule.forRoot(),
  DynamicFormModule,
];

export const CONTAINERS_PROVIDERS = [
	MockBackend,
  BaseRequestOptions,
  AuthGuard,
  AuthService,
  {
    provide: Http,
    useFactory: (backend, defaultOptions) => new Http(backend, defaultOptions),
    deps: [MockBackend, BaseRequestOptions]
  },
  { provide: ActivatedRoute, useValue: { 'params': Observable.from([{ 'id': {{ $gen->entityName() }}One.id }]) } },
  ...SERVICES,
];
