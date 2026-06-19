<div class="grid gap-4">
    @foreach($requests as $req)
    <div class="flex items-center justify-between bg-white p-4 rounded shadow-sm border">
        <div>
            <h4 class="font-bold text-gray-800">{{ $req->document_type }}</h4>
            <p class="text-sm text-gray-500">Requested by: {{ $req->user->name }}</p>
            <p class="text-xs italic text-gray-400">Purpose: {{ $req->purpose }}</p>
        </div>
        <div class="flex items-center gap-3">
            <span class="px-3 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">
                {{ strtoupper($req->status) }}
            </span>
            <form action="{{ route('admin.requests.update', $req->id) }}" method="POST">
                @csrf @method('PATCH')
                <button class="bg-green-600 text-white px-3 py-1 rounded text-sm hover:bg-green-700">
                    Mark as Ready
                </button>
            </form>
        </div>
    </div>
    @endforeach
</div>