@extends('_layouts.master')

@php
    $page->type = 'article';
@endphp

@section('body')
    @if ($page->cover_image)
        <img src="{{ $page->cover_image }}" alt="{{ $page->title }} cover image" class="mb-2"/>
    @endif

    @if($page->credits)
        <dev class="text-xs text-black-300">
            {!! $page->credits !!}
        </dev>

    @endif

    <h1 class="leading-none mb-2">{{ $page->title }}</h1>

    <p class="text-gray-700 text-xl md:mt-0">{{ $page->author }}  •  {{ date('F j, Y', $page->date) }}</p>

    @if ($page->categories)
        @foreach ($page->categories as $i => $category)
            <a
                href="{{ '/blog/categories/' . $category }}"
                title="View posts in {{ $category }}"
                class="inline-block bg-gray-300 hover:bg-blue-200 leading-loose tracking-wide text-gray-800 uppercase text-xs font-semibold rounded mr-4 px-3 pt-px"
            >{{ $category }}</a>
        @endforeach
    @endif

    <div class="border-b border-blue-200 mb-10 pb-4" v-pre>
        @yield('content')

        <p class="text-base bg-blue-200 p-4">
            Thanks for reading i hope you liked it<br>
            Drop me a message at <a href="https://bio.link/mostafakram">@mostafakram</a> 👋 and let me know what you think <br>
            If you found any mistake or issue please report it on <a href="https://github.com/mostafakram/mostafakram.dev">Github</a>
        </p>
    </div>


    <nav class="flex justify-between text-sm md:text-base">
        <div>
            @if ($next = $page->getNext())
                <a href="{{ $next->getUrl() }}" title="Older Post: {{ $next->title }}">
                    &LeftArrow; {{ $next->title }}
                </a>
            @endif
        </div>

        <div>
            @if ($previous = $page->getPrevious())
                <a href="{{ $previous->getUrl() }}" title="Newer Post: {{ $previous->title }}">
                    {{ $previous->title }} &RightArrow;
                </a>
            @endif
        </div>
    </nav>
@endsection
