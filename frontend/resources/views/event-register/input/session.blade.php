<div id="session-card" class="session-card mb-3" data-session-id="${session.id}" ${isFull ? 'style="opacity: 0.6;"' : '' }>
    <input type="checkbox" class="session-checkbox" data-session-id="${session.id}" ${isFull ? 'disabled' : '' }>
    <div class="session-header">
        <div>
            <h2 class="session-title">{{ $session['title'] }}</h2>
            <p class="session-description">{{ $session['description'] }}</p>
        </div>
        {{-- TAMBAHKAN IFFF --}}
        {{-- <div class="session-status ${statusClass}">
            <span>●</span>
            <span>None</span>
        </div> --}}
    </div>

    <div class="session-meta">
        <div class="meta-item">
            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <span>
                {{ \Carbon\Carbon::parse($session['date'])->translatedFormat('l, j F Y') }} •
                {{ \Carbon\Carbon::parse($session['start_time'])->format('H:i') }} -
                {{ \Carbon\Carbon::parse($session['end_time'])->format('H:i') }}
            </span>
        </div>
        <div class="meta-item">
            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
            </svg>
            <span>{{ $session['location'] }}</span>
        </div>
        <div class="meta-item">
            <svg class="meta-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                </path>
            </svg>
            <span>{{ $session['total_participants'] }}/ {{ $session['max_participants'] }} participants •
                ${{ $session['registration_fee'] }}</span>
        </div>
    </div>

    <div class="people-section">
        <div class="people-header">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z">
                </path>
            </svg>
            Speakers
        </div>
        <div class="people-list gap-3">
            @foreach ($session['speaker'] as $speaker)
                <div class="person-chip">
                    <div class="person-avatar">{{ strtoupper(substr($speaker['name'], 0, 1)) }}</div>
                    <span>{{ $speaker['name'] }}</span>
                </div>
            @endforeach
        </div>
    </div>

    <div class="people-section">
        <div class="people-header">
            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            Moderator
        </div>
        <div class="people-list gap-3">
            @foreach ($session['moderator'] as $moderator)
                <div class="person-chip">
                    <div class="person-avatar">{{ strtoupper(substr($moderator['name'], 0, 1)) }}</div>
                    <span>{{ $moderator['name'] }}</span>
                </div>
            @endforeach
        </div>
    </div>
</div>
