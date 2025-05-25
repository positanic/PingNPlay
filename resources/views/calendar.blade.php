@php
    use Carbon\Carbon;
    $now = Carbon::now();
    $daysInMonth = $now->daysInMonth;
    $month = $now->month;
    $year = $now->year;
    // Group games by date (Y-m-d)
    $gamesByDate = collect($games ?? [])->groupBy(function($game) { return Carbon::parse($game->game_date)->toDateString(); });
@endphp

<!-- <pre>
    {{ print_r($gamesByDate) }}
</pre> -->
<x-app-layout>
    <div class="container">
        <h1 class="ms-auto me-auto text-center mb-4">Upcoming Games</h1>
        
        <!-- Insert success/error alert block after the header (e.g. <h1>) -->
        @if (session('success'))
          <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false; }, 5000)" class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        @if (session('error'))
          <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false; }, 5000)" class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Insert validation error block (if any) -->
        @if ($errors->any())
          <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => { show = false; }, 5000)" class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul>
              @foreach ($errors->all() as $error)
                 <li>{{ $error }}</li>
              @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <!-- Tabs -->
        <ul class="nav nav-tabs mb-4" id="calendarTabs" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="list-tab" data-bs-toggle="tab" data-bs-target="#list-view" type="button" role="tab" aria-controls="list-view" aria-selected="true">
                    <i class="bi-list-ul me-2"></i>List View
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar-view" type="button" role="tab" aria-controls="calendar-view" aria-selected="false">
                    <i class="bi-calendar3 me-2"></i>Calendar View
                </button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="new-game-tab" data-bs-toggle="tab" data-bs-target="#new-game-view" type="button" role="tab" aria-controls="new-game-view" aria-selected="false">
                    <i class="bi-plus-circle me-2"></i>Add New Game
                </button>
            </li>
        </ul>

        <!-- Tab Content -->
        <div class="tab-content" id="calendarTabsContent">
            <!-- List View -->
            <div class="tab-pane fade show active" id="list-view" role="tabpanel" aria-labelledby="list-tab">
        <div class="row">
            <div class="col-xl-6 col-md-9 col-12 ms-auto me-auto">
                <div class="list-group w-100 fs-5">
                    @foreach($games as $game)
                        <a href="{{ route('game', $game->id) }}" class="list-group-item list-group-item-action">
                            <i class="bi-calendar-event me-2"></i>{{ \Carbon\Carbon::parse($game->game_date)->format('l, F j') }}
                            <span class="badge rounded-pill bg-primary float-end">{{ $game->signups->count() }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

            <!-- Calendar View -->
            <div class="tab-pane fade" id="calendar-view" role="tabpanel" aria-labelledby="calendar-tab">
                <div class="calendar-container">
                     <!-- Month Navigation -->
                     <div class="d-flex justify-content-between align-items-center mb-4">
                         <button id="prevMonthBtn" class="btn btn-outline-primary">
                             <i class="bi-chevron-left"></i> Previous Month
                         </button>
                         <h3 id="calendarMonthLabel" class="mb-0"></h3>
                         <button id="nextMonthBtn" class="btn btn-outline-primary">
                             Next Month <i class="bi-chevron-right"></i>
                         </button>
                     </div>

                     <!-- Calendar Grid -->
                     <div class="calendar-grid" id="calendarGrid">
                         <!-- Calendar grid will be rendered here by JavaScript -->
                     </div>
                </div>
            </div>

            <!-- New Game Form -->
            <div class="tab-pane fade" id="new-game-view" role="tabpanel" aria-labelledby="new-game-tab">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <form action="{{ route('pickup-games.store') }}" method="POST" class="needs-validation" novalidate>
                                    @csrf
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="game_date" class="form-label">Game Date</label>
                                            <input type="date" class="form-control" id="game_date" name="game_date" required>
                                            <div class="invalid-feedback">
                                                Please select a date.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="location" class="form-label">Location</label>
                                            <input type="text" class="form-control" id="location" name="location" placeholder="e.g., Central Park Field #3" required>
                                            <div class="invalid-feedback">
                                                Please enter a location.
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="start_time" class="form-label">Start Time</label>
                                            <input type="time" class="form-control" id="start_time" name="start_time" required>
                                            <div class="invalid-feedback">
                                                Please select a start time.
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="end_time" class="form-label">End Time (Optional)</label>
                                            <input type="time" class="form-control" id="end_time" name="end_time">
                                        </div>
                                    </div>

                                    <div class="mb-3">
                                        <label for="location_details" class="form-label">Location Details (Optional)</label>
                                        <textarea class="form-control" id="location_details" name="location_details" rows="2" placeholder="e.g., Enter through the north gate, field is behind the tennis courts"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="notes" class="form-label">Additional Notes (Optional)</label>
                                        <textarea class="form-control" id="notes" name="notes" rows="3" placeholder="Any additional information about the game..."></textarea>
                                    </div>

                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi-plus-circle me-2"></i>Add New Game
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .calendar-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #dee2e6;
            border: 1px solid #dee2e6;
        }

        .calendar-header {
            background-color: #f8f9fa;
            padding: 10px;
            text-align: center;
            font-weight: bold;
            border-bottom: 2px solid #dee2e6;
        }

        .calendar-day {
            background-color: white;
            min-height: 120px;
            padding: 5px;
            position: relative;
        }

        .calendar-day.has-events {
            background-color: #f8f9fa;
        }

        .date-number {
            position: absolute;
            top: 5px;
            right: 5px;
            font-size: 0.9rem;
            color: #6c757d;
        }

        .event-badge {
            color: white;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 0.8rem;
            margin-top: 25px;
            display: inline-block;
            width: 100%;
            text-align: center;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .calendar-day {
                min-height: 80px;
            }
            
            .event-badge {
                font-size: 0.7rem;
                padding: 1px 4px;
            }
        }

        /* Form specific styles */
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }

        .form-label {
            font-weight: 500;
        }

        .invalid-feedback {
            font-size: 0.875rem;
        }
    </style>

    <script>
        // Form validation
        (function () {
            'use strict'
            var forms = document.querySelectorAll('.needs-validation')
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }
                    form.classList.add('was-validated')
                }, false)
            })
        })()

    document.addEventListener('DOMContentLoaded', function () {
        const monthLabel = document.getElementById('calendarMonthLabel');
        const prevBtn = document.getElementById('prevMonthBtn');
        const nextBtn = document.getElementById('nextMonthBtn');
        const calendarGrid = document.getElementById('calendarGrid');

        // Get initial month/year from JS Date (current month)
        let today = new Date();
        let currentMonth = today.getMonth() + 1; // JS months are 0-based
        let currentYear = today.getFullYear();
        const games = @json($games ?? []);

        function renderCalendar(month, year) {
            // Calculate days in month
            const daysInMonth = new Date(year, month, 0).getDate();
            // Update month label
            const monthNames = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];
            monthLabel.textContent = `${monthNames[month - 1]} ${year}`;

            // Calculate the day of week (0–6) for the first day of the month (0 is Sunday, 1 is Monday, etc.)
            const firstDay = new Date(year, month - 1, 1).getDay();

            // Build calendar days: prepend empty cells so that the first day is in the correct column
            let html = '';
            for (let i = 0; i < firstDay; i++) {
                html += '<div class="calendar-day"></div>';
            }
            for (let i = 1; i <= daysInMonth; i++) {
                // Format date as YYYY-MM-DD
                const date = `${year}-${String(month).padStart(2, '0')}-${String(i).padStart(2, '0')}`;
                // Find games for this day
                const gamesForDay = games.filter(g => g.game_date.substring(0, 10) === date);
                // if (i == 23) { alert(games[0].game_date); }
                html += `<div class="calendar-day${gamesForDay.length ? ' has-events' : ''}">`;
                html += `<div class="date-number">${i}</div>`;
                gamesForDay.forEach(game => {
                    html += `<a href="/game/${game.id}" class="list-group-item list-group-item-action"><div class="event-badge bg-primary">
                        ${game.start_time ? game.start_time.substring(11,16) : ''}
                        ${game.location ? `<br><small>${game.location}</small>` : ''}
                    </div></a>`;
                });
                html += `</div>`;
            }
            calendarGrid.innerHTML = `
                <div class="calendar-header">Sun</div>
                <div class="calendar-header">Mon</div>
                <div class="calendar-header">Tue</div>
                <div class="calendar-header">Wed</div>
                <div class="calendar-header">Thu</div>
                <div class="calendar-header">Fri</div>
                <div class="calendar-header">Sat</div>
                ${html}
            `;
        }

        prevBtn.addEventListener('click', function () {
            currentMonth--;
            if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        });

        nextBtn.addEventListener('click', function () {
            currentMonth++;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        });

        // Initial render: always show current month
        renderCalendar(currentMonth, currentYear);
    });
    </script>
</x-app-layout>
