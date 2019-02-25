<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

    protected $fillable = [
        'name', 'description', 'total_number_of_players',
    ];

    public function event(){
        return $this->hasMany(Event::class);
    }


}
