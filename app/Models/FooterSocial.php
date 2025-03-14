<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterSocial extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'facebook_url',
        'instagram_url',
        'twitter_url'
    ];
}