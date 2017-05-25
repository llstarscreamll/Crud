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

import * as bookActions from './../../actions/book.actions';
import { Book } from './../../models/book';
import { BookPagination } from './../../models/bookPagination';

export interface SearchQuery {
  filter: string[];
  include: {};
  orderBy: string;
  sortedBy: string;
  page: number;
}

/**
 * BookAbstractPage Abstract Class.
 *
 * @author  [name] <[<email address>]>
 */
export abstract class BookAbstractPage {
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
   * @type  string
   */
  public formType: string = 'create';

  /**
   * Page title.
   * @type  string
   */
  protected abstract title: string;

  /**
   * Language key access.
   * @type  string
   */
  public langKey: string = 'BOOK.';

  /**
   * BookAbstractPage constructor.
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
    
    if (url.search(/book\/+[a-z0-9]+\/details+$/i) > -1)
      this.formType = "details";
    
    if (url.search(/book\/+[a-z0-9]+\/edit+$/i) > -1)
      this.formType = "edit";
    
    if (url.search(/book\/create$/i) > -1)
      this.formType = "create";
  }
}
