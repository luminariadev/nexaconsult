<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingPage extends Model
{
    use HasFactory;

    protected $table = 'landing_pages';

    protected $fillable = [
        'user_id',
        'project_id',
        'title',
        'slug',
        'html_content',
        'theme_color',
        'whatsapp_number',
        'status',
    ];

    public function getVirtualIdAttribute(): string
    {
        return (string) $this->id;
    }
}
