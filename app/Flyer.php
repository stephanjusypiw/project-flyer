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


    /**
     *
     * Find flyer at the given address
     *
     * @param $zip
     * @param $street
     * @return mixed
     */
    public static function locatedAt($zip, $street)
    {
        // replace the - with white spaces so you can query
        // the database
        $street = str_replace('-', ' ', $street);

        return static::where(compact('zip', 'street'))->firstOrFail();
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



    public function addPhoto(Photo $photo)
    {
        return $this->photos()->save($photo);
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
