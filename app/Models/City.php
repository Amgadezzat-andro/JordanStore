<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    //define table name
    protected $table = 'cities';

    //define primary key
    protected $primarykey = 'id';


    public function country()
    {

        //many cities have one countrey
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function states()
    {
        // many cities have one state
        return $this->belongsTo(State::class, 'state_id', 'id');
    }
}
