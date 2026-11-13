<?php

namespace App\Observers;

use App\Models\ShipmentModel;
use Illuminate\Support\Facades\Cache;

class ShipmentObserver
{
    /**
     * Handle the ShipmentModel "created" event.
     */
    public function created(ShipmentModel $shipment): void
    {
        if ($shipment->status == ShipmentModel::STATUS_UNASSIGNED) {
            Cache::forget('shipments');
        }
    }

    /**
     * Handle the ShipmentModel "updated" event.
     */
    public function updated(ShipmentModel $shipmentModel): void
    {
        Cache::forget('shipments');
    }

    /**
     * Handle the ShipmentModel "deleted" event.
     */
    public function deleted(ShipmentModel $shipmentModel): void
    {
        Cache::forget('shipments');
    }

    /**
     * Handle the ShipmentModel "restored" event.
     */
    public function restored(ShipmentModel $shipmentModel): void
    {
        //
    }

    /**
     * Handle the ShipmentModel "force deleted" event.
     */
    public function forceDeleted(ShipmentModel $shipmentModel): void
    {
        //
    }
}
