<div class="bg-white">

  <!-- Header -->
  <div class="relative pb-32 bg-gray-800">
    <div class="absolute inset-0">
		@if(!empty($data->image->default) && isset($data->image->default[0]))
            <img class="w-full h-full object-cover"
                src="{{$data->image->default[0]['path']}}"
                alt="{{$data->image->default[0]['alt_text']}}"
			>
        @endif
      <div class="absolute inset-0 bg-gray-800 mix-blend-multiply" aria-hidden="true"></div>
    </div>
    <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
      <h1 class="text-4xl font-extrabold tracking-tight text-white md:text-5xl lg:text-6xl">{{$data->title->default}}</h1>
	  @if(!empty($data->text->default))
      	<p class="mt-6 max-w-3xl text-xl text-gray-300">{{$data->text->default}}</p>
      @endif
    </div>
  </div>

  <!-- Overlapping cards -->
  <section class="-mt-32 max-w-7xl mx-auto relative z-10 pb-32 px-4 sm:px-6 lg:px-8" aria-labelledby="contact-heading">
		<div class="grid grid-cols-1 gap-y-20 lg:grid-cols-3 lg:gap-y-0 lg:gap-x-8">
			@foreach($data->articles->default as $article)
				<div class="flex flex-col bg-white rounded-2xl shadow-xl">
					<div class="flex-1 relative pt-16 px-6 pb-8 md:px-8">
					<div class="absolute top-0 p-5 inline-block bg-indigo-600 rounded-xl shadow-lg transform -translate-y-1/2">
						@if(!empty($article->images) && isset($article->images[0]))
						<img class="h-6 w-6 text-white" src="/storage/{{$article->images[0]['path']}}">
						@endif
					</div>
						<h3 class="text-xl font-medium text-gray-900">{{$article->title}}</h3>
						@if(!empty($article->subtitle))
							<p class="mt-4 text-base text-gray-500">{{$article->subtitle}}</p>
						@endif
					</div>
					<div class="p-6 bg-gray-50 rounded-bl-2xl rounded-br-2xl md:px-8">
						<a href="{{$article->link}}" class="text-base font-medium text-indigo-700 hover:text-indigo-600">{{$article->link_text}}<span aria-hidden="true"> &rarr;</span></a>
					</div>
				</div>
			@endforeach
		</div>
  </section>
</div>