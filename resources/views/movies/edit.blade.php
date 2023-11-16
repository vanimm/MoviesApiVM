@extends('Layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center p-4">
            <div>
                <h3>Edit Movie</h3>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <form action="{{ route('movie.update', $movie->id) }}" method="post">
                    @csrf
                    @method('PUT')
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="d-flex justify-content-center align-items-center">
                        <div class="p-3">
                            <label for="title">Title:</label>
                            <input type="text" class="form-control" placeholder="title" id="title" name="title"
                                value="{{ isset($movie) ? $movie->title : old('title') }}"
                                @error('title
                                ') border-red-500 @enderror>
                        </div>
                        <div class="p-3">
                            <label for="year">Year:</label>
                            <input type="number" class="form-control" placeholder="year" min="1800"
                                max="9999"id="year" name="year"
                                value="{{ isset($movie) ? $movie->year : old('year') }}"
                                @error('year
                                ') border-red-500 @enderror>
                        </div>
                        <div class="p-3">
                            <label for="genre">Genre:</label>
                            <input type="text" class="form-control" placeholder="genre" id="genre" name="genre"
                                value="{{ isset($movie) ? $movie->genre : old('genre') }}"
                                @error('genre
                                ') border-red-500 @enderror>
                        </div>

                    </div>
                    <div class="d-flex justify-content-center align-items-center p-3">
                        <a href="{{ route('movies.index') }}" class="btn btn-secondary m-2" style="margin-right: 1px">
                            Movies
                        </a>
                        <input type="submit" class="btn btn-primary m-2" value="Save">
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
