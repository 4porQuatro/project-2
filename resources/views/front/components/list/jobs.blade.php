<div>
    @foreach($data->list->default as $item)
        @include('front.components.partials.job_card',[
             'item'=>$item
         ])
    @endforeach
</div>
