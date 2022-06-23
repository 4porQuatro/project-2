<header class="bg-indigo-600">
  <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Top">
    <div class="w-full py-6 flex items-center justify-between border-b border-indigo-500 lg:border-none">
      <div class="flex items-center">
        <a href="#">
            @if(!empty($data->image_logo->default) && isset($data->image_logo->default[0]))
                <img class="h-10 w-auto"
                    src="{{$data->image_logo->default[0]['path']}}"
                    alt="{{$data->image_logo->default[0]['alt_text']}}"
                >
            @endif
        </a>
        <div class="hidden ml-10 space-x-8 lg:block">
            @foreach($data->menu->default->items as $item)
                <a href="{{$item->path}}" class="text-base font-medium text-white hover:text-indigo-50">{{$item->name}}</a>
            @endforeach
        </div>
      </div>
      <div class="ml-10 space-x-4">
            @if(!empty($data->button_title_1->default))
            <a
                href="{{$data->button_link_1->default}}" class="inline-block bg-indigo-500 py-2 px-4 border border-transparent rounded-md text-base font-medium text-white hover:bg-opacity-75">
                {{$data->button_title_1->default}}
            </a>
            @endif
            @if(!empty($data->button_title_2->default))
            <a href="#" class="inline-block bg-white py-2 px-4 border border-transparent rounded-md text-base font-medium text-indigo-600 hover:bg-indigo-50">
                {{$data->button_title_2->default}}
            </a>
            @endif
      </div>
    </div>
    <div class="py-4 flex flex-wrap justify-center space-x-6 lg:hidden">
        @foreach($data->menu->default->items as $item)
            <a href="{{$item->path}}" class="text-base font-medium text-white hover:text-indigo-50">{{$item->name}}</a>
        @endforeach
    </div>
  </nav>
</header>
