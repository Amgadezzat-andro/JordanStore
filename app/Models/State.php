<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    use HasFactory;


    // define table name
    protected $table = 'states';

    // define primary key
    protected $primarykey = 'id';
    
    public function country()
    {
        // one to many inverse
        //many states have one countrey 
        return $this->belongsTo(Country::class, 'country_id', 'id');
    }
    public function cities()
    {   
        //one to many
        //one state have many cities
        return $this->hasMany(City::class, 'state_id', 'id');
    }
}
