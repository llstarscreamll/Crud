{{-- heading --}}
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-xs-12">
        <h2>
            <a href="{{route('<?=$gen->route()?>.index')}}">{{trans('<?=$gen->getLangAccess()?>/views.module.name')}}</a>
            <small>{{ isset($module_section) ? $module_section : null }}</small>
        </h2>
    </div>
</div>
{{-- /heading --}}