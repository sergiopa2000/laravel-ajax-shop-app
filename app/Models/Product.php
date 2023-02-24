<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    
    protected $table = 'product';
    
    protected $fillable = ['name', 'price', 'description', 'idCategory'];
    
    public function category() {
        return $this->belongsTo('App\Models\Category', 'idCategory');
    }
    
    public function tags() {
        return $this->belongsToMany('App\Models\Tag', 'product_tag', 'idProduct', 'idTag');
    }
    
    public function colors() {
        return $this->belongsToMany('App\Models\Color', 'product_color', 'idProduct', 'idColor');
    }
    
    public function images() {
        return $this->hasMany('App\Models\Image', 'idProduct');
    }
}
