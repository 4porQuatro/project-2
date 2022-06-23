<div class="bg-white">
  <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8">
    <h2 class="text-3xl font-extrabold text-gray-900 text-center">{{$data->title->default}}</h2>
    <div class="mt-12">
      <dl class="space-y-10 md:space-y-0 md:grid md:grid-cols-2 md:gap-x-8 md:gap-y-12 lg:grid-cols-3">
        @foreach($data->articles->default as $article)
            <div>
                <dt class="text-lg leading-6 font-medium text-gray-900">{{$article->title}}</dt>
                <dd class="mt-2 text-base text-gray-500">{{$article->subtitle}}</dd>
            </div>
        @endforeach
      </dl>
    </div>
  </div>
</div>