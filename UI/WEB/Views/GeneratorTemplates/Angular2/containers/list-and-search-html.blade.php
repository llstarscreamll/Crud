<app-sidebar-layout>
  <app-page-header>
    <div class="col-xs-12">
      <h1 translate>{{ '{{' }} langKey + 'module-name-plural' }}</h1>
    </div>
  </app-page-header>
  
  <app-page-content>
    <app-box>
      <app-box-body>
        
        <div class="row">
          <!-- buttons -->
          <div class="col-sm-6 col-md-8 m-b-md">
            <a [routerLink]="[ '/{{ $gen->slugEntityName() }}/create' ]" class="btn btn-primary">
              <i class="glyphicon glyphicon-plus"></i>
              <span translate>{{ '{{' }} langKey + 'create' }}</span>
            </a>
          </div>

          <!-- basic search -->
          <div class="col-sm-6 col-md-4 m-b-md">
            <{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('search-basic', false)) }}
              (filterBtnClick)="showAdvancedSearchForm = !showAdvancedSearchForm">
              </{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('search-basic', false)) }}>
          </div>

          <!-- search options modal -->
          <div *ngIf="showAdvancedSearchForm"
            bsModal
            #staticModal="bs-modal"
            [config]="{ show: true }"
            (onHidden)="showAdvancedSearchForm = !showAdvancedSearchForm"
            class="modal fade"
            tabindex="-1"
            role="dialog"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
              <div class="modal-content">
                
                <div class="modal-header">
                  <h4 class="modal-title pull-left" translate>{{ '{{ ' }}langKey + 'advanced_search.title' }}</h4>
                  <button type="button" class="close pull-right" aria-label="Close" (click)="staticModal.hide()">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                
                <div class="modal-body">
                  <{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('search-advanced', false)) }}
                    class="advanced-search-form"
                    (search)="staticModal.hide()"
                    [debug]="false">
                  </{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('search-advanced', false)) }}>
                </div>

              </div>
            </div>
          </div>
        </div>

        <{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}>
        </{{ str_replace(['.ts', '.'], ['', '-'], $gen->componentFile('table', $plural = true)) }}>
      </app-box-body>
    </app-box>
  </app-page-content>
</app-sidebar-layout>
