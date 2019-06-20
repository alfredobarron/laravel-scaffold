<?php

namespace App\Models\Quotes;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class Quotes extends Model
{
    use Userstamps;

    protected $guarded = ['id'];
}
