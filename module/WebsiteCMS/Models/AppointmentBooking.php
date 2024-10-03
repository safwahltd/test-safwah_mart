<?php

namespace Module\WebsiteCMS\Models;

use App\Model;

class AppointmentBooking extends Model
{
    protected $table = 'web_appointment_bookings';

    protected $guarded = [];



    public function scopeApiQuery($query)
    {
        $query;
    }




    public static function getTableName()
    {
        return with(new static)->getTable();
    }





}
