@extends('layout')

@section('content')
<div>
    {{$shipment->from_city}}
    {{$shipment->to_city}}
</div>
    <div>
        @foreach($shipment->getDocuments as $document)
            <a href="/storage/documents/{{$document->document_name}}">{{$document->document_name}}</a><br>
        @endforeach
    </div>
@endsection
