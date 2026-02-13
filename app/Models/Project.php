<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'created_by',
    ];    
    
    public function creator(){
        return $this->belongsTo(User::class, 'created_by');
    }

    public function task(){
        return $this->hasMany(Task::class);
    }
}
