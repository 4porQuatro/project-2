@php
    $payment_data = $model->getPaymentData();
@endphp
@if($payment_data['method'] == 'cc')
    <h2>Cartão de crédito
        </h2>
            <p>Efetue o pagamento através do terminal que abriu na nova aba.</p>
            <p>Se não abriu, aceda à partir <a href="{{$payment_data['data']['url']}}" target="_blank"> daqui</a>
@elseif($payment_data['method'] == 'mb')
<h2>Pagamento multibanco
    </h2>
        <p><strong>Entidade: </strong> {{$payment_data['data']['entity']}}</p>
        <p><strong>Referência: </strong> {{$payment_data['data']['reference']}}</p>
        <p><strong>Valor: </strong> {{$payment_data['data']['value']}}</p>

@elseif($payment_data['method'] == 'mbw')
    <h2>Mbway
        </h2>
            <p>Abra a aplicação e confirme o pagamento</p>

@elseif($payment_data['method'] == 'card_stripe')
    @if(request()->has('status') && request()->get('status') === 'success')
        <p>O seu pagamento foi efetuado com sucesso</p>

    @elseif(request()->has('status') && request()->get('status') === 'error')

        <p>Aconteceu um erro inesperado</p>
    @else
        <a href="{{$payment_data['url']}}" target="_blank"> Pagar</a>

    @endif
@endif
