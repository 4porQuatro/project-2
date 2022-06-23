<div class="py-16 bg-gray-50 overflow-hidden lg:py-24">
  <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">

    <!-- SVG used in background -->
    <svg class="hidden lg:block absolute left-full transform -translate-x-1/2 -translate-y-1/4" width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
      <defs>
        <pattern id="b1e6e422-73f8-40a6-b5d9-c8586e37e0e7" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
          <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
        </pattern>
      </defs>
      <rect width="404" height="784" fill="url(#b1e6e422-73f8-40a6-b5d9-c8586e37e0e7)" />
    </svg>

    <div class="relative lg:grid lg:grid-cols-2 lg:gap-8 lg:items-center">
      <div class="relative">
        <h3 class="text-2xl font-extrabold text-gray-900 tracking-tight sm:text-3xl">{{$data->title->default}}</h3>
        @if(!empty($data->subtitle->default))
          <p class="mt-3 text-lg text-gray-500">{{$data->subtitle->default}}</p>
        @endif

        <dl class="mt-10 space-y-10">
            @foreach($data->articles->default as $article)
                <div class="relative">
                    <dt>
                        <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                            @if(!empty($article->images) && isset($article->images[0]))
                                <div class="absolute flex items-center justify-center h-12 w-12 rounded-md bg-indigo-500 text-white">
                                <img class="h-6 w-6" src="/storage/{{$article->images[0]['path']}}">
                                </div>
                            @endif
                        </div>
                        <p class="ml-16 text-lg leading-6 font-medium text-gray-900">{{$article->title}}</p>
                    </dt>
                    <dd class="mt-2 ml-16 text-base text-gray-500">{{$article->subtitle}}</dd>
                </div>
            @endforeach
        </dl>

        </div>
          <div class="mt-10 -mx-4 relative lg:mt-0" aria-hidden="true">
            @if(!empty($data->image->default) && isset($data->image->default[0]))
                <img class="relative mx-auto" width="490"
                    src="{{$data->image->default[0]['path']}}"
                    alt="{{$data->image->default[0]['alt_text']}}"
                >
            @endif
          </div>
        </div>

      </div>
    </div>
  </div>
</div>