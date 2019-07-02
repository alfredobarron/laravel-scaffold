<?php

namespace App\Models\Quotes;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Quotes extends Model
{
    use Userstamps;

    protected $guarded = ['id'];

    public function artist()
    {
        return $this->belongsTo('App\User', 'artist_id');
    }

    public function agent()
    {
        return $this->belongsTo('App\User', 'agent_id');
    }
}
