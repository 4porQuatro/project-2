@php
//Este componente só pode ser usado no checkout
//Não pode ter a tag <form>

/* Link para atualizar regiões para determinado país:
    * /countries/regions/{identificador_country}
 *
 *
 * No caso de o utilizador se encontrar autenticado poderá ser necessário usar moradas que ele tenha guardado anteriorimente na sua area reservada.
 * As mesmas poderão ser obtidads atrave de um get request para o seguinte endpoint:
 * address/get/billing?prefix_columns=1
 *
 *
 */
$shipping_form = $checkout->billingForm();



@endphp

<h2 style="font-weight: bold">Billing form</h2>
@foreach($shipping_form->fields as $field)
    <div>
        <label>{{$field->label}}</label>
        @if($field->type !== 'select')
        <input type="{{$field->type}}" name="{{$field->name}}">
        @endif
        @if($field->type == 'select')
        <select name="{{$field->name}}">
            @if($field->name == 'billing_country')
                @foreach($checkout->avaliableCountries() as $country)
                    <option value="{{$country->id}}">{{$country->name}}</option>
                @endforeach
            @endif
            @if($field->name == 'billing_region')
                @foreach($checkout->avaliableRegions() as $region)
                        <option value="{{$region->id}}">{{$region->name}}</option>
                @endforeach
            @endif
        </select>
        @endif
    </div>
@endforeach

<script>

</script>
