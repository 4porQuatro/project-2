<div class="min-h-full flex flex-col justify-center py-12 sm:px-6 lg:px-8">
  <div class="sm:mx-auto sm:w-full sm:max-w-md">
    @if(!empty($data->logo->default) && isset($data->logo->default[0]))
      <img class="mx-auto h-12 w-auto"
        src="{{$data->logo->default[0]['path']}}"
        alt="{{$data->logo->default[0]['alt_text']}}"
      >
    @endif
    <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">{{$data->title->default}}</h2>
      @if(!empty($data->subtitle->default))
        <p class="mt-2 text-center text-sm text-gray-600">
          <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">{{$data->subtitle->default}}</a>
        </p>                         
      @endif
  </div>

  <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
    <div class="bg-white py-8 px-4 shadow sm:rounded-lg sm:px-10">

          <form action="{{ $data->form->default}}" method="POST" class="space-y-6">
            @csrf
            <input type="hidden" name="default" value="{{ $data->form->default }}">
                @foreach ($data->form->default->fields as $item)
                  @if($item->name == 'email' || $item->name == 'password')
                    <div>
                      <label for="{{ $item->name}}" class="block text-sm font-medium text-gray-700">{{ $item->label }}</label>
                      <div class="mt-1">
                        <input type="{{ $item->type }}" name="{{ $item->name}}" autocomplete="given-name" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                      </div>
                    </div>
                  @elseif($item->name == 'remember')
                    <div class="flex items-center justify-between">
                      <div class="flex items-center">
                        <input name="{{ $item->name}}" type="checkbox" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="{{ $item->name}}" class="ml-2 block text-sm text-gray-900">{{ $item->label }}</label>
                      </div>   
                      <div class="text-sm">
                      <a href="#" class="font-medium text-indigo-600 hover:text-indigo-500">{{$data->button_forgot->default}}</a>
                      </div>
                    </div>                                 
                    <div>
                  @endif
                @endforeach
            <div>
                <button type="submit" class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">{{$data->button_submit->default}}</button>
            </div>
          </form>

      @if(!empty($data->text->default))    
        <div class="mt-6">
          <div class="relative">
            <div class="absolute inset-0 flex items-center">
              <div class="w-full border-t border-gray-300"></div>
            </div>
            <div class="relative flex justify-center text-sm">
              <span class="px-2 bg-white text-gray-500">{{$data->text->default}}</span>
            </div>
          </div>

          <div class="mt-6 grid grid-cols-3 gap-3">
          @foreach($data->articles->default as $article)
            <div>
              <a href="{{$article->link}}" class="w-full inline-flex justify-center py-2 px-4 border border-gray-300 rounded-md shadow-sm bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
                <span class="sr-only">{{$article->title}}</span>

                @if(!empty($article->images) && isset($article->images[0]))
                  <img class="w-5 h-5" src="/storage/{{$article->images[0]['path']}}">
                @endif

              </a>
            </div>
          @endforeach 

          </div>
        </div>               
      @endif
    </div>
  </div>
</div>
