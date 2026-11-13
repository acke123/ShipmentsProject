@php use App\Models\ShipmentModel; @endphp
@extends('layout')

@section('content')
    <h1 class="mb-4">Shipments</h1>

    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xxl-6 g-3">
        @foreach($shipments as $shipment)
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $shipment->title }}</h5>

                        <p class="small text-muted mb-2">
                            {{ $shipment->from_city }}, {{ $shipment->from_country }}
                            <br>→ {{ $shipment->to_city }}, {{ $shipment->to_country }}
                        </p>

                        <p class="card-text small">{{ $shipment->details }}</p>

                        <div class="mt-auto d-flex justify-content-between align-items-center">
                            <strong>{{ $shipment->price }} €</strong>
                            @php
                                $statusColors = [
                                    ShipmentModel::STATUS_UNASSIGNED    => 'warning',
                                     ShipmentModel::STATUS_IN_PROGRESS => 'info',
                                     ShipmentModel::STATUS_COMPLETED  => 'success',
                                     ShipmentModel::STATUS_PROBLEM  => 'danger',
                                ];
                            @endphp

                            <span class="badge bg-{{ $statusColors[$shipment->status] ?? 'secondary' }}">
    {{ $shipment->status }}
</span>
                        </div>

                        <div class="small text-muted mb-1 mt-2">
                            <a class="btn btn-info" href="{{route('shipments.show', ['shipment' => $shipment->id])}}">View shipment</a>
                        </div>

                        <form method="POST" action="{{route('shipments.assignedUser', ['shipment' => $shipment->id])}}">
                            @csrf
                            <select name="user_id">
                                <option value="0" selected disabled>None</option>
                                @foreach(\App\Models\User::all() as $user)
                                    <option value="{{$user->id}}">{{$user->name}}</option>
                                @endforeach
                            </select>
                            <button>Assigned user</button>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
