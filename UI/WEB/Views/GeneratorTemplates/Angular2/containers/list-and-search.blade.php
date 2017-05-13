import { Location } from '@angular/common';
import { Component, OnInit } from '@angular/core';
import { TranslateService } from '@ngx-translate/core';
import { Title } from '@angular/platform-browser';
import { Router, ActivatedRoute } from '@angular/router';

import { {{ $abstractClass = $gen->containerClass('abstract', false, true) }}, SearchQuery } from './{{ str_replace('.ts', '', $gen->containerFile('abstract', false, true)) }}';

/**
 * {{ $gen->containerClass('list-and-search', $plural = true) }} Class.
 *
 * @author [name] <[<email address>]>
 */
{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('list-and-search', true)) }}',
  templateUrl: './{{ $gen->containerFile('list-and-search-html', true) }}',
})
export class {{ $gen->containerClass('list-and-search', $plural = true) }} extends {{ $abstractClass }} implements OnInit {
  /**
   * Page title.
   * @type string
   */
  protected title: string = 'module-name-plural';

  /**
   * Flag that tell as if the advanced search form should be shown or not.
   * @type boolean
   */
  public showAdvancedSearchForm: boolean = false;
  
  /**
   * {{ $gen->containerClass('list-and-search', $plural = true) }} constructor.
   */
  public constructor(
    protected location: Location,
    protected titleService: Title,
    protected translateService: TranslateService,
    protected activedRoute: ActivatedRoute,
  ) { super(); }

  /**
   * The component is ready, this is called after the constructor and after the
   * first ngOnChanges(). This is invoked only once when the component is
   * instantiated.
   */
  public ngOnInit() {
    this.setFormType();
    this.setDocumentTitle();
  }
}
