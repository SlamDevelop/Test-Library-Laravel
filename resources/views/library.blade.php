@extends('index')

@section('styles')
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet">
@endsection

@section('content')
    <div class="container">
        <div class="library-wrap my-3">
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
    </div>
@endsection