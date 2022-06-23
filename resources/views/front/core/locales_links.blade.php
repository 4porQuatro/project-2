@foreach(config('translatable.front_locales') as $locale => $lang)
    <a href="/{{$locale}}">{{$lang}}</a>
@endforeach
