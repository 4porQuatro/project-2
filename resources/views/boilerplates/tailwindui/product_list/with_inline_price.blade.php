<div class="bg-white">
  <div class="max-w-2xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:max-w-7xl lg:px-8">
    <h2 class="text-2xl font-extrabold tracking-tight text-gray-900">{{$data->title->default}}</h2>

    <div class="mt-6 grid grid-cols-1 gap-y-10 gap-x-6 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
      @foreach($data->articles->default as $article)
        <div class="group relative">
              <div class="w-full min-h-80 bg-gray-200 aspect-w-1 aspect-h-1 rounded-md overflow-hidden group-hover:opacity-75 lg:h-80 lg:aspect-none">
                  @if(!empty($article->images) && isset($article->images[0]))
                      <img class="w-full h-full object-center object-cover lg:w-full lg:h-full" 
                          src="/storage/{{$article->images[0]['path']}}"
                          alt="{{$article->images[0]['alt_text']}}"
                      >
                  @endif
              </div>
              <div class="mt-4 flex justify-between">
              <div>
                  <h3 class="text-sm text-gray-700">
                  <a href="{{$article->link}}">
                      <span aria-hidden="true" class="absolute inset-0"></span>
                      {{$article->title}}
                  </a>
                  </h3>
                  @if(!empty($article->subtitle))
                    <p class="mt-1 text-sm text-gray-500">{{$article->subtitle}}</p>
                  @endif
              </div>
              <p class="text-sm font-medium text-gray-900">{{$article->slug}}</p>
              </div>
        </div>
      @endforeach 
    </div>
  </div>
</div>
