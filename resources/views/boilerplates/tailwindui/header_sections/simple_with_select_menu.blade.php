<div class="bg-white">
  <div class="max-w-7xl mx-auto py-16 px-4 sm:py-24 sm:px-6 lg:px-8 lg:flex lg:justify-between">
    <div class="max-w-xl">
      <h2 class="text-4xl font-extrabold text-gray-900 sm:text-5xl sm:tracking-tight lg:text-6xl">{{$data->title->default}}</h2>
      @if(!empty($data->text->default))
        <p class="mt-5 text-xl text-gray-500">{{$data->text_1->default}}</p>
      @endif
    </div>
    <div class="mt-10 w-full max-w-xs">
      <label for="dropdown" class="block text-base font-medium text-gray-500">{{$data->text_2->default}}</label>
      <div class="mt-1.5 relative">
            <select id="dropdown" name="dropdown" class="appearance-none block w-full bg-none bg-white border border-gray-300 rounded-md pl-3 pr-10 py-2 text-base text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                @foreach($data->articles->default as $article)
                    <option>{{$article->title}}</option>
                @endforeach
            </select>
        <div class="pointer-events-none absolute inset-y-0 right-0 px-2 flex items-center">
          <!-- Icon -->
          <svg class="h-4 w-4 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
          </svg>
        </div>
      </div>
    </div>
  </div>
</div>