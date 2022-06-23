<div class="bg-white">
  <div class="max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold text-gray-900">{{$data->title->default}}</h2>
    <p class="mt-6 text-lg text-gray-500 max-w-3xl">{{$data->subtitle->default}}</p>
    <div class="mt-10 grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-4">
        @foreach($data->articles->default as $article)
            <div>
                <h3 class="text-lg font-medium text-gray-900">{{$article->title}}</h3>
                <p class="mt-2 text-base text-gray-500">
                  @if(!empty($article->subtitle))
                    <span class="block">{{$article->subtitle}}</span>
                  @endif
                  @if(!empty($article->subtitle))
                    <span class="block">{{$article->slug}}</span>
                  @endif
                </p>
            </div>
        @endforeach
    </div>
  </div>
</div>