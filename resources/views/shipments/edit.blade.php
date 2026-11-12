@extends('layout')
@php use App\Models\ShipmentModel; @endphp

@section('content')
    <div class="d-flex justify-content-center my-5">
        <div class="card shadow-sm w-100" style="max-width: 800px;">
            <div class="card-body p-4">
                <h1 class="mb-4">Edit Shipment</h1>

                <form action="{{ route('shipments.update', $shipment) }}" method="POST" class="row g-3" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="col-12">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" name="title" id="title"
                               class="form-control @error('title') is-invalid @enderror"
                               value="{{ old('title', $shipment->title) }}">
                        @error('title')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="from_city" class="form-label">From city</label>
                        <input type="text" name="from_city" id="from_city"
                               class="form-control @error('from_city') is-invalid @enderror"
                               value="{{ old('from_city', $shipment->from_city) }}">
                        @error('from_city')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="from_country" class="form-label">From country</label>
                        <input type="text" name="from_country" id="from_country"
                               class="form-control @error('from_country') is-invalid @enderror"
                               value="{{ old('from_country', $shipment->from_country) }}">
                        @error('from_country')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="to_city" class="form-label">To city</label>
                        <input type="text" name="to_city" id="to_city"
                               class="form-control @error('to_city') is-invalid @enderror"
                               value="{{ old('to_city', $shipment->to_city) }}">
                        @error('to_city')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="to_country" class="form-label">To country</label>
                        <input type="text" name="to_country" id="to_country"
                               class="form-control @error('to_country') is-invalid @enderror"
                               value="{{ old('to_country', $shipment->to_country) }}">
                        @error('to_country')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="price" class="form-label">Price</label>
                        <input type="number" step="0.01" name="price" id="price"
                               class="form-control @error('price') is-invalid @enderror"
                               value="{{ old('price', $shipment->price) }}">
                        @error('price')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="user_id" class="form-label">Tracker ID</label>
                        <input type="number" name="user_id" id="user_id"
                               class="form-control @error('user_id') is-invalid @enderror"
                               value="{{ old('user_id', $shipment->user_id) }}">
                        @error('user_id')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="client_id" class="form-label">Client ID</label>
                        <input type="number" name="client_id" id="client_id"
                               class="form-control @error('client_id') is-invalid @enderror"
                               value="{{ old('client_id', $shipment->user_id) }}">
                        @error('client_id')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select @error('status') is-invalid @enderror">
                            @foreach(ShipmentModel::ALLOWED_STATUSES as $status)
                                <option value="{{ $status }}"
                                    @selected(old('status', $shipment->status) === $status)>{{ $status }}</option>
                            @endforeach
                        </select>
                        @error('status')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-md-4">
                        <label for="documents" class="form-label">Add documents</label>
                        <input type="file" name="documents[]" id="documents"
                               class="form-control @error('documents.*') is-invalid @enderror" multiple>
                        @error('documents.*')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12">
                        <label for="details" class="form-label">Details</label>
                        <textarea name="details" id="details" rows="4"
                                  class="form-control @error('details') is-invalid @enderror">{{ old('details', $shipment->details) }}</textarea>
                        @error('details')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="col-12 d-flex justify-content-end gap-2">
                        <a href="{{ route('shipments.index') }}" class="btn btn-secondary">Cancel</a>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
