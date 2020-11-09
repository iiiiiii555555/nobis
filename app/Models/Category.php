<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table="categories";

    public function createdby_user()
    {
        return $this->belongsTo(User::class,'createdby_user_id');
    }

    public function updatedby_user()
    {
        return $this->belongsTo(User::class,'updateby_user_id');
    }

    public function deletedby_user()
    {
        return $this->belongsTo(User::class,'deletedby_user_id');
    }
}
