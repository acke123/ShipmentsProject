<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewShipmentRequest;
use App\Http\Requests\UpdateShippmentRequest;
use App\Models\ShipmentDocumentsModel;
use App\Models\ShipmentModel;
use App\Models\User;
use App\Traits\ImageUploadTrait;
use http\Env\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Gate;

class ShipmentController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = Cache::remember('shipments', 10,
            fn() => ShipmentModel::UnassignedShipments()->get());
        return view('shipments.index', ['shipments' => $shipments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Gate::authorize('canViewCreationPage', ShipmentModel::class);
        return view('shipments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewShipmentRequest $request)
    {
        Gate::authorize('create', ShipmentModel::class);

        $shipment = ShipmentModel::create($request->validated());

        $fileTypes = [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ];

        foreach ($request->file('documents') as $document) {
            if (str_starts_with($document->getMimeType(), 'image/')) {
                $imageName = $this->uploadImage($document, "documents/{$shipment->id}/");

                $imageName = "{$shipment->id}/" . $imageName;
                ShipmentDocumentsModel::create([
                    'shipment_id' => $shipment->id,
                    'document_name' => $imageName,
                ]);
            } elseif (in_array($document->getMimeType(), $fileTypes)) {
                $extension = $document->getClientOriginalExtension();
                $filename = uniqid() . '.' . $extension;

                $path = $document->storeAs("documents/{$shipment->id}/", $filename, 'public');
                $path = str_replace('documents/', '', $path);

                ShipmentDocumentsModel::create([
                    'shipment_id' => $shipment->id,
                    'document_name' => $path,
                ]);
            }
        }
        return redirect()->route('shipments.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(ShipmentModel $shipment)
    {
        Gate::authorize('view', $shipment);
        return view('shipments.show', ['shipment' => $shipment]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShipmentModel $shipment)
    {
        Gate::authorize('canViewEdit', ShipmentModel::class);
        return view('shipments.edit', ['shipment' => $shipment]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShippmentRequest $request, ShipmentModel $shipment)
    {
        $shipment->update($request->validated());
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ShipmentModel $shipmentsModel)
    {
        //
    }

    public function assignedUser(\Illuminate\Http\Request $request, ShipmentModel $shipment)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $shipment->user_id = $request->user_id;
        $shipment->status = ShipmentModel::STATUS_IN_PROGRESS;
        $shipment->save();

        return redirect()->back();
    }
}
