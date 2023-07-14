<form action="{{ route('admin.objects.imageDataSave', [$image->id]) }}" onsubmit="galleryImageDataSave(this, event)" style="width:600px;">
    <label for="gallery-image">Название</label>
    <input id="gallery-image" class="form-control" type="text" name="name" value="{{ $image->name }}">
    <button class="btn btn-primary" style="margin-top: 20px;" type="submit">Сохранить</button>
</form>
<script>
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        radioClass: 'iradio_minimal-blue'
    });
</script>
