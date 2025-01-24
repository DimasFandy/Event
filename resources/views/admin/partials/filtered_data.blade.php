@if($filteredData->isEmpty())
    <div class="alert alert-warning text-center">
        <p class="mb-0">No events found for the selected categories.</p>
    </div>
@else
    <div class="row justify-content-center">
        @foreach($filteredData as $event)
            <div class="col-lg-4 col-md-6 col-sm-12 d-flex mb-4">
                <div class="card shadow-sm h-100 w-100" style="min-height: 280px;">
                    <div class="card-header bg-primary text-white text-center">
                        <h5 class="mb-0">{{ $event->name ?? 'N/A' }}</h5>
                    </div>
                    <div class="card-body">
                        <p>
                            <i class="bi bi-calendar-event"></i>
                            <strong>Start Date:</strong>
                            {{ \Carbon\Carbon::parse($event->start_date)->format('d M Y') ?? 'No start date available' }}
                        </p>
                        <p>
                            <i class="bi bi-calendar2-check"></i>
                            <strong>End Date:</strong>
                            {{ \Carbon\Carbon::parse($event->end_date)->format('d M Y') ?? 'No end date available' }}
                        </p>
                        <p>
                            <i class="bi bi-info-circle"></i>
                            {{ $event->description ?? 'No description available' }}
                        </p>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endif
