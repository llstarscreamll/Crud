/* tslint:disable:no-unused-variable */
import { async, ComponentFixture, fakeAsync, TestBed, inject, getTestBed, tick } from '@angular/core/testing';
import { RouterTestingModule } from '@angular/router/testing';
import { Http, HttpModule, BaseRequestOptions, Response, ResponseOptions } from '@angular/http';
import { TranslateModule, TranslateService } from '@ngx-translate/core';
import { MockBackend, MockConnection } from '@angular/http/testing';
import { Observable } from 'rxjs/Observable';
import { Store } from '@ngrx/store';
import { Router, ActivatedRoute } from '@angular/router';

import * as fromRoot from './../../../reducers';
import { DynamicFormModule } from './../../../dynamic-form/dynamic-form.module';
import { FormModelParserService } from './../../../dynamic-form/services/form-model-parser.service';

import { {{ $cmpClass = $gen->componentClass('search-advanced', $plural = false) }} } from './{{ str_replace('.ts', '', $gen->componentFile('search-advanced', false)) }}';
import { {{ $gen->getLanguageKey(true) }} } from './../../translations/{{ $gen->getLanguageKey() }}';
import { {{ $service = $gen->entityName().'Service' }} } from './../../services/{{ $gen->slugEntityName() }}.service';
import { {{ $model = $gen->entityName() }} } from './../../models/{{ camel_case($gen->entityName()) }}';
import * as utils from './../../utils/{{ $gen->slugEntityName() }}-testing.util';

/**
 * {{ $gen->componentClass('search-advanced', $plural = false) }} Tests.
 *
 * @author [name] <[<email address>]>
 */
describe('{{ $cmpClass }}', () => {
  let fixture: ComponentFixture<{{ $cmpClass }}>;
  let component: {{ $cmpClass }};
  let testModel: {{ $gen->entityName() }} = utils.{{ $gen->entityName() }}One;
  let reactiveForm;
  let mockBackend: MockBackend;
  let store: Store<fromRoot.State>;
  let service: {{ $gen->entityName() }}Service;
  let http: Http;
  let router: Router;

  beforeEach(async(() => {
    TestBed.configureTestingModule({
      declarations: [{{ $cmpClass }}],
      imports: [
        utils.IMPORTS
      ],
      providers: [
        utils.PROVIDERS
      ]
    }).compileComponents();

    store = getTestBed().get(Store);
    router = getTestBed().get(Router);
    http = getTestBed().get(Http);
    service = getTestBed().get({{ $gen->entityName() }}Service);

    mockBackend = getTestBed().get(MockBackend);
    utils.setupMockBackend(mockBackend);

    fixture = getTestBed().createComponent({{ $cmpClass }});
    component = fixture.componentInstance;
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

  it('should have certain elements', fakeAsync(() => {
    fixture.detectChanges();
    tick();

    let html = fixture.nativeElement;

    // should have app-alerts element
    expect(html.querySelector('app-alerts')).not.toBeNull();

    // should have search columns/options
@foreach ($fields as $field)
@if (!$field->hidden)
    expect(html.querySelector('tabset tab:first-child [name=filter][value="{{ $gen->tableName }}.{{ $field->name }}"]')).not.toBeNull();
@endif
@endforeach


    // should have search fields
@foreach ($fields as $field)
@if (!$field->hidden && in_array($field->type, ['datetime', 'timestamp']))
    expect(html.querySelector('tabset tab:nth-child(2) [name={{ $field->name }}_from]')).not.toBeNull('{{ $field->name }}_from field');
    expect(html.querySelector('tabset tab:nth-child(2) [name={{ $field->name }}_to]')).not.toBeNull('{{ $field->name }}_to field');
@else
    expect(html.querySelector('tabset tab:nth-child(2) [name={{ $field->name }}]')).not.toBeNull('{{ $field->name }} field');
@endif
@endforeach

    // should have submit btn
    expect(html.querySelector('button.btn.btn-lg.btn-block')).not.toBeNull();
  }));

  it('should make certains {{ $gen->entityName() }}Service calls on search form init', fakeAsync(() => {
    spyOn(service, 'getFormModel').and.returnValue(Observable.from([{}]));
    spyOn(service, 'getFormData').and.returnValue(Observable.from([{}]));

    fixture.detectChanges();
    tick();

    // should make form model/data api service calls
    expect(service.getFormModel).toHaveBeenCalled();
    expect(service.getFormData).toHaveBeenCalled();
  }));

  it('should make {{ $gen->entityName() }}Service load call on form submission', fakeAsync(() => {
    spyOn(service, 'load').and.returnValue(Observable.from([{}]));

    fixture.detectChanges();
    tick();

    // fill input an trigger event to make reactiveForm dirty and touched
    fixture.nativeElement.querySelector('[name=id]').value = testModel.id;
    fixture.nativeElement.querySelector('[name=id]').dispatchEvent(new Event('input'));

    fixture.detectChanges();
    tick();

    // click button to submit form
    fixture.nativeElement.querySelector('form button.btn.btn-lg').click();

    fixture.detectChanges();
    tick();

    expect(component.form.get('search').get('id').value).toBe(testModel.id);
    expect(fixture.nativeElement.querySelector('[name=id]').value).toContain(testModel.id);
    expect(service.load).toHaveBeenCalled();
  }));
});
