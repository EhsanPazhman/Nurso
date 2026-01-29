<div>
    <div class="d-flex mb-3">
        <input type="text" class="form-control" placeholder="Search patient..." wire:model.debounce.500ms="search" />
    </div>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Full Name</th>
                <th>Gender</th>
                <th>Phone</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($patients['data'] ?? [] as $patient)
                <tr>
                    <td>{{ $patient['id'] }}</td>
                    <td>{{ $patient['first_name'] }} {{ $patient['last_name'] }}</td>
                    <td>{{ ucfirst($patient['gender']) }}</td>
                    <td>{{ $patient['phone'] ?? '-' }}</td>
                    <td>{{ ucfirst($patient['status']) }}</td>
                    <td>
                        <a href="{{ route('patients.edit', $patient['id']) }}" class="btn btn-sm btn-primary">
                            Edit
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
