@php
//Este componente só pode ser usar no cart
@endphp

<div>
    @if(count($cart['content']))

    @else
        <h2 style="font-size: 20px; font-weight: bold">
            O seu carrinho de compras está vazio
        </h2>
    @endif

</div>
