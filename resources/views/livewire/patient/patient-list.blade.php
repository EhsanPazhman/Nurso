<div class="space-y-6">

    <div class="flex justify-between items-center">
        <h1 class="text-2xl font-bold text-slate-800">Patients</h1>

        @can('patient.create')
            <a href="{{ route('patients.create') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm font-semibold">
                Add Patient
            </a>
        @endcan
    </div>

    <div class="bg-white rounded-xl border">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b bg-slate-50">
                    <th class="p-3 text-left">Name</th>
                    <th class="p-3 text-left">Phone</th>
                    <th class="p-3 text-left">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($patients as $patient)
                    <tr class="border-b">
                        <td class="p-3">{{ $patient->full_name }}</td>
                        <td class="p-3">{{ $patient->phone }}</td>
                        <td class="p-3 flex gap-2">

                            @can('patient.update')
                                <a href="{{ route('patients.edit', $patient->id) }}" class="text-blue-600 text-xs">Edit</a>
                            @endcan

                            @can('patient.delete')
                                <button class="text-red-600 text-xs">Delete</button>
                            @endcan

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="p-6 text-center text-slate-400">
                            No patients found
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>
        {{ $patients->links() }}
    </div>

</div>
