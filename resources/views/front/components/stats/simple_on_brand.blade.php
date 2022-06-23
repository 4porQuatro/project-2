<div class="bg-indigo-800">
  <div class="max-w-7xl mx-auto py-12 px-4 sm:py-16 sm:px-6 lg:px-8 lg:py-20">

    <dl class="mt-10 text-center sm:max-w-3xl sm:mx-auto sm:grid sm:grid-cols-3 sm:gap-8">
        @foreach($data->articles->default as $article)
            <div class="flex flex-col mt-10 sm:mt-0">
                <dt class="order-2 mt-2 text-lg leading-6 font-medium text-indigo-200">{{$article->title}}</dt>
                @if(!empty($article->subtitle))
                <dd class="order-1 text-5xl font-extrabold text-white">{{$article->subtitle}}</dd>
                @endif
                <p>{!! $article->body !!}</p>
            </div>
        @endforeach
    </dl>
  </div>
</div>
