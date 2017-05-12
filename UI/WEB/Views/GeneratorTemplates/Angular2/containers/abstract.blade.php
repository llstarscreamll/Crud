import { Location } from '@angular/common';
import { Title } from '@angular/platform-browser';
import { Router, ActivatedRoute } from '@angular/router';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';
import { Observable } from 'rxjs/Observable';
import { Subscription } from 'rxjs/Subscription';
import swal from 'sweetalert2';

import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as appMessage from './../../../core/reducers/app-message.reducer';
import * as fromRoot from './../../../reducers';

import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';
import { {{ $pagModel = $entitySin.'Pagination' }} } from './../../models/{{ camel_case($entitySin) }}Pagination';

export interface SearchQuery {
  filter: string[];
  include: {};
  orderBy: string;
  sortedBy: string;
  page: number;
}

/**
 * {{ $gen->containerClass('abstract', false, true) }} Abstract Class.
 *
 * @author [name] <[<email address>]>
 */
export abstract class {{ $gen->containerClass('abstract', false, true) }} {
  /**
   * Dependencies.
   */
  protected abstract titleService: Title;
  protected abstract translateService: TranslateService;
  protected location: Location;
  protected activedRoute: ActivatedRoute;

  protected activedRouteSubscription$: Subscription;




  public formType: string = 'search';




  /**
   * Page title.
   * @type string
   */
  protected abstract title: string;

  public langKey: string = '{{ $gen->entityNameSnakeCase() }}.';

  /**
   * {{ $gen->containerClass('abstract', false, true) }} constructor.
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
    
    if (url.search(/{{ $gen->slugEntityName() }}\/+[a-z0-9]+\/details+$/i) > -1)
      this.formType = "details";
    
    if (url.search(/{{ $gen->slugEntityName() }}\/+[a-z0-9]+\/edit+$/i) > -1)
      this.formType = "edit";
    
    if (url.search(/{{ $gen->slugEntityName() }}\/create$/i) > -1)
      this.formType = "create";
  }
}
