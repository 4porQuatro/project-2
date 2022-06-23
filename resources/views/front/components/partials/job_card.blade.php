<a href="{{$item->path()}}">
    {{$item->subtitle}}
    {{$item->title}}
    <p>
        @foreach($item->categories->where('level', 2) as $category)
            {{$category->name}} @if(!$loop->last),@endif
        @endforeach
    </p>
    <img src="{{!empty($item->images) ? '/storage/'.$item->images[0]['path'] : ''}}" alt="{{!empty($item->images) ? $item->images[0]['alt_text'] : ''}}">
</a>
