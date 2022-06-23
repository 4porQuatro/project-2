<div class="relative bg-white py-16 sm:py-24 lg:py-32">
  <div class="mx-auto max-w-md px-4 text-center sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
    @if(!empty($data->subtitle->default))
      <h2 class="text-base font-semibold uppercase tracking-wider text-indigo-600">{{$data->subtitle->default}}</h2>
    @endif
    <p class="mt-2 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">{{$data->title->default}}</p>
    @if(!empty($data->text->default))
      <p class="mx-auto mt-5 max-w-prose text-xl text-gray-500">{{$data->text->default}}</p>
    @endif
    <div class="mt-12">
      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">

        @foreach($data->articles->default as $article)
          <div class="pt-6">
            <div class="flow-root rounded-lg bg-gray-50 px-6 pb-8">
              <div class="-mt-6">
                <div>
                  <span class="inline-flex items-center justify-center rounded-md bg-indigo-500 p-3 shadow-lg">
                      @if(!empty($article->images) && isset($article->images[0]))
                          <div class="absolute flex items-center justify-center h-6 w-6 rounded-md bg-indigo-500 text-white">
                              <img src="/storage/{{$article->images[0]['path']}}">
                          </div>
                      @endif
                  </span>
                </div>
                <h3 class="mt-8 text-lg font-medium tracking-tight text-gray-900">{{$article->title}}</h3>
                @if(!empty($article->subtitle))
                  <p class="mt-5 text-base text-gray-500">{{$article->subtitle}}</p>
                @endif
              </div>
            </div>
          </div>
        @endforeach

      </div>
    </div>
  </div>
</div>
