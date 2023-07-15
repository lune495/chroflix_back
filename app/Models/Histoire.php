<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Histoire extends Model
{
    use HasFactory;

    public function chapitres()
    {
        return $this->hasMany(Chapitre::class);
    }

    public function bibliotheque_histoires()
    {
        return $this->hasMany(BibliothequeHistoire::class);
    }
    
    public function commandes()
    {
        return $this->hasMany(Commande  ::class);
    }
}