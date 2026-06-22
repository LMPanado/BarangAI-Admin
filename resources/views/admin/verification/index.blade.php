@extends('layouts.admin')

@section('content')
<div class="space-y-8 pb-12 max-w-[1600px] mx-auto">

    {{-- Page Header --}}
    <div class="flex justify-between items-center border-b border-gray-100 pb-6">
        <div>
            <h1 class="text-2xl font-extrabold text-gray-800 tracking-tight">Account Verification</h1>
            <p class="text-sm text-gray-500 mt-1 font-medium">
                Review and verify resident accounts for
                <span class="text-brgyGreen font-bold">Barangay 419</span>.
            </p>
        </div>
        <nav class="flex items-center space-x-2 text-xs font-semibold uppercase tracking-wider">
            <span class="text-gray-400">Home</span>
            <svg class="w-3 h-3 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
            </svg>
            <span class="text-brgyGreen">Verification</span>
        </nav>
    </div>

    {{-- Summary Bar --}}
    <div class="flex items-center gap-4">
        <div class="bg-white rounded-[1.5rem] border border-gray-100 shadow-sm px-6 py-4 flex items-center gap-4">
            <div class="p-3 bg-amber-50 rounded-2xl">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-[9px] font-black text-gray-400 uppercase tracking-[0.2em]">Pending Verification</p>
                <p class="text-2xl font-extrabold text-amber-600 tracking-tight">{{ $pendingCount }}</p>
            </div>
        </div>

        {{-- Search --}}
        <form method="GET" action="{{ route('admin.verification.index') }}" class="flex-1 max-w-sm">
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}"
                       placeholder="Search by name or email..."
                       class="w-full pl-11 pr-4 py-3 bg-white border-2 border-gray-100 rounded-2xl text-sm font-bold text-gray-700 focus:bg-white focus:border-brgyGreen focus:ring-4 focus:ring-brgyGreen/5 outline-none transition-all placeholder:text-gray-300">
            </div>
        </form>

        @if(request('search'))
            <a href="{{ route('admin.verification.index') }}"
               class="px-4 py-3 text-[10px] font-black uppercase tracking-widest rounded-2xl border-2 border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600 transition-all">
                Clear
            </a>
        @endif
    </div>

    {{-- Cards Grid --}}
    @if($pendingUsers->isEmpty())
        <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm py-24 text-center">
            <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-brgyGreen" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p class="text-[10px] font-black text-gray-300 uppercase tracking-widest">All caught up! No pending verifications.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            @foreach($pendingUsers as $user)
            <div class="bg-white rounded-[2rem] border border-gray-100 shadow-sm overflow-hidden"
                 id="verification-card-{{ $user->id }}">

                {{-- Card Header --}}
                <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-amber-50 flex items-center justify-center font-black text-amber-600 text-sm">
                            {{ strtoupper(substr($user->first_name ?? $user->email, 0, 1)) }}
                        </div>
                        <div>
                            <p class="text-sm font-extrabold text-gray-800">
                                {{ trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? '')) ?: 'Unknown Name' }}
                            </p>
                            <p class="text-[10px] text-gray-400 font-medium mt-0.5">{{ $user->email }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 rounded-full text-[9px] font-black uppercase tracking-widest bg-amber-50 text-amber-600">
                        Pending
                    </span>
                </div>

                {{-- Resident Details --}}
                <div class="px-6 py-4 grid grid-cols-3 gap-3 border-b border-gray-50">
                    @foreach([
                        ['label' => 'Age',    'value' => $user->age ?? '—'],
                        ['label' => 'Gender', 'value' => $user->gender ?? '—'],
                        ['label' => 'Phone',  'value' => $user->phone ?? '—'],
                    ] as $detail)
                    <div>
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">{{ $detail['label'] }}</p>
                        <p class="text-xs font-bold text-gray-700 mt-0.5">{{ $detail['value'] }}</p>
                    </div>
                    @endforeach
                    @if($user->verification_submitted_at)
                    <div class="col-span-3">
                        <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Submitted</p>
                        <p class="text-xs font-bold text-gray-500 mt-0.5">
                            {{ \Carbon\Carbon::parse($user->verification_submitted_at)->format('M d, Y · h:i A') }}
                        </p>
                    </div>
                    @endif
                </div>

                {{-- ID Photos --}}
                <div class="px-6 py-5 grid grid-cols-2 gap-4 border-b border-gray-50">
                    {{-- Valid ID --}}
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Valid ID</p>
                        @if($user->valid_id_image)
                            <button onclick="openLightbox('{{ addslashes($user->valid_id_image) }}', 'Valid ID — {{ addslashes(trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''))) }}')"
                                    class="w-full group relative overflow-hidden rounded-2xl border-2 border-gray-100 hover:border-brgyGreen/30 transition-all">
                                <img src="{{ $user->valid_id_image }}"
                                     alt="Valid ID"
                                     class="w-full h-32 object-cover group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </button>
                        @else
                            <div class="w-full h-32 rounded-2xl border-2 border-dashed border-gray-100 flex flex-col items-center justify-center gap-1">
                                <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2"/>
                                </svg>
                                <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Not Submitted</p>
                            </div>
                        @endif
                    </div>

                    {{-- Selfie --}}
                    <div>
                        <p class="text-[9px] font-black text-gray-400 uppercase tracking-widest mb-2">Selfie Photo</p>
                        @if($user->selfie_image)
                            <button onclick="openLightbox('{{ addslashes($user->selfie_image) }}', 'Selfie — {{ addslashes(trim(($user->first_name ?? '') . ' ' . ($user->last_name ?? ''))) }}')"
                                    class="w-full group relative overflow-hidden rounded-2xl border-2 border-gray-100 hover:border-brgyGreen/30 transition-all">
                                <img src="{{ $user->selfie_image }}"
                                     alt="Selfie"
                                     class="w-full h-32 object-cover object-top group-hover:scale-105 transition-transform duration-300">
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                            </button>
                        @else
                            <div class="w-full h-32 rounded-2xl border-2 border-dashed border-gray-100 flex flex-col items-center justify-center gap-1">
                                <svg class="w-6 h-6 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <p class="text-[9px] font-black text-gray-300 uppercase tracking-widest">Not Submitted</p>
                            </div>
                        @endif
                    </div>
                </div>

                {{-- Action Buttons --}}
                <div class="px-6 py-4 flex items-center gap-3">
                    <button onclick="verifyUser({{ $user->id }}, 'verify', '{{ route('admin.verification.verify', $user->id) }}')"
                            id="verify-btn-{{ $user->id }}"
                            class="flex-1 flex items-center justify-center gap-2 py-3 bg-brgyGreen text-white text-[10px] font-black uppercase tracking-widest rounded-2xl hover:shadow-lg hover:shadow-brgyGreen/20 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Verify Account
                    </button>
                    <button onclick="verifyUser({{ $user->id }}, 'reject', '{{ route('admin.verification.reject', $user->id) }}')"
                            id="reject-btn-{{ $user->id }}"
                            class="flex items-center justify-center gap-2 px-5 py-3 bg-red-50 text-red-500 text-[10px] font-black uppercase tracking-widest rounded-2xl border-2 border-red-100 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        Reject
                    </button>
                </div>
            </div>
            @endforeach
        </div>

        @if($pendingUsers->hasPages())
            <div class="bg-white px-6 py-4 rounded-3xl border border-gray-100 shadow-sm">
                {{ $pendingUsers->links() }}
            </div>
        @endif
    @endif
</div>

{{-- Lightbox Modal --}}
<div id="lightbox" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/80 backdrop-blur-sm p-4">
    <div class="relative max-w-2xl w-full">
        <div class="bg-white rounded-3xl overflow-hidden shadow-2xl">
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
                <p id="lightbox-title" class="text-xs font-black text-gray-700 uppercase tracking-widest"></p>
                <button onclick="closeLightbox()" class="p-2 hover:bg-gray-100 rounded-xl transition-colors">
                    <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            <div class="p-4">
                <img id="lightbox-img" src="" alt="" class="w-full rounded-2xl object-contain max-h-[70vh]">
            </div>
        </div>
    </div>
</div>

<script>
function openLightbox(src, title) {
    document.getElementById('lightbox-img').src = src;
    document.getElementById('lightbox-title').innerText = title;
    const lb = document.getElementById('lightbox');
    lb.classList.remove('hidden');
    lb.classList.add('flex');
}

function closeLightbox() {
    const lb = document.getElementById('lightbox');
    lb.classList.add('hidden');
    lb.classList.remove('flex');
    document.getElementById('lightbox-img').src = '';
}

document.getElementById('lightbox').addEventListener('click', function(e) {
    if (e.target === this) closeLightbox();
});

function verifyUser(id, action, url) {
    const label  = action === 'verify' ? 'verify this account?' : 'reject this account?';
    if (!confirm('Are you sure you want to ' + label)) return;

    const verifyBtn = document.getElementById('verify-btn-' + id);
    const rejectBtn = document.getElementById('reject-btn-' + id);
    verifyBtn.disabled = true;
    rejectBtn.disabled = true;
    verifyBtn.innerText = action === 'verify' ? 'Verifying...' : 'Verify Account';
    if (action === 'reject') rejectBtn.innerText = 'Rejecting...';

    fetch(url, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Accept': 'application/json',
        },
        body: JSON.stringify({}),
    })
    .then(r => r.json())
    .then(data => {
        if (!data.success) throw new Error();

        const card = document.getElementById('verification-card-' + id);
        if (action === 'verify') {
            // Replace card with a success state
            card.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12 gap-3">
                    <div class="w-14 h-14 bg-brgyGreen rounded-full flex items-center justify-center shadow-lg shadow-brgyGreen/30">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <p class="text-sm font-extrabold text-gray-800">Account Verified</p>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Resident can now access all services</p>
                </div>`;
        } else {
            card.innerHTML = `
                <div class="flex flex-col items-center justify-center py-12 gap-3">
                    <div class="w-14 h-14 bg-red-100 rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <p class="text-sm font-extrabold text-gray-800">Account Rejected</p>
                    <p class="text-[10px] font-black text-gray-400 uppercase tracking-widest">Resident has been notified</p>
                </div>`;
        }

        // Decrement pending count badge in sidebar if present
        const badge = document.getElementById('verification-badge');
        if (badge) {
            const n = parseInt(badge.innerText) - 1;
            if (n <= 0) badge.remove();
            else badge.innerText = n;
        }
    })
    .catch(() => {
        alert('Something went wrong. Please try again.');
        verifyBtn.disabled = false;
        rejectBtn.disabled = false;
        verifyBtn.innerText = 'Verify Account';
        rejectBtn.innerText = 'Reject';
    });
}
</script>
@endsection
