import { Component, OnInit } from '@angular/core';
import { Store } from '@ngrx/store';
import { Observable } from 'rxjs/Observable';
import * as _ from 'lodash';

import * as fromRoot from './../../core/reducers';
import * as {{ $reducer = camel_case($gen->entityName()).'Reducer' }} from './../reducers/{{ camel_case($gen->entityName()) }}.reducer';
import * as {{ $actions = camel_case($gen->entityName()).'Actions' }} from './../actions/{{ camel_case($gen->entityName()) }}.actions';
import { {{ $entitySin = $gen->entityName() }} } from './../models/{{ camel_case($entitySin) }}';

{{ '@' }}Component({
  selector: '{{ str_replace(['.ts', '.'], ['', '-'], $gen->containerFile('list-and-search', true)) }}',
  templateUrl: './{{ $gen->containerFile('list-and-search-html', true) }}',
  styleUrls: ['./{{ $gen->containerFile('list-and-search-css', true) }}']
})
export class {{ $gen->containerClass('list-and-search', $plural = true) }} implements OnInit {
	
	public {{ $state = camel_case($gen->entityName()).'State$' }}: Observable<{{ $reducer.'.State' }}>;

  public queryData: Object = {
    filter: [
@foreach ($fields as $field)
@if ($field->on_index_table && !$field->hidden)
      '{{ $field->name }}',
@endif
@endforeach
    ],
    include: {
@foreach ($fields as $field)
@if ($field->namespace && !$field->hidden)
      '{{ $field->name }}': '{{  $gen->relationNameFromField($field)  }}',
@endif
@endforeach
    },
    orderBy: "created_at",
    sortedBy: "asc"
  };

  public constructor(private store: Store<fromRoot.State>) { }

  public ngOnInit() {
  	this.{{ $state }} = this.store.select(fromRoot.get{{ $gen->entityName() }}State);
  	this.onSearch();
  }

  public onSearch(data: Object = {})
  {
    this.queryData = _.merge({}, this.queryData, data);
    this.store.dispatch(new bookActions.LoadAction(this.queryData));
  }
}
