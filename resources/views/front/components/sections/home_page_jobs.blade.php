<h1>{{$data->title->default}}</h1>
<h2>{{$data->subtitle->default}}</h2>

@foreach($data->list->default as $item)
   @include('front.components.partials.job_card',[
        'item'=>$item
    ])
@endforeach

@if(!empty($data->btn_link->default))
    <a href="{{$data->btn_link->default}}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">{{$data->btn_text->default}}</a>
@endif
