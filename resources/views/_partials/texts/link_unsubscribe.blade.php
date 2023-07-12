@if(isset($unsubscribeToken))
    <span style="font-size:10px;color:darkgrey">
    {!! __('chaski::unsubscribe.line_1', ['unsubscribeToken'=> $unsubscribeToken]) !!}
    </span>
@endif
