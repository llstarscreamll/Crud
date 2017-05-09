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
  templateUrl: './{{ $gen->containerFile('form-html', false, true) }}',
  styleUrls: ['./{{ $gen->containerFile('form-css', false, true) }}']
})
export class {{ $gen->containerClass('form', false, true) }} extends {{ $abstractClass }} implements OnInit, OnDestroy {  
  protected title: string = 'form-page';
  public formType: string = 'create';
  public {{ $form = camel_case($gen->entityName()).'Form' }}: FormGroup;
  public formConfigured: boolean = false;

  public constructor(
    protected store: Store<fromRoot.State>,
    protected titleService: Title,
    protected translateService: TranslateService,
    protected formModelParserService: FormModelParserService,
    protected location: Location,
    protected activedRoute: ActivatedRoute,
  ) { super(); }

  public ngOnInit() {
    this.setDocumentTitle();
    this.setupStoreSelects();
    this.initForm();
    this.setupForm();
  }

  private setupForm() {
    this.formModelSubscription$ = this.{{ $formModel = camel_case($gen->entityName()).'FormModel$' }}
      .subscribe((model) => {
        if (model) {
          this.{{ $form }} = this.formModelParserService.toFormGroup(model);

          if (this.formType == 'details' || this.formType == 'edit') {
            this.patchForm();
          } else {
            this.formConfigured = true;
          }
        }
      });
  }

  private patchForm() {
    this.{{ $selected = 'selected'.$gen->entityName().'$' }}.subscribe(({{ $model = camel_case($gen->entityName()) }}) => {
      if ({{ $model }} != null && {{ $model }}.id && {{ $model }}.id.includes(this.id)) {
        this.{{ $form }}.patchValue({{ $model }});
        this.formConfigured = true;
      }
    });
  }

  public submit{{ $gen->entityName() }}Form() {
    if (this.formType == 'create')
      this.store.dispatch(new {{ $actions }}.CreateAction(this.{{ $form }}.value));

    if (this.formType == 'edit')
      this.store.dispatch(new {{ $actions }}.UpdateAction(this.{{ $form }}.value));

    if (this.formType == 'details')
      this.store.dispatch(go(['{{ $gen->slugEntityName() }}', this.id, 'edit']));
  }

  public ngOnDestroy() {
    this.formModelSubscription$.unsubscribe();
    this.activedRouteSubscription$ ? this.activedRouteSubscription$.unsubscribe() : null;
  }
}
