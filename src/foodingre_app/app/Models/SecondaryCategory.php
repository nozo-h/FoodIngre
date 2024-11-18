<?php

namespace App\Models;

use App\Models\Posts;
use App\Models\PrimaryCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SecondaryCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'primary_category_id',
        'secondary_id',
        'name',
        'sort_no',
        'created_at'
    ];

    public function primaryCategory()
    {
        return $this->belongsTo(PrimaryCategory::class);
    }

    public function posts()
    {
        return $this->hasMany(Posts::class);
    }
}