<?php

namespace App\Observers;

use App\Models\Nota;

class NotaObserver
{
    /**
     * Handle the Nota "created" event.
     */
    public function created(Nota $nota): void
    {
        //
    }

    /**
     * Handle the Nota "updated" event.
     */
    public function updated(Nota $nota): void
    {
        //
    }

    /**
     * Handle the Nota "deleted" event.
     */
    public function deleted(Nota $nota): void
    {
        //
    }

    /**
     * Handle the Nota "restored" event.
     */
    public function restored(Nota $nota): void
    {
        //
    }

    /**
     * Handle the Nota "force deleted" event.
     */
    public function forceDeleted(Nota $nota): void
    {
        //
    }
}
