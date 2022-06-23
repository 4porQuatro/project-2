<footer class="bg-white">
  <div class="max-w-7xl mx-auto py-12 px-4 overflow-hidden sm:px-6 lg:px-8">
    <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
        @foreach($data->article_footer->default as $article)
            <div class="px-5 py-2">
                <a href="{{$article->link}}" class="text-base text-gray-500 hover:text-gray-900">{{$article->title}}</a>
            </div>
        @endforeach
    </nav>
    <div class="mt-8 flex justify-center space-x-6">
        @foreach($data->article_social->default as $article)
            <a href="{{$article->link}}" class="text-gray-400 hover:text-gray-500">
                <span class="sr-only">{{$article->title}}</span>
                @if(!empty($article->images) && isset($article->images[0]))
					<img class="h-6 w-6" src="/storage/{{$article->images[0]['path']}}">
				@endif
            </a>
        @endforeach
    </div>
    @if(!empty($data->text->default))
        <p class="mt-8 text-center text-base text-gray-400">{{$data->text->default}}</p>
    @endif
  </div>
</footer>
