<div class="py-16 bg-gray-50 overflow-hidden lg:py-24">
  <div class="relative max-w-xl mx-auto px-4 sm:px-6 lg:px-8 lg:max-w-7xl">

    <!-- SVG used in background -->
    <svg class="hidden lg:block absolute right-full transform translate-x-1/2 translate-y-12" width="404" height="784" fill="none" viewBox="0 0 404 784" aria-hidden="true">
      <defs>
        <pattern id="64e643ad-2176-4f86-b3d7-f2c5da3b6a6d" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
          <rect x="0" y="0" width="4" height="4" class="text-gray-200" fill="currentColor" />
        </pattern>
      </defs>
      <rect width="404" height="784" fill="url(#64e643ad-2176-4f86-b3d7-f2c5da3b6a6d)" />
    </svg>

    <div class="relative mt-12 sm:mt-16 lg:mt-24">
      <div class="lg:grid lg:grid-flow-row-dense lg:grid-cols-2 lg:gap-8 lg:items-center">
        <div class="lg:col-start-2">
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

        <div class="mt-10 -mx-4 relative lg:mt-0 lg:col-start-1">
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
