<?php

namespace App\Http\Controllers\API;

use Carbon\Carbon;
use App\Models\Movie;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;


class MovieController extends Controller
{

    protected $httpClient;

    public function __construct(Client $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /**
     *  Connects and consumes API Movies and their Genres.
     */
    public function getApiMovies()
    {

        $headers = [
            'headers' => [
                'Authorization' => env('API_KEY'),
                'accept' => 'application/json',
            ],
        ];

        // Gets from api the movies
        $response_movies = $this->httpClient->get('movie/now_playing?language=en-US&page=1',  $headers);
        $movies = json_decode($response_movies->getBody()->getContents())->results;


        // Gets from api the genres
        $response_genres = $this->httpClient->get('genre/movie/list?language=en', $headers);
        $genres = json_decode($response_genres->getBody()->getContents())->genres;

        // Combine both data obtained
        $combinedMovies = collect($movies)->map(function ($movie) use ($genres) {
            $genreNames = collect($movie->genre_ids)->map(function ($genre_id) use ($genres) {

                $genreObject = collect($genres)->first(function ($genre, $key) use ($genre_id) {
                    return $genre->id == $genre_id;
                });

                return $genreObject->name;
            })->all();

            return (array)$movie + ['genres' => $genreNames];
        });

        // Store in the DB
        $this->storeAPIMovies($combinedMovies);

        return  redirect()->route('movies.index')->with('msg', 'The movies was charge successfully');
    }

    /**
     * Saves the received movies in the DB. 
     * receives as parameter @combinedMovies
     */
    protected function storeAPIMovies($combinedMovies)
    {
        // Scroll through the Movies array
        foreach ($combinedMovies as $movie) {

            $bd = Movie::find($movie["id"]);

            if (isset($bd)) {
                return;
            } else {
                Movie::create([
                    'id' => $movie["id"],
                    'title' => $movie["title"],
                    'year' => Carbon::parse($movie["release_date"])->year,
                    'genre' => implode(', ', $movie["genres"])
                ]);
            }
        }
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies =  Movie::paginate(10);
        return view('movies.index', compact('movies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $this->validate($request, [
                'title' => 'required|max:250|string',
                'year' => 'required',
                'genre' => 'required|string'
            ]);

            $movie = Movie::create([
                'title' => $request->title,
                'year' => $request->year,
                'genre' => $request->genre
            ]);

            return response()->json(["msg" => "The film was saved successfully", "stored" =>  $movie], 201);
        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Show the form for edit a movie.
     */
    public function edit(string $id)
    {
        try {
            $movie = Movie::find($id);
            return view('movies.edit', compact('movie'));
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {

            $movie = Movie::find($id);

            $this->validate($request, [
                'title' => 'required|max:250|string',
                'year' => 'required',
                'genre' => 'required|string'
            ]);

            $movie->title = $request->title;
            $movie->year = $request->year;
            $movie->genre = $request->genre;

            $movie->save();

            return  redirect()->route('movies.index')->with('msg', 'The movie was updated successfully');
        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {

            $movie = Movie::findOrFail($id);
            $movie->delete();

            return redirect()->route('movies.index')->with('msg', 'Discount was removed successfully');
        } catch (\Throwable $th) {

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
