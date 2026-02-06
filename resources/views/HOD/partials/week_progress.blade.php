<div class="mt-6 bg-white rounded-lg shadow p-4">
    <div class="flex flex-col md:flex-row items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-800">Academic Session Progress</h2>
            <p class="text-sm text-gray-600">{{ session('currentSession') }} ({{ session('startDate') }} -
                {{ session('endDate') }})</p>
        </div>

        <div class="mt-4 md:mt-0 flex items-center">
            <div class="relative w-16 h-16 mr-3">
                <svg class="w-full h-full" viewBox="0 0 36 36">
                    <circle cx="18" cy="18" r="16" fill="none" stroke="#e6e6e6" stroke-width="2"></circle>
                    <circle id="progress-ring-circle" cx="18" cy="18" r="16" fill="none"
                        stroke="#0ea5e9" stroke-width="2" stroke-dasharray="100 100" stroke-dashoffset="75"></circle>
                </svg>
                <div class="absolute inset-0 flex items-center justify-center">
                    <span class="text-[0.6rem] font-bold text-primary-600 text-center leading-tight px-1" id="week-progress-text">
                        Week {{ session('current_week', 1) }} of
                        {{ str_contains(session('currentSession'), 'Fall') || str_contains(session('currentSession'), 'Spring') ? 16 : 8 }}
                    </span>
                </div>
            </div>
            <div class="ml-2">
                <p class="text-sm font-medium text-gray-700">
                    {{ str_contains(session('currentSession'), 'Fall') || str_contains(session('currentSession'), 'Spring') ? '16-week Semester' : '8-week Term' }}
                </p>
                <p class="text-xs text-gray-500">
                    @php
                        $totalWeeks =
                            str_contains(session('currentSession'), 'Fall') ||
                            str_contains(session('currentSession'), 'Spring')
                                ? 16
                                : 8;
                        $currentWeek = session('current_week', 1);
                        $percentCompleted = round(($currentWeek / $totalWeeks) * 100);
                    @endphp

                    {{ $percentCompleted }}% completed

                </p>
            </div>
        </div>
    </div>

    <div class="mt-4 pt-4 border-t border-gray-200">
        <div class="flex justify-between text-xs text-gray-500">
            <span>Week 1</span>
            <span>Week
                {{ str_contains(session('currentSession'), 'Fall') || str_contains(session('currentSession'), 'Spring') ? 16 : 8 }}</span>
        </div>
        <div class="mt-1 w-full bg-gray-200 rounded-full h-2">
            <div class="bg-primary-500 h-2 rounded-full"
                style="width: {{ (session('current_week', 1) / (str_contains(session('currentSession'), 'Fall') || str_contains(session('currentSession'), 'Spring') ? 16 : 8)) * 100 }}%">
            </div>
        </div>
    </div>
</div>