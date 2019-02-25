<?php
namespace App\Http\Controllers\Api;
use App\Game;
use App\Http\Controllers\Controller;
use App\Http\Resources\GameResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $games = GameResource::collection(Game::orderByDesc('id')->paginate(100));
        return $games;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',
            'total_number_of_players' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        Game::create($request->only('name', 'description', 'total_number_of_players'));
        return response()->json([
            'success' => true,
            'message' => 'Saved'
        ]);
    }
    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Using Eloquent find method
        $game = new GameResource(Game::find($id));
        return response()->json($game, 200);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Game $game)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:games,name,' . $game->id,
            'description' => 'required',
            'total_number_of_players' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'errors' => $validator->errors(),
            ], 422);
        }
        $game->update($request->only('name', 'description', 'total_number_of_players'));
        return response()->json([
            'success' => true,
            'message' => 'Updated'
        ]);
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $game = Game::find($id);
        $game->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ]);
    }
}