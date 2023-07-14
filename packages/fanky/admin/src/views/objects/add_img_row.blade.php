<tr data-id="{{ $img->id }}">
    <td width="40"><i class="fa fa-ellipsis-v"></i><i class="fa fa-ellipsis-v"></i></td>
    <td width="100"><img alt="" src="{{ $img->thumb(1) }}"></td>
    <td width="360">{{ $img->name }}</td>
{{--    <td><a class="glyphicon glyphicon-edit" href="{{ route('admin.projects.edit', [$item->id]) }}" style="font-size:20px; color:orange;"></a></td>--}}
    <td>
        <a class="glyphicon glyphicon-trash" href="{{ route('admin.projects.del_img', [$img->id]) }}"
           style="font-size:20px; color:red;" onclick="delImg(this, event)"></a>
    </td>
</tr>
