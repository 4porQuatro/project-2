<!--
<header_single :component_data="{{json_encode($data)}}"></header_single>
-->
<div class="relative bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6">
        <div class="flex justify-between items-center border-b-2 border-gray-100 py-6 md:justify-start md:space-x-10">
            <div class="flex justify-start lg:w-0 lg:flex-1">
                <a href="/">
                    <span class="sr-only">Workflow</span>
                    @if(!empty($data->image_logo->default) && isset($data->image_logo->default[0]))
                    <img class="h-8 w-auto sm:h-10"
                         src="{{$data->image_logo->default[0]['path']}}"
                         alt="{{$data->image_logo->default[0]['alt_text']}}">
                    @endif
                </a>
            </div>
            <div class="-mr-2 -my-2 md:hidden">
                <button type="button" class="bg-white rounded-md p-2 inline-flex items-center justify-center text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-indigo-500" aria-expanded="false">
                    <span class="sr-only">Open menu</span>
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
            <nav class="hidden md:flex space-x-10">
                @foreach($data->menu->default->items as $item)
                    @if($item->childrens()->count())
                        <div class="relative">
                            <button type="button" class="text-gray-500 group bg-white rounded-md inline-flex items-center text-base font-medium hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" aria-expanded="false">
                                <span>{{$item->name}}</span>

                                <svg class="text-gray-400 ml-2 h-5 w-5 group-hover:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>

                            <div class="absolute z-10 -ml-4 mt-3 transform px-2 w-screen max-w-md sm:px-0 lg:ml-0 lg:left-1/2 lg:-translate-x-1/2">
                                <div class="rounded-lg shadow-lg ring-1 ring-black ring-opacity-5 overflow-hidden">
                                    <div class="relative grid gap-6 bg-white px-5 py-6 sm:gap-8 sm:p-8">
                                        @foreach($item->childrens as $child)
                                        <a href="{{$item->path}}" class="-m-3 p-3 flex items-start rounded-lg hover:bg-gray-50">

                                            @if(!empty($child->images) && isset($child->images[0]))
                                            <img class="flex-shrink-0 h-6 w-6 text-indigo-600" src="{{$child->images[0]['path']}}">
                                            @endif
                                            <div class="ml-4">
                                                <p class="text-base font-medium text-gray-900">{{$item->name}}</p>
                                                <!--
                                                <p class="mt-1 text-sm text-gray-500">Get a better understanding of where your traffic is coming from.</p>
                                                -->
                                            </div>
                                        </a>
                                            @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <a href="{{$item->path}}" class="text-base font-medium text-gray-500 hover:text-gray-900"> {{$item->name}} </a>
                    @endif
                @endforeach

            </nav>
            <div class="hidden md:flex items-center justify-end md:flex-1 lg:w-0">


                <a href="#" class="ml-8 whitespace-nowrap inline-flex items-center justify-center px-4 py-2 border border-transparent rounded-md shadow-sm text-base font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                    button
                </a>

            </div>
        </div>
    </div>

    {{-- Menu opened --}}
    <div style="background-color: lightgrey">
        @foreach($data->menu_1->default->items as $item)
            <a href="{{$item->path}}" class="text-base font-medium text-gray-500 hover:text-gray-900"> {{$item->name}} </a>
        @endforeach

        @foreach($data->menu_1->default->items as $item)
                <a href="{{$item->path}}" class="text-base font-medium text-gray-500 hover:text-gray-900"> {{$item->name}} </a>
        @endforeach

        <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900"> PT </a>|
        <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900"> EN </a>|
        <a href="/" class="text-base font-medium text-gray-500 hover:text-gray-900"> ES </a>

        <div>
            <p>{{$data->text_1->default}}    {{$data->text_2->default}}</p>
            <p>{{$data->text_3->default}}    {{$data->text_4->default}}</p>
        </div>
    </div>
</div>

