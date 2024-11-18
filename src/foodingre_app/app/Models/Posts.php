<?php

namespace App\Models;

use App\Models\Images;
use App\Models\User;
use App\Models\SecondaryCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Posts extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'secondary_category_id',
        'food_label',
        'product_name',
        'ingredient',
        'amount',
        'manufacture',
        'per_gram',
        'calories',
        'proteins',
        'fat',
        'carbohydrates',
        'salt',
        'other',
        'remarks',
        'image_first',
        'image_second',
        'image_third',
        'image_fourth',
        'publication_status',
    ];

    // public function image()
    // {
    //     return $this->hasMany(Images::class);
    // }

    public function imageFirst()
    {
        return $this->hasOne(Images::class, 'id', 'image_first')->where('sort_no', 0);
    }

    public function imageSecond()
    {
        return $this->hasOne(Images::class,  'id','image_second')->where('sort_no', 1);
    }

    public function imageThird()
    {
        return $this->hasOne(Images::class, 'id', 'image_third')->where('sort_no', 2);
    }

    public function imageFourth()
    {
        return $this->hasOne(Images::class,  'id','image_fourth')->where('sort_no', 3);
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function secondaryCategory()
    {
        return $this->belongsTo(SecondaryCategory::class);
    }

}
