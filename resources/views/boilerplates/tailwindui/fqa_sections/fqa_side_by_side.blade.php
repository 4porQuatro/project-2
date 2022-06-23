<div class="bg-gray-50">
  <div class="max-w-7xl mx-auto py-12 px-4 divide-y divide-gray-200 sm:px-6 lg:py-16 lg:px-8">
    <h2 class="text-3xl font-extrabold text-gray-900">{{$data->title->default}}</h2>
    <div class="mt-8">
      <dl class="divide-y divide-gray-200">
        @foreach($data->articles->default as $article)
            <div class="pt-6 pb-8 md:grid md:grid-cols-12 md:gap-8">
            <dt class="text-base font-medium text-gray-900 md:col-span-5">{{$article->title}}</dt>
            <dd class="mt-2 md:mt-0 md:col-span-7">
                <p class="text-base text-gray-500">{{$article->subtitle}}</p>
            </dd>
            </div>
        @endforeach
      </dl>
    </div>
  </div>
</div>
