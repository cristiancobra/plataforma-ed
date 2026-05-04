<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionLocation extends Model
{
    use HasFactory;

    protected $table = 'collection_locations';

    protected $fillable = [
        'collection_id',
        'user_id',
        'location',
        'notes',
        'moved_at',
        'is_current',
    ];

    protected $casts = [
        'moved_at' => 'datetime',
        'is_current' => 'boolean',
    ];

    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
