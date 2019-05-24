<?php

namespace App\Models\QuotesCompanies;

use Illuminate\Database\Eloquent\Model;
use Wildside\Userstamps\Userstamps;

class QuotesCompany extends Model
{
    use Userstamps;

    protected $guarded = ['id'];
}
