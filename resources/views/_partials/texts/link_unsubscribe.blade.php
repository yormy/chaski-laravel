@if(isset($unsubscribeLink))
    <span style="font-size:10px;color:darkgrey">
    {!! __('chaski::unsubscribe.line_1', ['unsubscribeLink'=> $unsubscribeLink]) !!}
    </span>
@endif
