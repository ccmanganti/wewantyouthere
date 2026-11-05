<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WeddingMessageTemplate extends Model
{
    protected $fillable = ['category', 'content', 'content_hash'];
}
