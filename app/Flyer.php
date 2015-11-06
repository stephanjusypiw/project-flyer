<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Flyer extends Model
{

    protected $fillable = [
        'street',
        'city',
        'state',
        'country',
        'zip',
        'price',
        'description'
    ];


    public function scopeLocatedAt($query, $zip, $street)
    {
        // replace the - with white spaces so you can query
        // the database
        $street = str_replace('-', ' ', $street);

        return $query->where(compact('zip', 'street'));
    }

    /**
     * @param $price
     * @return string
     *
     * This method is run BEFORE $flyer->price.  It sets the
     * price attribute before it is displayed
     */

    public function getPriceAttribute($price) {
        return '$' . number_format($price);
    }

    /**
     * A Flyer is composed of many photos
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function photos()
    {
        return $this->hasMany('App\Photo');
    }
}
