<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Couponcode extends Model
{
     protected $table= "couponcodes";

    
    public static function getRecordWithSlug($slug)
    {
        return Couponcode::where('slug', '=', $slug)->first();
    }

    /**
     * Check the validity of the coupon by comparing the code string,
     * Start and End date for that coupon
     * @param  [type] $code [description]
     * @return [type]       [description]
     */
    public function checkValidity($code, $item_type='exam')
    {
        $coupon_record = Couponcode::where('coupon_code', '=', $code)->first();
        $applicable_categories = [];
        if(!$coupon_record)
            return FALSE;
        if($coupon_record->coupon_code_applicability)
        {
            $applicable_categories = (array) json_decode($coupon_record->coupon_code_applicability)->categories;
        }

    	$record = Couponcode::where('coupon_code', '=', $code)
    						->where('valid_from','<=',date('Y-m-d'))
    						->where('valid_to', '>=', date('Y-m-d'))
                            ->where('status','=','Active')
                           ->first();
                           // return $record;
        if($record)
        {
            if(in_array($item_type, $applicable_categories))
                return $record;
        }
        // return FALSE;
    }
}
