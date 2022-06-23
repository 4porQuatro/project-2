<div class="relative bg-indigo-800">
  <div class="absolute inset-0">
    @if(!empty($data->image->default) && isset($data->image->default[0]))
        <img class="w-full h-full object-cover"
            src="{{$data->image->default[0]['path']}}"
            alt="{{$data->image->default[0]['alt_text']}}"
        >
    @endif
    <div class="absolute inset-0 bg-indigo-800 mix-blend-multiply" aria-hidden="true"></div>
  </div>
  <div class="relative max-w-7xl mx-auto py-24 px-4 sm:py-32 sm:px-6 lg:px-8">
    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-5xl lg:text-6xl">{{$data->title->default}}</h1>
    @if(!empty($data->text->default))
      <p class="mt-6 text-xl text-indigo-100 max-w-3xl">{{$data->text->default}}</p>
    @endif
  </div>
</div>