<footer class="bg-white">
  <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 md:flex md:items-center md:justify-between lg:px-8">
    <div class="flex justify-center space-x-6 md:order-2">
        @foreach($data->article_social->default as $article)
            <a href="{{$article->link}}" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">{{$article->title}}</span>
                @if(!empty($article->images) && isset($article->images[0]))
					<img class="h-6 w-6" src="/storage/{{$article->images[0]['path']}}">
				@endif
            </a>       
        @endforeach
    </div>
    <div class="mt-8 md:mt-0 md:order-1">
      @if(!empty($data->text->default))
          <p class="text-center text-base text-gray-400">{{$data->text->default}}</p>
      @endif
    </div>
  </div>
</footer>
