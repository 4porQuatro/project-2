<div class="bg-white">
  <div class="max-w-7xl mx-auto py-16 px-4 sm:px-6 lg:py-24 lg:px-8">
    <div class="divide-y-2 divide-gray-200">
      <div class="lg:grid lg:grid-cols-3 lg:gap-8">
        <h2 class="text-2xl font-extrabold text-gray-900 sm:text-3xl">{{$data->title->default}}</h2>
        <div class="mt-8 grid grid-cols-1 gap-12 sm:grid-cols-2 sm:gap-x-8 sm:gap-y-12 lg:mt-0 lg:col-span-2">
          @foreach($data->articles->default as $article)
            <div>
                  <h3 class="text-lg leading-6 font-medium text-gray-900">{{$article->title}}</h3>
                  <dl class="mt-2 text-base text-gray-500">
                    @if(!empty($article->subtitle))
                      <div>
                        <dt class="sr-only">{{$article->subtitle}}</dt>
                        <dd>{{$article->subtitle}}</dd>
                      </div>
                    @endif
                    @if(!empty($article->slug))
                      <div class="mt-1">
                        <dt class="sr-only">{{$article->slug}}</dt>
                        <dd>{{$article->slug}}</dd>
                      </div>
                    @endif
                  </dl>
            </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
