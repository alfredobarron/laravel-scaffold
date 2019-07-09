<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Event extends Model
{
    use Userstamps;

    protected $guarded = ['id'];

    protected $appends = ['startDate'];

    public function artist()
    {
        return $this->belongsTo('App\User', 'artist_id');
    }

    public function getstartDateAttribute()
    {
        return $this->attributes['schedule'];
    }
}
