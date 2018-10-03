<?php

namespace App\Http\Controllers\V1;

use App\Events\EndpointHit;
use App\Http\Requests\Clinic\{IndexRequest, StoreRequest};
use App\Http\Resources\ClinicResource;
use App\Models\Clinic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\QueryBuilder\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class ClinicController extends Controller
{
    /**
     * ClinicController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth:api')->except('index', 'show');
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Http\Requests\Clinic\IndexRequest $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(IndexRequest $request)
    {
        // Prepare the base query.
        $baseQuery = Clinic::query();

        // Specify allowed modifications to the query via the GET parameters.
        $clinics = QueryBuilder::for($baseQuery)
            ->defaultSort('name')
            ->allowedSorts('name')
            ->allowedFilters(
                Filter::exact('id')
            )
            ->paginate();

        event(EndpointHit::onRead($request, 'Listed all clinics'));

        return ClinicResource::collection($clinics);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\Clinic\StoreRequest $request
     * @return \App\Http\Resources\ClinicResource
     */
    public function store(StoreRequest $request)
    {
        $clinic = DB::transaction(function () use ($request) {
            return Clinic::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address_line_1' => $request->address_line_1,
                'address_line_2' => $request->address_line_2,
                'address_line_3' => $request->address_line_3,
                'city' => $request->city,
                'postcode' => $request->postcode,
                'directions' => $request->directions,
                'appointment_duration' => $request->appointment_duration,
                'appointment_booking_threshold' => $request->appointment_booking_threshold,
            ]);
        });

        event(EndpointHit::onCreate($request, "Created clinic [{$clinic->id}]"));

        return new ClinicResource($clinic);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function show(Clinic $clinic)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Clinic $clinic)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Clinic  $clinic
     * @return \Illuminate\Http\Response
     */
    public function destroy(Clinic $clinic)
    {
        //
    }
}