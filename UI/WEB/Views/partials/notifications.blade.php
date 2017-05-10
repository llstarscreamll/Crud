{{-- Notification Messages --}}
<div id="system-notifications" class="row">

    <div class="col-sm-8 col-sm-offset-2">
        
        {{--
            Validation error notification.
        --}}
        @if (isset($errors) && !$errors->isEmpty())
            <div class="alert alert-danger alert-dismissible margin-top-10" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <strong>Error!!</strong>
                <p>Hay problemas con la información suministrada.</p>

                @if (explode('@', Request::route()->getActionName())[1] == 'index')
                    @foreach($errors->all() as $error)
                        <ul>
                            <li>{{ $error }}</li>
                        </ul>
                    @endforeach
                @endif
            </div>
        @endif

        @include('theme::.Inspinia.partials.notifications.success')
        @include('theme::.Inspinia.partials.notifications.warning')
        @include('theme::.Inspinia.partials.notifications.error')
    </div>
</div>