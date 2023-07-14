@if ($product->id)
    @if($product->chars()->get())
        <div id="char-list">
            @foreach($product->chars()->get() as $ch)
                @include('admin::catalog.tabs.char_row', compact('ch'))
            @endforeach
        </div>
    @endif

    <hr>
    <h3>Добавление новой характеристики:</h3>
    <div style="display: flex; column-gap: 10px;">
        <input type="text" name="new_char_name" class="form-control"
               style="max-width: 250px;">
        <input type="text" name="new_char_value" class="form-control"
               style="max-width: 250px;">
        <button class="btn btn-success btn-flat btn-add-char" onclick="addProductChar({{ $product->id }}, event)">
            <span class="glyphicon">Добавить</span>
        </button>
    </div>

@else
    <p class="text-yellow">Добавить характеристики можно будет после сохранения товара!</p>
@endif
<hr>
