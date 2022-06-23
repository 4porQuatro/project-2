<h1>{{$data->title->default}}</h1>
<h2>{{$data->subtitle->default}}</h2>

<img src="{{!empty($data->image->default) ? $data->image->default[0]['path'] : ''}}" alt="{{!empty($data->image->default) ? $data->image->default[0]['alt_text'] : ''}}">
<ul>
@foreach($data->list->default as $item)
    <li>{{$item}}</li>
@endforeach
</ul>
