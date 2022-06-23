<div class="bg-white">
  <section aria-labelledby="features-heading" class="relative">
    <div class="aspect-w-3 aspect-h-2 overflow-hidden sm:aspect-w-5 lg:aspect-none lg:absolute lg:w-1/2 lg:h-full lg:pr-4 xl:pr-16">
        @if(!empty($data->image->default) && isset($data->image->default[0]))
            <img class="h-full w-full object-center object-cover lg:h-full lg:w-full"
                src="{{$data->image->default[0]['path']}}"
                alt="{{$data->image->default[0]['alt_text']}}"
            >
        @endif
    </div>

    <div class="max-w-2xl mx-auto pt-16 pb-24 px-4 sm:pb-32 sm:px-6 lg:max-w-7xl lg:pt-32 lg:px-8 lg:grid lg:grid-cols-2 lg:gap-x-8">
      <div class="lg:col-start-2">
        @if(!empty($data->subtitle->default))
            <h2 id="features-heading" class="font-medium text-gray-500">{{$data->subtitle->default}}</h2>
        @endif
        <p class="mt-4 text-4xl font-extrabold text-gray-900 tracking-tight">{{$data->title->default}}</p>
        @if(!empty($data->text->default))
        <p class="mt-4 text-gray-500">{{$data->text->default}}</p>
        @endif

        <dl class="mt-10 grid grid-cols-1 gap-y-10 gap-x-8 text-sm sm:grid-cols-2">
            @foreach($data->articles->default as $article)
                <div>
                    <dt class="font-medium text-gray-900">{{$article->title}}</dt>
                    @if(!empty($article->subtitle))
                      <dd class="mt-2 text-gray-500">{{$article->subtitle}}</dd>
                    @endif
                </div>
            @endforeach 
        </dl>
      </div>
    </div>
  </section>
</div>
