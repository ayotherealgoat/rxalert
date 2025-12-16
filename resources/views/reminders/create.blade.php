<x-form-layout title="Add New Medication" description="Set up reminders for your medication schedule">
    <div class="p-8">
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-50 border border-red-200 rounded-lg">
                <div class="text-sm text-red-600">Please correct the following errors:</div>
                <ul class="mt-2 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600 text-sm">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('reminders.store') }}">
            @csrf

            <div class="space-y-6">
                <div class="relative">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Medication Name</label>
                    <input type="text" name="name" required 
                           class="w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                           placeholder="Enter medication name" />
                </div>

                <div class="relative">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Dosage</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <input type="text" 
                               name="dosage" 
                               value="{{ old('dosage') }}"
                               required 
                               class="w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                               placeholder="e.g., 500mg" 
                               pattern="[0-9]+[a-zA-Z]*"
                               title="Enter a number followed by optional units (e.g., 500mg)" />
                </div>

                <div class="relative">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Times per day</label>
                    <select name="times_per_day" required 
                            class="w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200">
                        @for($i = 1; $i <= 6; $i++)
                            <option value="{{ $i }}">{{ $i }} time{{ $i != 1 ? 's' : '' }} per day</option>
                        @endfor
                    </select>
                </div>

                <div class="relative">
                    <label class="block mb-2 text-sm font-medium text-gray-900">First dose time</label>
                    <input type="time" name="first_dose_time" required 
                           class="w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200" />
                </div>

                <div class="relative">
                    <label class="block mb-2 text-sm font-medium text-gray-900">Notes (optional)</label>
                    <textarea name="notes" rows="3" 
                              class="w-full px-4 py-2.5 text-gray-900 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all duration-200"
                              placeholder="Add any special instructions or notes"></textarea>
                </div>
            </div>

            <div id="dose-times" class="mt-8 p-6 bg-gradient-to-br from-indigo-50 to-white rounded-xl border border-indigo-100 shadow-sm">
                <h3 class="text-sm font-semibold text-indigo-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Calculated Dose Times
                </h3>
                <div class="dose-times-content space-y-2">
                    <!-- Dose times will be displayed here -->
                </div>
                <div class="loading-spinner hidden">
                    <div class="flex justify-center py-4">
                        <svg class="animate-spin h-6 w-6 text-indigo-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4 mt-8">
                <a href="{{ route('reminders.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-lg text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                    </svg>
                    Back to Dashboard
                </a>
                <button type="submit" 
                        class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Add Reminder
                </button>
            </div>
        </form>
    </div>
</x-layout>

<script>
    // Optional: Add JavaScript here for enhanced interactivity
    document.addEventListener('DOMContentLoaded', function() {
    const timesPerDay = document.getElementById('times_per_day');
    const firstDoseTime = document.getElementById('first_dose_time');
    const doseTimesDiv = document.getElementById('dose-times');

    async function updateDoseTimes() {
        if (!timesPerDay.value || !firstDoseTime.value) return;

        const response = await fetch('/calculate-dose-times', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                first_dose_time: firstDoseTime.value,
                times_per_day: timesPerDay.value
            })
        });

        const data = await response.json();
        
        doseTimesDiv.innerHTML = data.times.map((time, index) => 
            `<div class="text-sm text-gray-600">Dose ${index + 1}: ${time}</div>`
        ).join('');
    }

    timesPerDay.addEventListener('change', updateDoseTimes);
    firstDoseTime.addEventListener('change', updateDoseTimes);
});
</script>
