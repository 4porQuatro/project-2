<div class="bg-gray-50 pt-12 sm:pt-16">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl font-extrabold text-gray-900 sm:text-4xl">{{$data->title->default}}</h2>
      @if(!empty($data->subtitle->default))
        <p class="mt-3 text-xl text-gray-500 sm:mt-4">{{$data->subtitle->default}}</p> 
      @endif
    </div>
  </div>
  <div class="mt-10 pb-12 bg-white sm:pb-16">
    <div class="relative">
      <div class="absolute inset-0 h-1/2 bg-gray-50"></div>
      <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
          <dl class="rounded-lg bg-white shadow-lg sm:grid sm:grid-cols-3">
            @foreach($data->articles->default as $article)
                <div class="flex flex-col border-b border-gray-100 p-6 text-center sm:border-0 sm:border-r">
                <dt class="order-2 mt-2 text-lg leading-6 font-medium text-gray-500">{{$article->title}}</dt>
                @if(!empty($article->subtitle))
                <dd class="order-1 text-5xl font-extrabold text-indigo-600">{{$article->subtitle}}</dd>
                @endif
                </div>
            @endforeach
          </dl>
        </div>
      </div>
    </div>
  </div>
</div>