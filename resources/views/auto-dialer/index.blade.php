@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Auto Dialer</h1>
        <p class="text-gray-600 mt-2">Manage your calling devices and start automated calling</p>
    </div>

    <!-- Dialer Status -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-8">
        @forelse($dialers as $dialer)
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">{{ $dialer->device_name }}</h3>
                <span class="px-3 py-1 text-xs font-semibold rounded-full 
                    {{ $dialer->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ ucfirst($dialer->status) }}
                </span>
            </div>
            
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-gray-600">SIM Number:</span>
                    <span class="font-medium">{{ $dialer->sim_number }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Calls Today:</span>
                    <span class="font-medium">{{ $dialer->calls_made_today }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-600">Last Call:</span>
                    <span class="font-medium">{{ $dialer->last_call_at ? $dialer->last_call_at->format('H:i') : 'Never' }}</span>
                </div>
            </div>

            @if($dialer->isActive())
            <button onclick="startCalling()" class="w-full mt-6 bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 font-semibold">
                📞 Start Auto Calling
            </button>
            @endif
        </div>
        @empty
        <div class="col-span-3 text-center py-12">
            <div class="text-6xl mb-4">📱</div>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No Auto Dialer Configured</h3>
            <p class="text-gray-600 mb-6">Connect your Android device with SIM card to start auto calling</p>
            <button class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 font-semibold">
                Setup Device
            </button>
        </div>
        @endforelse
    </div>

    <!-- Call Interface -->
    <div id="callInterface" class="hidden bg-white rounded-lg shadow-lg p-6">
        <div class="text-center mb-6">
            <h2 class="text-2xl font-bold text-gray-900 mb-2">Auto Calling Active</h2>
            <p class="text-gray-600">Calling leads automatically...</p>
        </div>

        <div id="currentCall" class="bg-blue-50 rounded-lg p-6 mb-6">
            <div class="text-center">
                <div class="text-4xl mb-4">📞</div>
                <h3 id="leadName" class="text-xl font-semibold text-gray-900">-</h3>
                <p id="leadPhone" class="text-gray-600">-</p>
                <div id="callTimer" class="text-2xl font-bold text-blue-600 mt-4">00:00</div>
            </div>
        </div>

        <!-- Dispositions -->
        <div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-6">
            <button onclick="setDisposition('interested')" class="bg-green-600 text-white py-3 px-4 rounded-lg hover:bg-green-700 font-semibold">
                ✅ Interested
            </button>
            <button onclick="setDisposition('not_interested')" class="bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 font-semibold">
                ❌ Not Interested
            </button>
            <button onclick="setDisposition('callback')" class="bg-yellow-600 text-white py-3 px-4 rounded-lg hover:bg-yellow-700 font-semibold">
                📅 Callback
            </button>
            <button onclick="setDisposition('no_answer')" class="bg-gray-600 text-white py-3 px-4 rounded-lg hover:bg-gray-700 font-semibold">
                📵 No Answer
            </button>
            <button onclick="setDisposition('busy')" class="bg-orange-600 text-white py-3 px-4 rounded-lg hover:bg-orange-700 font-semibold">
                📞 Busy
            </button>
            <button onclick="setDisposition('invalid')" class="bg-purple-600 text-white py-3 px-4 rounded-lg hover:bg-purple-700 font-semibold">
                🚫 Invalid
            </button>
        </div>

        <!-- Notes -->
        <div class="mb-6">
            <label class="block text-sm font-medium text-gray-700 mb-2">Call Notes</label>
            <textarea id="callNotes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Add notes about this call..."></textarea>
        </div>

        <div class="flex space-x-4">
            <button onclick="stopCalling()" class="flex-1 bg-red-600 text-white py-3 px-4 rounded-lg hover:bg-red-700 font-semibold">
                ⏹️ Stop Calling
            </button>
            <button onclick="nextCall()" class="flex-1 bg-blue-600 text-white py-3 px-4 rounded-lg hover:bg-blue-700 font-semibold">
                ⏭️ Next Call
            </button>
        </div>
    </div>
</div>

<script>
let currentLead = null;
let callStartTime = null;
let timerInterval = null;
let leads = [];
let currentIndex = 0;

function startCalling() {
    fetch('/auto-dialer/start', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.error) {
            alert(data.error);
            return;
        }
        
        leads = data.leads;
        document.getElementById('callInterface').classList.remove('hidden');
        
        if (leads.length > 0) {
            startNextCall();
        } else {
            alert('No pending leads to call');
        }
    });
}

function startNextCall() {
    if (currentIndex >= leads.length) {
        alert('All leads called!');
        stopCalling();
        return;
    }
    
    currentLead = leads[currentIndex];
    document.getElementById('leadName').textContent = currentLead.name;
    document.getElementById('leadPhone').textContent = currentLead.phone;
    
    callStartTime = Date.now();
    startTimer();
}

function startTimer() {
    timerInterval = setInterval(() => {
        const elapsed = Math.floor((Date.now() - callStartTime) / 1000);
        const minutes = Math.floor(elapsed / 60);
        const seconds = elapsed % 60;
        document.getElementById('callTimer').textContent = 
            `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
    }, 1000);
}

function setDisposition(disposition) {
    if (!currentLead) return;
    
    const duration = Math.floor((Date.now() - callStartTime) / 1000);
    const notes = document.getElementById('callNotes').value;
    
    fetch('/auto-dialer/log-call', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({
            lead_id: currentLead.id,
            disposition: disposition,
            duration: duration,
            notes: notes
        })
    })
    .then(() => {
        document.getElementById('callNotes').value = '';
        nextCall();
    });
}

function nextCall() {
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    currentIndex++;
    startNextCall();
}

function stopCalling() {
    if (timerInterval) {
        clearInterval(timerInterval);
    }
    document.getElementById('callInterface').classList.add('hidden');
    location.reload();
}
</script>
@endsection