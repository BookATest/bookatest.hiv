<?php

namespace App\Docs\Paths;

use App\Docs\Requests;
use App\Docs\Resources\BaseResource;
use App\Docs\Resources\ClinicResource;
use App\Docs\Responses;
use App\Docs\Tags;
use GoldSpecDigital\ObjectOrientedOAS\Objects\MediaType;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Operation;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Parameter;
use GoldSpecDigital\ObjectOrientedOAS\Objects\Schema;

class Clinics
{
    /**
     * Clinic constructor.
     */
    protected function __construct()
    {
        // Prevent instantiation.
    }

    /**
     * @return \GoldSpecDigital\ObjectOrientedOAS\Objects\Operation
     */
    public static function index(): Operation
    {
        $responses = [
            Responses::http200(
                MediaType::json(ClinicResource::list())
            ),
        ];

        return Operation::get(...$responses)
            ->summary('List all clinics')
            ->description('**Permission:** `Open`')
            ->operationId('clinics.index')
            ->tags(Tags::clinics()->name);
    }

    /**
     * @return \GoldSpecDigital\ObjectOrientedOAS\Objects\Operation
     */
    public static function store(): Operation
    {
        $responses = [
            Responses::http201(
                MediaType::json(ClinicResource::show())
            ),
        ];
        $requestBody = Requests::json(
            Schema::object()
                ->required(
                    'name',
                    'phone',
                    'email',
                    'address_line_1',
                    'address_line_2',
                    'address_line_3',
                    'city',
                    'postcode',
                    'directions'
                )
                ->properties(
                    Schema::string('name'),
                    Schema::string('phone'),
                    Schema::string('email'),
                    Schema::string('address_line_1'),
                    Schema::string('address_line_2')->nullable(),
                    Schema::string('address_line_3')->nullable(),
                    Schema::string('city'),
                    Schema::string('postcode'),
                    Schema::string('directions'),
                    Schema::integer('appointment_duration'),
                    Schema::integer('appointment_booking_threshold')
                )
        );

        return Operation::post(...$responses)
            ->requestBody($requestBody)
            ->summary('Create a new clinic')
            ->description('**Permission:** `Organisation Admin`')
            ->operationId('clinics.store')
            ->tags(Tags::clinics()->name);
    }

    /**
     * @return \GoldSpecDigital\ObjectOrientedOAS\Objects\Operation
     */
    public static function show(): Operation
    {
        $responses = [
            Responses::http200(
                MediaType::json(ClinicResource::show())
            ),
        ];
        $parameters = [
            Parameter::path('clinic', Schema::string()->format(Schema::UUID))
                ->description('The clinic ID')
                ->required(),
        ];

        return Operation::get(...$responses)
            ->parameters(...$parameters)
            ->summary('Get a specific clinic')
            ->description('**Permission:** `Open`')
            ->operationId('clinics.show')
            ->tags(Tags::clinics()->name);
    }

    /**
     * @return \GoldSpecDigital\ObjectOrientedOAS\Objects\Operation
     */
    public static function update(): Operation
    {
        $responses = [
            Responses::http200(
                MediaType::json(ClinicResource::show())
            ),
        ];
        $parameters = [
            Parameter::path('clinic', Schema::string()->format(Schema::UUID))
                ->description('The clinic ID')
                ->required(),
        ];
        $requestBody = Requests::json(
            Schema::object()
                ->required(
                    'name',
                    'phone',
                    'email',
                    'address_line_1',
                    'address_line_2',
                    'address_line_3',
                    'city',
                    'postcode',
                    'directions'
                )
                ->properties(
                    Schema::string('name'),
                    Schema::string('phone'),
                    Schema::string('email'),
                    Schema::string('address_line_1'),
                    Schema::string('address_line_2')->nullable(),
                    Schema::string('address_line_3')->nullable(),
                    Schema::string('city'),
                    Schema::string('postcode'),
                    Schema::string('directions'),
                    Schema::integer('appointment_duration'),
                    Schema::integer('appointment_booking_threshold')
                )
        );

        return Operation::put(...$responses)
            ->parameters(...$parameters)
            ->requestBody($requestBody)
            ->summary('Updated a specific clinic')
            ->description(<<<EOT
**Permission:** `Clinic Admin`
* Update a clinic they are a `Clinic Admin` for
EOT
            )
            ->operationId('clinics.update')
            ->tags(Tags::clinics()->name);
    }

    /**
     * @return \GoldSpecDigital\ObjectOrientedOAS\Objects\Operation
     */
    public static function destroy(): Operation
    {
        $responses = [
            Responses::http200(
                MediaType::json(BaseResource::deleted())
            ),
        ];
        $parameters = [
            Parameter::path('clinic', Schema::string()->format(Schema::UUID))
                ->description('The clinic ID')
                ->required(),
        ];

        return Operation::delete(...$responses)
            ->parameters(...$parameters)
            ->summary('Delete a specific clinic')
            ->description(<<<EOT
**Permission:** `Organisation Admin`

***

This only soft deletes the clinic.
EOT
            )
            ->operationId('clinics.destroy')
            ->tags(Tags::clinics()->name);
    }
}
