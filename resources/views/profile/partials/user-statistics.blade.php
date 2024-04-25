<section>
    <header>
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">{{ __('User Statistics') }}</h2>
        <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
            {{ __('View your account statistics.') }}
        </p>
    </header>

    <div class="mt-6 space flex justify-center items-center">
        <div class="stat flex flex-col justify-center items-center">
            <div class="stat-title">Unique Video Views</div>
            <div class="stat-value">{{Auth::user()->uniqueVideoViews()}}</div>
            <div class="stat-desc w-1/2 text-wrap text-center">Unique users</div>
        </div>
        <div class="stat flex flex-col justify-center items-center">
            <div class="stat-title">Total Video Views</div>
            <div class="stat-value ">{{Auth::user()->allVideoViews()}}</div>
            <div class="stat-desc w-1/2 text-wrap text-center">Even recurring views</div>
        </div>
        <div class="stat flex flex-col justify-center items-center">
            <div class="stat-title">Total Videos</div>
            <div class="stat-value">{{Auth::user()->videos()->count()}}</div>
            <div class="stat-desc w-1/2 text-wrap text-center">How many videos you have</div>
        </div>
        <div class="stat flex flex-col justify-center items-center">
            <div class="stat-title">Total Playlists</div>
            <div class="stat-value">{{Auth::user()->playlists()->count()}}</div>
            <div class="stat-desc w-1/2 text-wrap text-center">How many playlists you've made</div>
        </div>

    </div>
</section>
