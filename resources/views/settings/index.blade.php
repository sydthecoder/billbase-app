<x-layouts.app title="Settings">
    <div class="row mt-4">
        <div class="col-12">
            <nav>
                <div class="nav nav-tabs mb-4" id="nav-tab" role="tablist">
                    <a 
                        href="{{ route('settings.index', ['tab' => 'general']) }}"
                        class="nav-item nav-link {{ $tab === 'general' ? 'active' : '' }}"
                    >
                        General
                    </a>

                    <a 
                        href="{{ route('settings.index', ['tab' => 'mail']) }}"
                        class="nav-item nav-link {{ $tab === 'mail' ? 'active' : '' }}"
                    >
                        Email
                    </a>

                    <a 
                        href="{{ route('settings.index', ['tab' => 'bank-account']) }}"
                        class="nav-item nav-link {{ $tab === 'bank-account' ? 'active' : '' }}"
                    >
                        Bank Account
                    </a>

                    <a 
                        href="{{ route('settings.index', ['tab' => 'preferences']) }}"
                        class="nav-item nav-link {{ $tab === 'preferences' ? 'active' : '' }}"
                    >
                        Preferences
                    </a>
                </div>
            </nav>
        </div>

        <div class="col-12">
            <div class="col-6">
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <span class="fas fa-bullhorn me-1"></span>

                        @foreach ($errors->all() as $error)
                            {{ $error }}
                        @endforeach

                        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
        </div>
    </div>

    @include('settings.partials.' . $tab)

</x-layouts.app>