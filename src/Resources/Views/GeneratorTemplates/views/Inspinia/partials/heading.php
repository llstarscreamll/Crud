{{--
    ****************************************************************************
    Heading de las Vistas.
    ____________________________________________________________________________
    Muestra el header utilizado en las vistas index, create, show y edit.
    Opcionalmente se puede mostrar un texto junto al título de la página dentro
    de un tag <small> enviando el valor por medio de una variable que se llame
    $small_title.
    ****************************************************************************

    <?= $gen->getViewCopyRightDocBlock() ?>
    
    ****************************************************************************
--}}

{{-- heading --}}
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-xs-12">
        <h2>
            <a href="{{route('<?=$gen->route()?>.index')}}">{{trans('<?=$gen->getLangAccess()?>/views.module.name')}}</a>
            <small>{{ isset($small_title) ? $small_title : null }}</small>
        </h2>
    </div>
</div>
{{-- /heading --}}