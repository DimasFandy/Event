<div class="row">
    @foreach($filteredData as $event)
        <div class="col-md-4">
            <div class="card mb-3">
                <div class="card-header">{{ $event->name }}</div>
                <div class="card-body">
                    <p>{{ $event->date }}</p>
                    <p>{{ $event->description }}</p>
                </div>
            </div>
        </div>
    @endforeach
</div>

