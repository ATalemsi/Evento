<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'place_number',
        'acceptation',
        'organizer_id',
        'category_id',

    ];
    protected $casts = [
        'date' => 'date',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
    public function acceptation()
    {
        return $this->hasMany(Acceptation::class);
    }

    public function category()
    {
        return $this->belongsTo(Categorie::class);
    }
    public function organizer()
    {
        return $this->belongsTo(User::class, 'organizer_id');
    }
    public function validate()
    {
        $this->validate = true;
        $this->save();
    }
}
