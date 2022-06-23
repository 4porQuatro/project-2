<shopping-bag></shopping-bag>

<div style="padding: 20px">
    <h1>Listagem produtos</h1>
    <table class="tg" width="100%">
        <thead>
        <tr>
            <th class="tg-0pky">Produto</th>
            <th class="tg-0lax">Preço</th>
            <th class="tg-0lax">Detalhes</th>
            <th class="tg-0lax">Opções</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data->products->default as $product)
            <tr>
                <td class="tg-0lax"><a href="{{$product->path}}">{{$product->id}}. {{$product->title}}</a></td>
                <td class="tg-0lax">{{$product->price}}</td>
                <td class="tg-0lax">

                </td>
                <td class="tg-0lax"></td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
