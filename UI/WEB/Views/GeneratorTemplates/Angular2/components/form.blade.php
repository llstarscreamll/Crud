import { Component, EventEmitter, Input, OnDestroy, OnInit, Output } from '@angular/core';
import { FormGroup } from '@angular/forms';
import { Store } from '@ngrx/store';
import { TranslateService } from '@ngx-translate/core';
import { Router, ActivatedRoute } from '@angular/router';
import { go } from '@ngrx/router-store';

import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as fromRoot from './../../../reducers';
import * as {{ $reducer = camel_case($crud->entityName()).'Reducer' }} from './../../reducers/{{ $crud->slugEntityName() }}.reducer';
import * as {{ $actions = camel_case($crud->entityName()).'Actions' }} from './../../actions/{{ $crud->slugEntityName() }}.actions';
import { {{ $entitySin = $crud->entityName() }} } from './../../models/{{ camel_case($entitySin) }}';
import { {{ $abstractClass = $crud->componentClass('abstract', false, true) }} } from './{{ str_replace('.ts', '', $crud->componentFile('abstract', false, true)) }}';

/**
 * {{ $crud->componentClass('form', $plural = false) }} Class.
 *
 * @author [name] <[<email address>]>
 */
{{ '@' }}Component({
  selector: '{{ $selector = str_replace(['.ts', '.'], ['', '-'], $crud->componentFile('form', false)) }}',
  templateUrl: './{{ $crud->componentFile('form-html', false) }}',
  exportAs: '{{ str_replace('-component', '', $selector) }}',
})
export class {{ $crud->componentClass('form', $plural = false) }} extends {{ $abstractClass }} implements OnInit, OnDestroy {
  /**
   * {{ ucfirst(str_replace('_', ' ', $crud->tableName)) }} form group.
   * @type FormGroup
   */
  public form: FormGroup;

  /**
   * Form type to render (create|update|details). Because some fields could not
   * be shown based on the form type.
   * @type string
   */
  @Input()
  public formType: string = 'create';

  @Input()
  public selectedItemId: string;

  /**
   * Call redirect action from ngrx/router-store in create/update effects?
   */
  @Input()
  public redirect: boolean = true;

  /**
   * {{ $crud->componentClass('form', $plural = false) }} constructor.
   */
  public constructor(
    protected store: Store<fromRoot.State>,
    protected activedRoute: ActivatedRoute,
    protected translateService: TranslateService,
    protected formModelParserService: FormModelParserService,
  ) { super(); }

  /**
   * The component is ready, this is called after the constructor and after the
   * first ngOnChanges(). This is invoked only once when the component is
   * instantiated.
   */
  public ngOnInit() {
    this.setupStoreSelects();
    // if form type is details|update, then download the {{ $crud->entityName() }} data from API by the given id
    this.loadSelectedItem();
    this.initForm();
    this.setupFormData();
    this.setupFormModel();
  }

  /**
   * It's all the form stuff ready to be shown?
   */
  get ready(): boolean {
    if (this.form && this.formReady && this.formModelReady && this.formDataReady && this.selectedItemReady) {
      return true;
    }
    
    return false;
  }

  /**
   * Parse the form model to form group.
   */
  private setupFormModel() {
    this.formModelSubscription$ = this.formModel$
      .subscribe((model) => {
        if (model) {
          this.form = this.formModelParserService.toFormGroup(model, this.formType);
          this.patchForm();
          this.formModelReady = true;
        }
      });
  }

  /**
   * Patch the form group values with the selected item data.
   */
  private patchForm() {
    if (this.formType == 'details' || this.formType == 'edit') {
      this.selectedItemSubscription$ = this.selectedItem$
        .subscribe(({{ $model = camel_case($crud->entityName()) }}) => {
          if ({{ $model }} != null && {{ $model }}.id && {{ $model }}.id == this.selectedItemId) {
            this.form.patchValue({{ $model }});
            this.formReady = true;
            this.selectedItemReady = true;
          }
        });
      } else {
        this.formReady = true;
        this.selectedItemReady = true;
      }
  }

  /**
   * Hadle the form submition based on the actual form type.
   */
  public submitForm() {
    let payload = { item: this.form.value, redirect: this.redirect };

    if (this.formType == 'create') {
      this.store.dispatch(new {{ $actions }}.CreateAction(payload));
    }

    if (this.formType == 'edit') {
      this.store.dispatch(new {{ $actions }}.UpdateAction({ ...payload, id: this.selectedItemId }));
    }

    if (this.formType == 'details') {
      this.store.dispatch(go(['{{ $crud->slugEntityName() }}', this.selectedItemId, 'edit']));
      return;
    }

    this.form.markAsPristine();
    this.form.markAsUntouched();
  }

  /**
   * Clean the component canceling the background taks. This is called before the
   * component instance is funally destroyed.
   */
  public ngOnDestroy() {
    super.ngOnDestroy();
  }
}
