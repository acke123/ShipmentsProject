<?php

namespace App\Http\Controllers;

use App\Http\Requests\NewShipmentRequest;
use App\Http\Requests\UpdateShippmentRequest;
use App\Models\ShipmentDocumentsModel;
use App\Models\ShipmentModel;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Cache;

class ShipmentController extends Controller
{
    use ImageUploadTrait;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $shipments = Cache::remember('shipments', 60,
            fn() => ShipmentModel::where(['status' => ShipmentModel::STATUS_UNASSIGNED])->get());
        return view('shipments.index', ['shipments' => $shipments]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('shipments.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(NewShipmentRequest $request)
    {
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
                    'document_name' => $filename,
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
        return view('shipments.show', ['shipment' => $shipment]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ShipmentModel $shipment)
    {
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
}
