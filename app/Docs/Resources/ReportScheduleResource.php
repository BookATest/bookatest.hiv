<?php

namespace App\Docs\Resources;

use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class ReportScheduleResource extends BaseResource
{
    /**
     * @return \GoldSpecDigital\ObjectOrientedOAS\Objects\Schema
     */
    public static function resource(): Schema
    {
        return Schema::object()->properties(
            Schema::string('id')->format(Schema::UUID),
            Schema::string('user_id')->format(Schema::UUID),
            Schema::string('clinic_id')->format(Schema::UUID)->nullable(),
            Schema::string('report_type')->enum('Report Type 1', 'Report Type 2'),
            Schema::string('repeat_type')->enum('weekly', 'monthly'),
            Schema::string('created_at')->format('date-time'),
            Schema::string('updated_at')->format('date-time')
        );
    }
}