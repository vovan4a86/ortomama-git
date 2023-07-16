<span class="images_item" data-id="{{ $doc->id }}">
	<img class="img-polaroid" src="{{ $doc->getIconImage() }}"
		 style="cursor:pointer;">
	<a class="images_del" href="{{ route('admin.catalog.productDocDel', [$doc->id]) }}"
	   onclick="return productDocDel(this)">
		<span class="glyphicon glyphicon-trash"></span>
	</a>
		<a class="images_edit" href="{{ route('admin.catalog.productDocEdit', [$doc->id]) }}"
		   onclick="galleryItemEdit(this, event)"><span class="glyphicon glyphicon-edit"></span></a>
</span>
