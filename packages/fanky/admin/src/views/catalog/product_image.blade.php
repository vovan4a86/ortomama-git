<span class="images_item">
	<img class="img-polaroid" src="{{ strpos($image->image, '/') !== false ? $image->image : \Fanky\Admin\Models\Product::UPLOAD_CUSTOM_IMG . $image->image }}"
		 style="cursor:pointer;" data-image="{{ strpos($image->image, '/') !== false ? $image->image : \Fanky\Admin\Models\Product::UPLOAD_CUSTOM_IMG . $image->image }}"
		 onclick="popupImage('{{ strpos($image->image, '/') !== false ? $image->image : \Fanky\Admin\Models\Product::UPLOAD_CUSTOM_IMG . $image->image }}')">
	<a class="images_del" href="{{ route('admin.catalog.productImageDel', [$image->id]) }}"
	   onclick="return productImageDel(this)">
		<span class="glyphicon glyphicon-trash"></span>
	</a>
</span>
