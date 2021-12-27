<?php
namespace App\Services;

use Illuminate\Support\Facades\Storage;

class ProductServices
{

    protected $request;

    public function __construct()
    {
        $this->request = app('request');
    }

    public function image()
    {
        if ($this->request->hasFile('image'))
        {
            $imagePath = $this->request->file('image')->store('public');
            $imageName = (explode('/', $imagePath))[1];
            $host = $_SERVER['HTTP_HOST'];
            $protocol = $_SERVER['PROTOCOL'] = isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
            $path = $protocol . $host . "/public/storage/" . $imageName;
            return ['image' => $path];
        }
        else
        {
            return [];
        }
    }

    public function imageDelete($image)
    {
        if($image)
        {
            $delete_imageArr = (explode('/', $image));
            $delete_image = end($delete_imageArr);
            Storage::delete("public/" . $delete_image);
        }
    }
}
