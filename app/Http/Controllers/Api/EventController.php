<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EventResource;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use App\Game;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{

    public function getPlayers($id)
    {

        $event = Event::find($id);
        $players = $event->users()->get();
        return response()->json($players, 200);;

    }

    public function getParticipants()
    {
        $events = Event::all();
        $user_list = array();
        foreach ($events as $event) {
            $user = $event->users()->get();
            $user_list[$event->id] = $user;
        }
        return response()->json($user_list, 200);
    }

    /**
     *
     *  User joins a game.
     *  If it is full or the user is in already in Event, she can't join.
     *
     * @param Request $request
     * @param $id
     * @return string
     *
     *
     */


    public function join(Request $request, $id)
    {
        $event = Event::find($id);
        $user_id = Auth::user()->id;
        $game_id = $event->game_id;
        $game = Game::find($game_id);
        $user_in_event = $event->users()->where('id', $user_id)->exists();
        $numberOfUsersInEvent = count($event->users()->get());
        $totalNumberOfPlayersOfGame = $game->total_number_of_players;
        if ($user_in_event) {
            return "User is already in event";
        } else if ($numberOfUsersInEvent >= $totalNumberOfPlayersOfGame) {
            return "The Event is Full";
        }
        $event->users()->attach($user_id);
        return $event->users()->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */

    // Bir model içerisindeki tüm kayıtları çekmeyi sağlar.
    public function index()
    {
        $events = EventResource::collection(Event::orderByDesc('id')->paginate(5));
        return $events;
        //return response()->json(['events' => $events], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    // Gönderdiğimiz bir model verisinin kaydedilmesini sağlar.
    public function store(Request $request)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'creator' => 'required|string|max:50',
            'when_is_it' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        Event::create($request->only('name', 'creator', 'when_is_it', 'game_id'));

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

    // Verilen bir ID'ye bağlı tek bir kayıtı göstermeyi sağlar
    public function show($id)
    {
        //
        $event = new EventResource(Event::find($id));
        return response()->json($event, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param Event $event
     * @return void
     */

    // Güncellemeyi sağlar
    /**
     * @param Request $request
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Event $event)
    {
        //
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:50',
            'creator' => 'required|string|max:50',
            'when_is_it' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $event->update($request->only('name', 'creator', 'when_is_it', 'game_id'));

        return response()->json([
            'success' => true,
            'message' => 'Saved'
        ], 206);

    }


    // Bir ID'ye ait kaydı silmeyi sağlar

    /**
     * @param Event $event
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function destroy(Event $event)
    {
        //

        $event->delete();
        return response()->json([
            'success' => true,
            'message' => 'Deleted'
        ]);


    }
}