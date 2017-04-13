/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, inject, getTestBed, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { TranslateModule, TranslateService } from '@ngx-translate/core';

import * as fromRoot from './../../../reducers';
import { DynamicFormModule } from './../../../dynamic-form/dynamic-form.module';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';
import * as utils from './../../utils/{{ $gen->slugEntityName() }}-testing.util';
import { {{ $gen->getLanguageKey(true) }} } from './../../translations/{{ $gen->getLanguageKey() }}';

import { {{ $cmpClass = $gen->componentClass('form-fields', $plural = false) }} } from './{{ str_replace('.ts', '', $gen->componentFile('form-fields', false)) }}';

describe('{{ $cmpClass }}', () => {
  let fixture: ComponentFixture<{{ $cmpClass }}>;
  let component: {{ $cmpClass }}
  let formModel;
  let reactiveForm;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [{{ $cmpClass }}],
      imports: [
        RouterTestingModule,
        HttpModule,
        TranslateModule.forRoot(),
        DynamicFormModule,
      ],
      providers: []
    }).compileComponents();

    fixture = getTestBed().createComponent({{ $cmpClass }});
    component = fixture.componentInstance;
  }));

  beforeEach(inject([FormModelParserService], (fmps: FormModelParserService) => {
    formModel = fmps.parse(utils.FORM_MODEL);
    reactiveForm = fmps.toFormGroup(formModel);
    
    component.{{ $form = camel_case($gen->entityName()).'Form' }} = reactiveForm;
    component.{{ $formModel = camel_case($gen->entityName()).'FormModel' }} = formModel;
    component.{{ $formData = camel_case($gen->entityName()).'FormData' }} = {};
    component.formType = 'create';
    component.errors = {};
  }));

  beforeEach(inject([TranslateService], (translateService: TranslateService) => {
    translateService.setTranslation('es', ES, true);
    translateService.setDefaultLang('es');
    translateService.use('es');
  }));

  it('should create', () => {
    fixture.detectChanges();
    expect(component).toBeTruthy();
  });

  it('should have certain fields on create form', () => {
    fixture.detectChanges();

@foreach ($fields as $field)
@if ($field->on_create_form)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]')).not.toBeNull('{{ $field->name }} field');
@endif
@endforeach
  });

  it('should have certain disabled fields on details form', () => {
    component.formType = 'details';
    fixture.detectChanges();

@foreach ($fields as $field)
@if (!$field->hidden)
    expect(fixture.nativeElement.querySelector('[name={{ $field->name }}]:disabled')).not.toBeNull('{{ $field->name }} field');
@endif
@endforeach
  });
});
