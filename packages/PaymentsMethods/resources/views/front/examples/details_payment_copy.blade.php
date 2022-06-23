@php
    $payment_data['method'] = 'mb';
    $payment_data['data']['url'] = '';

    $payment_data['data']['entity'] = '23456';
    $payment_data['data']['reference'] = '123456789';
    $payment_data['data']['value'] = '15.00';
@endphp

@if($payment_data['method'] == 'cc')
<div class="flex justify-center items-center bg-lightorange w-full h-screen">
    <div class="bg-lightorange shadow-3xl h-3/6 w-4/12 flex justify-center items-center">
        <div class="h-1/2 w-10/12 grid content-between text-center">
            <div>
                <h2 class="text-3xl">Cartão de crédito</h2>
            </div>
            <div class="text-sm font-medium">
                <p>Efetue o pagamento através do terminal que abriu na nova aba.</p>
                <p>Se não abriu, aceda à partir <a href="{{$payment_data['data']['url']}}" target="_blank" class="underline"> daqui</a>.</p>
            </div>
            <div>
                <button class="uppercase w-9/12 px-4 py-2 border border-transparent text-sm font-medium text-white text-center bg-orange">Voltar para a homepage</button>
            </div>
        </div>
    </div>
</div>

@elseif($payment_data['method'] == 'mb')

<div class="flex justify-center items-center bg-lightorange w-full h-screen">
    <div class="bg-lightorange shadow-3xl h-3/6 w-4/12 flex justify-center items-center">
        <div class="h-5/6 w-10/12 grid content-between text-center">
            <div>
                <h2 class="text-3xl">Pagamento multibanco</h2>
            </div>
            <div class="uppercase text-sm font-medium">
                <p class="mb-3"><span class="text-orange">Entidade </span> <br> {{$payment_data['data']['entity']}}</p>
                <p class="mb-3"><span class="text-orange">Referência </span> <br> {{$payment_data['data']['reference']}}</p>
                <p class="mb-3"><span class="text-orange">Valor </span> <br> {{$payment_data['data']['value']}} €</p>
            </div>
            <div>
                <button class="uppercase w-9/12 px-4 py-2 border border-transparent text-sm font-medium text-white text-center bg-orange">Voltar para a homepage</button>
            </div>
        </div>
    </div>
</div>

@elseif($payment_data['method'] == 'mbw')
<div class="flex justify-center items-center bg-lightorange w-full h-screen">
    <div class="bg-lightorange shadow-3xl h-3/6 w-4/12 flex justify-center items-center">
        <div class="h-2/5 w-10/12 grid content-between text-center">
            <div>
                <h2 class="text-3xl">Mb Way</h2>
            </div>
            <div class="text-sm font-medium">
                <p>Abra a aplicação e confirme o pagamento</p>
            </div>
            <div>
                <button class="uppercase w-9/12 px-4 py-2 border border-transparent text-sm font-medium text-white text-center bg-orange">Voltar para a homepage</button>
            </div>
        </div>
    </div>
</div>

@elseif($payment_data['method'] == 'card_stripe')
    @if(request()->has('status') && request()->get('status') === 'success')
        <p>O seu pagamento foi efetuado com sucesso</p>

    @elseif(request()->has('status') && request()->get('status') === 'error')

        <p>Aconteceu um erro inesperado</p>
    @else
        <a href="{{$payment_data['url']}}" target="_blank"> Pagar</a>

    @endif
@endif
