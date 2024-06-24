<?php

namespace App\Observers;

use App\Models\HProduct;

class HProductObserver
{
    /**
     * Handle the HProduct "created" event.
     */
    public function created(HProduct $hProduct): void
    {
        //
    }

    /**
     * Handle the HProduct "updated" event.
     */
    public function updated(HProduct $hProduct): void
    {
        //
    }

    /**
     * Handle the HProduct "deleted" event.
     */
    public function deleted(HProduct $hProduct): void
    {
        //
    }

    /**
     * Handle the HProduct "restored" event.
     */
    public function restored(HProduct $hProduct): void
    {
        //
    }

    /**
     * Handle the HProduct "force deleted" event.
     */
    public function forceDeleted(HProduct $hProduct): void
    {
        //
    }
}
