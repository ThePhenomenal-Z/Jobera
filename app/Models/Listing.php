<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Listing extends Model
{
    use HasFactory;
    // another way for mass assignment
    // protected $fillable=['title','company','location','wrbsite',
    // 'email','tags','description'];

    public function scopeFilter($query, array $filters){
        // if $filters['tags'] is not null
        if($filters['tags']?? False){
            $query->where('tags','like','%'. request('tags') .'%');
        }

        if($filters['search']?? False){
            $query->where('tags','like','%'. request('search') .'%')
                ->orwhere('title','like','%'. request('search') .'%')
                ->orwhere('description','like','%'. request('search') .'%')
                ->orwhere('location','like','%'. request('search') .'%')
            ;
        }
    }
    // Relationship To user
    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }
}
