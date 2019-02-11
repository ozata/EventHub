<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\EventResource;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Event;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */



    public function join(Request $request, Event $event, $id){
        $event->users()->attach($id);
    }

    // Bir model içerisindeki tüm kayıtları çekmeyi sağlar.
    public function index()
    {   $events = EventResource::collection(Event::orderByDesc('id')->paginate(5));
        return $events;
        //return response()->json(['events' => $events], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
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

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        Event::create($request->only('name','creator','when_is_it', 'game_id'));

        return response()->json([
            'success' => true,
            'message' => 'Saved'
        ]);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
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

        if($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => 'Failed',
                'errors' => $validator->errors(),
            ], 422);
        }

        $event->update($request->only('name','creator','when_is_it', 'game_id'));

        return response()->json([
            'success' => true,
            'message' => 'Saved'
        ],206);

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