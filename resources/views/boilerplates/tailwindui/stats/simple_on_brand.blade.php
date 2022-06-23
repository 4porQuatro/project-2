<div class="bg-indigo-800">
  <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8 lg:py-20">
    <div class="max-w-4xl mx-auto text-center">
      <h2 class="text-3xl font-extrabold text-white sm:text-4xl">{{$data->title->default}}</h2>
      @if(!empty($data->subtitle->default))
        <p class="mt-3 text-xl text-indigo-200 sm:mt-4">{{$data->subtitle->default}}</p>
      @endif
    </div>
    <dl class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
        @foreach($data->articles->default as $article)
            <div class="flex flex-col mt-10 sm:mt-0">
                <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">{{$article->title}}</dt>
                @if(!empty($article->subtitle))
                <dd class="order-1 text-5xl font-extrabold text-white">{{$article->subtitle}}</dd>
                @endif
            </div>
        @endforeach
    </dl>
  </div>
</div>