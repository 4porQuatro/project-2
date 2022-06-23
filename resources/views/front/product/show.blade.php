<shopping-bag></shopping-bag>

<product-detail
    :prop_product="{{$result}}"
    :attributes="{{$result->attributes}}"
    :attributes_options="{{$result->attributesOptions}}"
    :default_variation="{{$result->defaultVariation}}"
></product-detail>
