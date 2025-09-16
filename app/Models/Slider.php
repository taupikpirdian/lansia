<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    protected $table = 'sliders';
    protected $fillable = [
        'name', 
        'description', 
        'image', 
        'link',
        'background_image',
        'background_image_url',
        'person1_image',
        'person1_image_url',
        'person1_name',
        'person1_position',
        'person2_image',
        'person2_image_url',
        'person2_name',
        'person2_position',
        'person3_image',
        'person3_image_url',
        'person3_name',
        'person3_position'
    ];
}