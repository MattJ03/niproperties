<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ListingImage extends Model
{
    protected $fillable = ['listing_id', 'file_path', 'file_type', 'landlord_id'];

    public function listing() {
        return $this->belongsTo(Listing::class);
    }
}
