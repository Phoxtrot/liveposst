<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title', 'body'];
    protected $casts = [
        'body' => 'array'
    ];
    // Accessors for changing the default title to UpperCase
    public function getTitleUpperCaseAttribute()
    {
        return strtoupper($this->title);
    }
    // Mutator for Setting the Title to UpperCase
    public function setTitleAttribute($value)
    {
        $this->attributes ['title'] = strtolower($value);
    }
   public function comments()
   {
        return $this->hasMany(Comment::class);
   }
   public function users()
   {
    return $this->belongsToMany(User::class);
   }
}
