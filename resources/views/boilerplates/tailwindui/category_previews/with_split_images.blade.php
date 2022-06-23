<!--
  This example requires updating your template:

  ```
  <html class="h-full bg-gray-50">
  <body class="h-full">
  ```

  *** I used h-768 for test - web page size ***
-->
<div class="h-768 grid grid-rows-2 grid-cols-1 lg:grid-rows-1 lg:grid-cols-2">
        @foreach($data->articles->default as $article)
            <div class="relative flex">
                @if(!empty($article->images) && isset($article->images[0]))
                    <img class="absolute inset-0 w-full h-full object-center object-cover" 
                        src="/storage/{{$article->images[0]['path']}}"
                        alt="{{$article->images[0]['alt_text']}}"
                    >
                @endif
                <div class="relative w-full flex flex-col items-start justify-end bg-black bg-opacity-40 p-8 sm:p-12">
                    @if(!empty($article->subtitle)
                        <h2 class="text-lg font-medium text-white text-opacity-75">{{$article->subtitle}}</h2>
                    @endif
                    <p class="mt-1 text-2xl font-medium text-white">{{$article->title}}</p>
                    <a href="{{$article->link}}" class="mt-4 text-sm font-medium text-gray-900 bg-white py-2.5 px-4 rounded-md hover:bg-gray-50">{{$article->link_text}}</a>
                </div>
            </div>
        @endforeach 
</div>

