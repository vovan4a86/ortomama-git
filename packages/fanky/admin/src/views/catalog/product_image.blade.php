<span class="images_item" data-id="{{ $image->id }}">
	<img class="img-polaroid" src="{{ $image->thumb(3) }}"
		 style="cursor:pointer;" data-image="{{ $image->thumb(3) }}"
		 onclick="popupImage('{{ $image->image_src }}')">
	<a class="images_del" href="{{ route('admin.catalog.productImageDel', [$image->id]) }}"
	   onclick="return productImageDel(this)">
		<span class="glyphicon glyphicon-trash"></span>
	</a>
</span>
