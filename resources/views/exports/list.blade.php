<table>
    <thead>
    <tr>
        <th width="400">URL</th>
    </tr>
    </thead>
    <tbody>
    @foreach($items as $item)
        <tr>
            <td style="text-align: left;">{{ $item }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
