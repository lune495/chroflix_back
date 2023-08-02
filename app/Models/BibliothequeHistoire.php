<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BibliothequeHistoire extends Model
{
    use HasFactory;

    public  function histoire()
    {
        return $this->belongsTo(Histoire::class);
    }

    public  function bibliotheque()
    {
        return $this->belongsTo(Bibliotheque::class);
    }

    public  function user()
    {
        return $this->belongsTo(User::class);
    }
}
