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

import { Book } from './../models/book';
import { EFFECTS } from './../effects/';
import { SERVICES } from './../services';

/**
 * Book Test Utils.
 *
 * @author  [name] <[<email address>]>
 */

export let translateKey: string = 'BOOK.';
export let tableColumns = [
  'books.id',
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
  'books.created_at',
  'books.updated_at',
  'books.deleted_at',
];

// Testing Models

export const FORM_MODEL = {"id":{"name":"id","type":"text","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":true,"visibility":{"create":false,"details":true,"edit":false,"search":true},"validation":["numeric"]},"reason_id":{"name":"reason_id","type":"select","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"dynamicOptions":{"data":"Reasons"},"validation":["numeric","exists:reasons,id"]},"name":{"name":"name","type":"text","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"validation":["required","string"]},"author":{"name":"author","type":"text","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"validation":["required","string"]},"genre":{"name":"genre","type":"text","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"validation":["required","string"]},"stars":{"name":"stars","type":"number","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"validation":["numeric","min:1","max:5"]},"published_year":{"name":"published_year","type":"date","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"validation":["required","date:Y"]},"enabled":{"name":"enabled","type":"checkbox","placeholder":"","value":"1","min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"option":{"value":"true","label":"Yes"},"validation":["boolean"]},"status":{"name":"status","type":"radio","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"options":["setting_documents","waiting_confirmation","reviewing","approved"],"validation":["required","string"]},"unlocking_word":{"name":"unlocking_word","type":"text","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":false,"edit":true,"search":false},"validation":["required","string","confirmed"]},"synopsis":{"name":"synopsis","type":"textarea","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"validation":["string"]},"approved_at":{"name":"approved_at","type":"datetime-local","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"validation":["date:Y-m-d H:i:s"]},"approved_by":{"name":"approved_by","type":"select","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":true,"edit":true,"search":true},"dynamicOptions":{"data":"Users"},"validation":["exists:users,id"]},"approved_password":{"name":"approved_password","type":"text","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":true,"details":false,"edit":true,"search":false},"validation":["string","confirmed"]},"created_at":{"name":"created_at","type":"datetime-local","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":false,"details":true,"edit":false,"search":true},"validation":["date:Y-m-d H:i:s"]},"updated_at":{"name":"updated_at","type":"datetime-local","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":false,"details":true,"edit":false,"search":true},"validation":["date:Y-m-d H:i:s"]},"deleted_at":{"name":"deleted_at","type":"datetime-local","placeholder":"","value":null,"min":"","max":"","mainWrapperClass":"col-sm-6","labelClass":"","controlWrapperClass":"","controlClass":"","break":false,"visibility":{"create":false,"details":true,"edit":false,"search":true},"validation":["date:Y-m-d H:i:s"]},"_options_":{"model":"book"}};
export const FORM_DATA = {
	Reasons: [{ id: BookOne.reason_id, text: BookOne.reason_id }, { id: BookTwo.reason_id, text: BookTwo.reason_id },]
	Users: [{ id: BookOne.approved_by, text: BookOne.approved_by }, { id: BookTwo.approved_by, text: BookTwo.approved_by },]
};

// Mockbackend settings
export function setupMockBackend(mockBackend: MockBackend) {
	mockBackend.connections.subscribe((connection: MockConnection) => {
		// POST create item request
		if (connection.request.method === 1 && connection.request.url.search(/books/i) > -1) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify({ data: JSON.parse(connection.request.getBody()) }),
	      status: 200,
	      statusText: "OK",
	    })));
	    return;
	  }

	  // POST update 'a1' (BookOne) item request
		if (connection.request.method === 1 && connection.request.url.search(/books\/a1/i) > -1) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify({ data: BookOne }),
	      status: 200,
	      statusText: "OK",
	    })));
	    return;
	  }

		// GET form model request
	  if (connection.request.url.search(/books\/form-model/i) > -1) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify(FORM_MODEL),
	      status: 200,
	      statusText: "OK",
	    })));
	    return;
	  }

	  // GET form data request
	  if (connection.request.url.search(/books\/form-data/i) > -1) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify(FORM_DATA),
	      status: 200,
	      statusText: "OK",
	    })));
	    return;
	  }

	  // GET 'a1' (BookOne) item data request
	  if (connection.request.url.search(/books\/a1/i) > -1) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify({data: BookOne}),
	      status: 200,
	      statusText: "OK",
	    })));
	    return;
	  }

	  // GET 'b2' (BookTwo) item data request
	  if (connection.request.url.search(/books\/b2/i) > -1) {
	    connection.mockRespond(new Response(new ResponseOptions({
	      body: JSON.stringify({data: BookTwo}),
	      status: 200,
	      statusText: "OK",
	    })));
	    return;
	  }
	});
}

// Containers Testbed Imports
export const IMPORTS = [
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

export const PROVIDERS = [
	MockBackend,
  BaseRequestOptions,
  AuthGuard,
  AuthService,
  {
    provide: Http,
    useFactory: (backend, defaultOptions) => new Http(backend, defaultOptions),
    deps: [MockBackend, BaseRequestOptions]
  },
  { provide: ActivatedRoute, useValue: { 'params': Observable.from([{ 'id': BookOne.id }]) } },
  ...SERVICES,
];
