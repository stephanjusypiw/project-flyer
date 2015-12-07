<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Intervention\Image\Facades\Image;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class Photo extends Model
{

    protected $table = 'flyer_photos';

    protected $fillable = ['path', 'name', 'thumbnail_path'];

    protected $file;

//    protected $baseDir = 'images/photos';

    protected static function boot()
    {
        static::creating(function ($photo) {
            return $photo->upload();
        });
    }

    /**
     *  A Photo belongs to a Flyer
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function flyer()
    {
       // return $this->belongsTo(Flyer::class);
        return $this->belongsTo('App\Flyer');
    }

    public static function fromFile(UploadedFile $file)
    {
        $photo = new static;

        $photo->file = $file;

        return $photo->fill([
            'name'  => $photo->fileName(),
            'path'  => $photo->filePath(),
            'thumbnail_path'    => $photo->thumbnailPath()
        ]);

    }

    public function fileName()
    {
        $name = sha1(
            time(). $this->file->getClientOriginalName()
        );

        $extension = $this->file->getClientOriginalExtension();

        return "{$name}.{$extension}";
    }

    public function filePath()
    {
        return $this->baseDir() .'/'. $this->fileName();
    }

    public function thumbnailPath()
    {
        return $this->baseDir() .'/tn-'. $this->fileName();
    }

    public function baseDir()
    {
        return 'images/photos';
    }


//    public static function named($name)
//    {
//
//        return (new static)->saveAs($name);
//
//    }

//    public function saveAs($name)
//    {
//
//        // concatenate file name with current time to prevent duplicate entries in db
//        $this->name = sprintf("%s-%s", time(), $name);
//        $this->path = sprintf("%s/%s", $this->baseDir, $this->name);
//        $this->thumbnail_path = sprintf("%s/tn-%s", $this->baseDir, $this->name);
//
//        return $this;
//
//
//    }

    public function upload()
    {
        $this->file->move($this->baseDir(), $this->fileName());

        $this->makeThumbnail();

        return $this;
    }

    /**
     * Change sizing of thumbnail and save it
     *
     */
    protected function makeThumbnail() {

        Image::make($this->filePath())
            ->fit(200)
            ->save($this->thumbnailPath());
    }
}
