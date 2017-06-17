import { Location } from '@angular/common';
import { Title } from '@angular/platform-browser';
import { Router, ActivatedRoute } from '@angular/router';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';
import swal from 'sweetalert2';

import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as fromRoot from './../../../reducers';

import * as {{ $actions = camel_case($crud->entityName()).'Actions' }} from './../../actions/{{ $crud->slugEntityName() }}.actions';
import { {{ $entitySin = $crud->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';
import { {{ $pagModel = $entitySin.'Pagination' }} } from './../../models/{{ camel_case($entitySin) }}Pagination';

export interface SearchQuery {
  filter: string[];
  include: {};
  orderBy: string;
  sortedBy: string;
  page: number;
}

/**
 * {{ $crud->containerClass('abstract', false, true) }} Abstract Class.
 *
 * @author [name] <[<email address>]>
 */
export abstract class {{ $crud->containerClass('abstract', false, true) }} {
  /**
   * Dependencies.
   */
  protected abstract titleService: Title;
  protected abstract translateService: TranslateService;
  protected location: Location;
  protected activedRoute: ActivatedRoute;

  /**
   * Subscriptions.
   */
  protected activedRouteSubscription$: Subscription;

  /**
   * The form type to render.
   * @type string
   */
  public formType: string = 'create';

  /**
   * Page title.
   * @type string
   */
  protected abstract title: string;

  /**
   * Language key access.
   * @type string
   */
  public langKey: string = '{{ $crud->entityNameSnakeCase() }}.';

  /**
   * {{ $crud->containerClass('abstract', false, true) }} constructor.
   */
  public constructor() { }

  /**
   * Set the document title.
   */
  protected setDocumentTitle() {
    this.translateService
      .get(this.langKey + this.title)
      .subscribe(val => this.titleService.setTitle(val));
  }

  /**
   * Set the form type based on the actual location path.
   */
  protected setFormType() {
    let url: string = this.location.path();
    
    if (url.search(/{{ $crud->slugEntityName() }}\/+[a-z0-9]+\/details+$/i) > -1)
      this.formType = "details";
    
    if (url.search(/{{ $crud->slugEntityName() }}\/+[a-z0-9]+\/edit+$/i) > -1)
      this.formType = "edit";
    
    if (url.search(/{{ $crud->slugEntityName() }}\/create$/i) > -1)
      this.formType = "create";
  }
}
