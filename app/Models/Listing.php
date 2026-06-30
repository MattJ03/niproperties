<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
   use hasFactory;
    protected $fillable = ['address_line_1', 'address_line_2', 'town', 'county', 'postcode', 'price', 'no_of_rooms', 'type', 'sale_status', 'latitude', 'longitude', 'landlord_id'];


    public function landlord() {
        return $this->belongsTo(User::class, 'landlord_id');
    }
}
