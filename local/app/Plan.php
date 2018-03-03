<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
use Spatie\Activitylog\LogsActivityInterface;
use Spatie\Activitylog\Traits\LogsActivity;

class Plan extends Model
{

	  use LogsActivity;
    protected $table = 'plans';
    protected static $logAttributes = ['title', 'name', 'slug', 'amount', 'type'];


    /**
     * Specify the specific log name for this module
     * @param  string $eventName [description]
     * @return [type]            [description]
     */
    public function getLogNameToUse(string $eventName = ''): string
    {
        return 'plans_module';
    }

  
}
