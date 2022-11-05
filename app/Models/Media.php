<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Media extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'media';

    protected $fillable = [
        'url'
    ];

    public function scopeSearching($query, $que)
    {
        if ($que) {
            return $query->where('id', 'like', "%$que%")
                ->orWhere('url', 'like', "%$que%");
        }
    }

}
