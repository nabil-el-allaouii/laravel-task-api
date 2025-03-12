<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title','description','due_date','user_id','status'];
    public $timestamps = false;
    public function user(){
        return $this->belongsTo(User::class);
    }
}
