<x-app-layout>
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="text-center mb-4">
                    <h1 class="display-4">Game</h1>
                </div>
                <div class="mb-3">
                    <h3>{{ $game->game_date->format('l, F j, Y') }}</h3>
                    <div>{{ date('g:ia', strtotime($game->start_time)) }} - {{ date('g:ia', strtotime($game->end_time ?? $game->start_time)) }}</div>
                </div>
                <div class="mb-3">
                    <!-- Attending/Not Attending Box -->
                    @php
                        $userSignup = $signups->firstWhere('user_id', auth()->id());
                    @endphp
                    @if($userSignup)
                        <div class="alert alert-success d-inline-block">Attending</div>
                        <form method="POST" action="{{ route('game.signup.update', $game->id) }}" class="d-inline-block ms-2">
                            @csrf
                            @method('PATCH')
                            <!-- Update note -->
                            <input type="text" name="comment" value="{{ $userSignup->comment }}" placeholder="(e.g. I'll be late)" class="form-control d-inline-block w-auto" style="display:inline-block; width:200px;">
                            <button type="submit" class="btn btn-primary btn-sm">Update Note</button>
                        </form>
                        <form method="POST" action="{{ route('game.signup.cancel', $game->id) }}" class="d-inline-block ms-2">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Cancel Signup</button>
                        </form>
                    @else
                        <div class="alert alert-danger d-inline-block">Not Attending</div>
                        <form method="POST" action="{{ route('game.signup', $game->id) }}" class="d-inline-block ms-2">
                            @csrf
                            <input type="text" name="comment" placeholder="Extra notes (will be late, have to leave early,...)" class="form-control d-inline-block w-auto" style="display:inline-block; width:250px;">
                            <button type="submit" class="btn btn-success btn-sm">Sign me up</button>
                        </form>
                    @endif
                </div>
                <hr>
                <div class="row mb-4">
                    <div class="col-md-6">
                        <h5>Location</h5>
                        <div>{{ $game->location }}</div>
                        @if($game->location_details)
                            <div class="text-muted">{{ $game->location_details }}</div>
                        @endif
                        <h5 class="mt-3">Notes</h5>
                        <div class="border p-2" style="min-height:80px;">{{ $game->notes }}</div>
                        <h5 class="mt-3">Weather</h5>
                        <div class="d-flex align-items-center">
                            <span class="me-2" style="font-size:2rem;">☀️</span>
                            <div>
                                <div>Sunny</div>
                                <div>High of 23</div>
                                <div>0% chance of rain</div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <h5>Players ({{ $signups->count() }})</h5>
                        <ul class="list-group mb-3">
                            @foreach($signups as $signup)
                                <li class="list-group-item">
                                    {{ $signup->user->name ?? 'Unknown' }}
                                    @if($signup->comment)
                                        <span class="text-muted small ms-2">({{ $signup->comment }})</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                        <h5>Chat</h5>
                        <div class="border p-2 mb-2" style="min-height:60px; background:#eee;">Chat message 1 (placeholder)</div>
                        <div class="border p-2 mb-2" style="min-height:60px; background:#eee;">Chat message 2 (placeholder)</div>
                        <div class="border p-2 mb-2" style="min-height:60px; background:#eee;">Chat message 3 (placeholder)</div>
                        <form class="mt-2">
                            <input type="text" class="form-control d-inline-block w-75" placeholder="Type a message..." disabled>
                            <button class="btn btn-primary d-inline-block w-25" disabled>Send</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout> 