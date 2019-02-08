<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Event extends Model
{
    use Notifiable;


    public function game(){

        return $this->belongsTo(Game::class);

    }

    public function users(){
        return $this->belongsToMany('App\User');
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'creator', 'when_is_it','game_id'
    ];

}
