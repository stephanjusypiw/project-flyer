<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model
{

    protected $table = 'flyer_photos';

    protected $fillable = ['path', 'name', 'thumbnail_path'];

    protected $baseDir = 'images/photos';

    /**
     *  A Photo belongs to a Flyer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flyer()
    {
        return $this->belongsTo(Flyer::class);
    }


    public static function named($name)
    {

        return (new static)->saveAs($name);

    }

    public function saveAs($name)
    {

        // concatenate file name with current time to prevent duplicate entries in db
        $this->name = sprintf("%s-%s", time(), $name);
        $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
        $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);

        return $this;


    }

    public function move(UploadedFile $file)
    {
        $file->move($this->baseDir, $this->name);

        $this->makeThumbnail();

        return $this;
    }

    /**
     * Change sizing of thumbnail and save it
     *
     */
    protected function makeThumbnail() {

        Image::make($this->path)
            ->fit(200)
            ->save($this->thumbnail_path);
    }
}
