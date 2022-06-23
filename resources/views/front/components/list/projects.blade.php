@foreach($data->list->default as $item)
    <div>
        <p>{{$item->title}}</p>
        <p>{{$item->subtitle}}</p>
        <img src="{{!empty($item->images) ? '/storage/'.$item->images[0]['path'] : ''}}" alt="{{!empty($item->images) ? $item->images[0]['alt_text'] : ''}}">
    </div>
@endforeach
