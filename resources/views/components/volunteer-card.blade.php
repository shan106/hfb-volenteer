@props(['user'])

@php
    $displayName = $user->username ?? $user->name ?? __('Volunteer');
@endphp

<a href="{{ route('users.show', $user) }}"
   {{ $attributes->merge(['class' => 'group block bg-white rounded-xl shadow-sm p-5 text-center hover:shadow-md transition-shadow']) }}>

    @if($user->avatar_path)
        <img src="{{ asset('storage/' . $user->avatar_path) }}"
             alt="{{ __('Profile picture of') }} {{ $displayName }}"
             class="h-20 w-20 mx-auto rounded-full object-cover object-center ring-2 ring-gray-100"
             loading="lazy">
    @else
        <div class="h-20 w-20 mx-auto rounded-full bg-[#0071bc]/10 flex items-center justify-center
                    text-2xl font-semibold text-[#0071bc] ring-2 ring-gray-100">
            {{ strtoupper(mb_substr($displayName, 0, 1)) }}
        </div>
    @endif

    <p class="mt-3 font-semibold text-gray-900 group-hover:text-[#0071bc] truncate">
        {{ $displayName }}
    </p>

    @if($user->name && $user->username)
        <p class="text-xs text-gray-500 truncate">{{ $user->name }}</p>
    @endif

    @if($user->about)
        <p class="text-sm text-gray-600 mt-2 line-clamp-3 text-left">
            {{ $user->about }}
        </p>
    @endif
</a>