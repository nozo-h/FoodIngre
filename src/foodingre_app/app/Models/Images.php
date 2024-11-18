<?php

namespace App\Models;

use App\Models\Posts;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Images extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'post_id',
        'url',
        'filename',
        'sort_no',
    ];

    public function post()
    {
        return $this->belongsTo(Posts::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
