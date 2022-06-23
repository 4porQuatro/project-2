<div class="bg-white">
  <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
    <div class="md:flex md:items-center md:justify-between">
      <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">{{$data->title->default}}</h2>
      @if(!empty($data->button_link->default))
      <a href="{{$data->button_link->default}}" class="hidden text-sm font-medium text-indigo-600 hover:text-indigo-500 md:block">{{$data->button_title->default}}<span aria-hidden="true"> &rarr;</span></a>
      @endif
    </div>

    <div class="mt-6 grid grid-cols-2 gap-x-4 gap-y-10 sm:gap-x-6 md:grid-cols-4 md:gap-y-0 lg:gap-x-8">
    @foreach($data->articles->default as $article)
        <div class="group relative">
              <div class="w-full h-56 bg-gray-200 rounded-md overflow-hidden group-hover:opacity-75 lg:h-72 xl:h-80">
                  @if(!empty($article->images) && isset($article->images[0]))
                      <img class="w-full h-full object-center object-cover" 
                          src="/storage/{{$article->images[0]['path']}}"
                          alt="{{$article->images[0]['alt_text']}}"
                      >
                  @endif
              </div>
                <h3 class="text-sm text-gray-700">
                  <a href="{{$article->link}}">
                        <span class="absolute inset-0"></span>
                        {{$article->title}}
                  </a>
                </h3>
                @if(!empty($article->subtitle))
                  <p class="mt-1 text-sm text-gray-500">{{$article->subtitle}}</p>
                @endif
                <p class="text-sm font-medium text-gray-900">{{$article->slug}}</p>
        </div>
    @endforeach 

    <div class="mt-8 text-sm md:hidden">
      <a href="{{$data->button_link->default}}" class="font-medium text-indigo-600 hover:text-indigo-500">{{$data->button_title->default}}<span aria-hidden="true"> &rarr;</span></a>
    </div>
  </div>
</div>
