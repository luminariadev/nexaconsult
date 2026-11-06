<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $table = 'projects';

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'user_prompt',
        'tasks',
        'status'
    ];

    protected $casts = [
        'tasks' => 'array',
    ];

    protected $appends = ['_id'];

    public function get_IdAttribute()
    {
        return (string) $this->id;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
