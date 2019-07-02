<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Event extends Model
{
    use Userstamps;

    protected $guarded = ['id'];

    protected $appends = ['startDate'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function getstartDateAttribute()
    {
        return $this->attributes['date'];
    }
}
