<table style="margin-left: auto;margin-right: auto;width: 100%">
    <thead >
    @foreach ($headerItems as $header)
        <td style="padding-left:10px;padding-right:10px;height:54px; font-size:20px;color:#FFFFFF;background-color:#9336B4;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif">
            {{$header}}
        </td>
    @endforeach
    </thead>
    <tbody>
    @foreach ($rows as $row)
        <tr>
        @foreach ($row as $item)
            <td style="padding-left:10px;padding-right:10px;height:20px; font-size:16px;color:#9336B4;font-family:helvetica, 'helvetica neue', arial, verdana, sans-serif">
                {{$item}}
            </td>
        @endforeach
        </tr>
    @endforeach
    </tbody>
</table>
