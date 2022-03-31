@extends('index')

@section('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container my-3">
        @if(!$books->isEmpty())
            <div class="library-wrap">
                @foreach($books as $book)
                    <div class="book">
                        <div class="name">
                            <span>{{ $book->name }}</span>
                        </div>
                        <div class="authors">
                            <label>{{ count($book->authors) > 1 ? 'Авторы:' : 'Автор:' }} </label>
                            <div>
                                @foreach($book->authors as $key => $author)
                                    <span>{{ $author->name }}{{ !$loop->last  ? ',' : '' }}</span>
                                @endforeach
                            </div>
                        </div>
                        <div class="publishers">
                            <label>{{ count($book->publishers) > 1 ? 'Издатели:' : 'Издатель:' }} </label>
                            <div>
                                @foreach($book->publishers as  $key => $publisher)
                                    <span>{{ $publisher->name }}{{ !$loop->last  ? ',' : '' }}</span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="library-empty">
                <label>Библиотека пуста</label>
                <span>Документация по API: <a href="https://app.swaggerhub.com/apis/SlamDevelop/Test-Library-Laravel/1" target="_blank">https://app.swaggerhub.com/apis/SlamDevelop/Test-Library-Laravel/1</a></span>
            </div>
        @endif
    </div>
@endsection