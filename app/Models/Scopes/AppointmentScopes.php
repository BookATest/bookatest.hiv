<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;

trait AppointmentScopes
{
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param bool $available
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeAvailable(Builder $query, bool $available = true): Builder
    {
        return $available
            ? $query->whereNull('appointments.service_user_id')
            : $query->whereNotNull('appointments.service_user_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param bool $booked
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeBooked(Builder $query, bool $booked = true): Builder
    {
        return $booked
            ? $query->whereNotNull('appointments.service_user_id')
            : $query->whereNull('appointments.service_user_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFuture(Builder $query): Builder
    {
        return $query->where('appointments.start_at', '>', now());
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeThisWeek(Builder $query): Builder
    {
        return $query->whereBetween('appointments.start_at', [today()->startOfWeek(), today()->endOfWeek()]);
    }
}
