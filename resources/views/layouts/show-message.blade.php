<div id="js-show-message-wrapper">
    <div id="js-show-message-wrapper_msgbox">
        @if(Session::has('error'))
        <div class="alert alert-danger">
            <a class="close" data-dismiss="alert">×</a>
            <i class="icon-exclamation"></i>
            <p>{!!Session::get('error')!!}</p>
        </div>
        @endif
        @if(Session::has('success'))
        <div class="alert alert-success">
            <a class="close" data-dismiss="alert">×</a>
            <i class="icon-check"></i>
            <p>{!!Session::get('success')!!}</p>
        </div>
        @endif
        @if(Session::has('info'))
        <div class="alert alert-info">
            <a class="close" data-dismiss="alert">×</a>
            <i class="icon-check"></i>
            <p>{!!Session::get('info')!!}</p>
        </div>
        @endif
    </div>

</div>