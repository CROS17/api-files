<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Fichero extends Model
{
    use HasFactory;

    protected $table = 'ficheros';

    protected $fillable = [
        'description',
        'file'
    ];

    public function scopeSearching($query, $que)
    {
        if ($que) {
            return $query->where('id', 'like', "%$que%")
                ->orWhere('description', 'like', "%$que%");
        }
    }

}
