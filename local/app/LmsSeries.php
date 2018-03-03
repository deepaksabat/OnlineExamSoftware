<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class LmsSeries extends Model
{
   protected $table = 'lmsseries';

   

    public static function getRecordWithSlug($slug)
    {
        return LmsSeries::where('slug', '=', $slug)->first();
    }

    /**
     * This method lists all the items available in selected series
     * @return [type] [description]
     */
    public function getContents()
    {
        return DB::table('lmsseries_data')
          ->join('lmscontents', 'lmscontents.id', '=', 'lmscontent_id')
            ->where('lmsseries_id', '=', $this->id)->get();
    }
}
