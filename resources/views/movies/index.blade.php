@extends('Layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-center p-4">
            <h3>Movies</h3>
        </div>
        <div class="d-flex justify-content-end align-items-end">
            <a href="{{ route('movies.getApiMovies') }}" style="margin-right: 3px">
                <button type="submit" class="btn btn-primary">Get API Movies</button>
            </a>
        </div>
        <hr>
        @if (Session::has('msg'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ Session::get('msg') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">TITLE</th>
                                <th scope="col">YEAR</th>
                                <th scope="col">GENRE</th>
                                <th scope="col">ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($movies as $movie)
                                <tr>
                                    <td scope="row">{{ $movie->id }}</td>
                                    <td>{{ $movie->title }} </td>
                                    <td>{{ $movie->year }} </td>
                                    <td>{{ $movie->genre }} </td>
                                    <td>
                                        <div class="d-flex justify-content-start align-items-center">
                                            <a href="{{ route('movie.edit', $movie->id) }}"
                                                class="btn btn-primary btn-sm px-3 m-1">
                                                Update
                                            </a>
                                            <form action="{{ route('movie.destroy', $movie->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-danger btn-sm px-3 m-1"
                                                    onclick="return confirm('you wish to delete the movie?')"
                                                    value="Delete">
                                            </form>
                                        </div>

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{-- seccion de paginado --}}
                    <div class="d-flex justify-content-end"> {!! $movies->links() !!} </div>
                </div>
            </div>
        </div>
    </div>
@endsection
