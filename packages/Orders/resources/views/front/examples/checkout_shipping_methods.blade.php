@php
    //Este componente só pode ser usado no checkout
    //Não pode ter a tag <form>

    $shipping_methods = $checkout->shippingMethods()->get();

    /**
    Quando o shipping_country é atualizado por exemplo para 5 deverá se fazer um request para obter os metodos de envios disponiveis e respetiva atualização dos preços atraves do url:
     Caminho: /api/shippment_methods/get?country_id=5
    A resposta será um json com o a seguinte estrutura:
   0 => array:11 [
    "id" => 1
    "name" => "eos"
    "default_price" => 10
    "default_free_order_price" => 500
    "priority" => "1"
    "active" => true
    "created_at" => "2022-01-11T12:26:59.000000Z"
    "updated_at" => "2022-01-11T12:26:59.000000Z"
    "price" => 20
    "free_order_price" => 1000
    "article" => null
  ]
 *
 * Onde Price é o preço atualizado para o envio em função do país, tamanho e peso da encomenda.
 * **/

]

    //
@endphp

<h2 style="font-weight: bold">shipping Methods</h2>
@foreach($shipping_methods as $shipping_method)
    <div>
        <label>{{$shipping_method->name}}</label>
        <input type="radio" name="shipping_method_id" value="{{$shipping_method->id}}">
    </div>
@endforeach

<script>

</script>
