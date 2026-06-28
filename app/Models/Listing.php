<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Listing extends Model
{
    protected $fillable = ['address_line_1', 'address_line_2', 'town', 'county', 'postcode', 'no_of_rooms', 'type', 'sale_status', 'latitude', 'longitude'];


    public function landlord() {
        return $this->belongsTo(User::class, 'landlord_id');
    }
}
