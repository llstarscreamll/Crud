import { Location } from '@angular/common';
import { Component, OnInit, OnDestroy } from '@angular/core';
import { Title } from '@angular/platform-browser';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { go } from '@ngrx/router-store';
import { TranslateService } from '@ngx-translate/core';
import { Router, ActivatedRoute } from '@angular/router';

import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as appMessage from './../../../core/reducers/app-message.reducer';
import * as fromRoot from './../../../reducers';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../../reducers/{{ $gen->slugEntityName() }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../../actions/{{ $gen->slugEntityName() }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';
import { {{ $abstractClass = $gen->containerClass('abstract', false, true) }} } from './{{ str_replace('.ts', '', $gen->containerFile('abstract', false, true)) }}';

/**
 * {{ $gen->containerClass('form', false, true) }} Class.
 *
 * @author [name] <[<email address>]>
 */
{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('form', false, true)) }}',
  templateUrl: './{{ $gen->containerFile('form-html', false, true) }}'
})
export class {{ $gen->containerClass('form', false, true) }} extends {{ $abstractClass }} implements OnInit, OnDestroy {
  /**
   * Language key to page title.
   * @type string
   */
  protected title: string = 'form-page';
  
  /**
   * {{ ucfirst(str_replace('_', '', $gen->tableName)) }} form group.
   * @type FormGroup
   */
  public form: FormGroup;

  /**
   * Form type to render (create|update|details). Because some fields could not
   * be shown based on the form type.
   * @type string
   */
  public formType: string = 'create';

  /**
   * Flag that tell as if the form is ready to be shown or not.
   * @type boolean
   */
  public formConfigured: boolean = false;

  /**
   * {{ $gen->containerClass('form', false, true) }} constructor.
   */
  public constructor(
    protected store: Store<fromRoot.State>,
    protected titleService: Title,
    protected translateService: TranslateService,
    protected formModelParserService: FormModelParserService,
    protected location: Location,
    protected activedRoute: ActivatedRoute,
  ) { super(); }

  /**
   * The component is ready, this is called after the constructor and after the
   * first ngOnChanges(). This is invoked only once when the component is
   * instantiated.
   */
  public ngOnInit() {
    this.setDocumentTitle();
    this.setupStoreSelects();
    this.initForm();
    this.setupForm();
  }

  /**
   * Parse the form model to form group.
   */
  private setupForm() {
    this.formModelSubscription$ = this.formModel$
      .subscribe((model) => {
        if (model) {
          this.form = this.formModelParserService.toFormGroup(model);

          if (this.formType == 'details' || this.formType == 'edit') {
            this.patchForm();
          } else {
            this.formConfigured = true;
          }
        }
      });
  }

  /**
   * Patch the form group values with the selected item data.
   */
  private patchForm() {
    this.selectedItem$.subscribe(({{ $model = camel_case($gen->entityName()) }}) => {
      if ({{ $model }} != null && {{ $model }}.id && {{ $model }}.id.includes(this.id)) {
        this.form.patchValue({{ $model }});
        this.formConfigured = true;
      }
    });
  }

  /**
   * Hadle the form submition based on the actual form type.
   */
  public submitForm() {
    if (this.formType == 'create')
      this.store.dispatch(new {{ $actions }}.CreateAction(this.form.value));

    if (this.formType == 'edit')
      this.store.dispatch(new {{ $actions }}.UpdateAction(this.form.value));

    if (this.formType == 'details')
      this.store.dispatch(go(['{{ $gen->slugEntityName() }}', this.id, 'edit']));
  }

  /**
   * Clean the component canceling the background taks. This is called before the
   * component instance is funally destroyed.
   */
  public ngOnDestroy() {
    this.formModelSubscription$.unsubscribe();
    this.activedRouteSubscription$ ? this.activedRouteSubscription$.unsubscribe() : null;
  }
}
