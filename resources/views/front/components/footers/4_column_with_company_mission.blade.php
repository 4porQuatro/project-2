<footer class="bg-white" aria-labelledby="footer-heading">

  <h2 id="footer-heading" class="sr-only">Footer</h2>
  <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8">

      <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900"> PT </a>|
      <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900"> EN </a>|
      <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900"> ES </a>

    <div class="xl:grid xl:grid-cols-3 xl:gap-8">
      <div class="space-y-8 xl:col-span-1">
        @if(!empty($data->image->default) && isset($data->image->default[0]))
            <img class="h-10"
                src="{{$data->image->default[0]['path']}}"
                alt="{{$data->image->default[0]['alt_text']}}"
            >
        @endif
        <p class="text-gray-500 text-base">{!! $data->text->default !!}</p>
        <div class="flex space-x-6">
            @foreach($data->article_social->default as $article)
                <a href="{{$article->link}}" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">{{$article->title}}</span>
                    @if(!empty($article->images) && isset($article->images[0]))
                        <img class="h-6 w-6" src="/storage/{{$article->images[0]['path']}}">
                    @endif
                </a>
            @endforeach
        </div>
      </div>
      <div class="mt-12 grid grid-cols-2 gap-8 xl:mt-0 xl:col-span-2">
        <div class="md:grid md:grid-cols-2 md:gap-8">
          <div>
{{--            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">{{$data->text_1->default}}</h3>--}}
            <ul role="list" class="mt-4 space-y-4">
                @foreach($data->menu_1->default->items as $item)
                    <li>
                        <a href="{{$item->path}}" class="text-base text-gray-500 hover:text-gray-900">{{$item->name}}</a>
                    </li>
                @endforeach
            </ul>
          </div>
          <div class="mt-12 md:mt-0">
{{--            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">{{$data->text_2->default}}</h3>--}}
            <ul role="list" class="mt-4 space-y-4">
                @foreach($data->menu_2->default->items as $item)
                    <li>
                        <a href="{{$item->path}}" class="text-base text-gray-500 hover:text-gray-900">{{$item->name}}</a>
                    </li>
                @endforeach
            </ul>
          </div>
        </div>
        <div class="md:grid md:grid-cols-2 md:gap-8">
          <div>
{{--            <h3 class="text-sm font-semibold text-gray-400 tracking-wider uppercase">{{$data->text_3->default}}</h3>--}}
            <ul role="list" class="mt-4 space-y-4">
                @foreach($data->menu_3->default->items as $item)
                    <li>
                        <a href="{{$item->path}}" class="text-base text-gray-500 hover:text-gray-900">{{$item->name}}</a>
                    </li>
                @endforeach
            </ul>
          </div>

        </div>
      </div>
    </div>
  </div>
</footer>
