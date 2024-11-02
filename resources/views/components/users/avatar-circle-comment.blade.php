 <div class="relative">
     <img src="{{ $user->getAvatar() }}" class="h-8 w-8 rounded-full"
         alt="{{ $user->name ? 'avatar' : $user->username }}" />
     @if (Cache::has('is-online-' . $user->id))
         <span
             class="bg-positive-500 absolute bottom-0 right-0 h-2 w-2 rounded-full border border-white shadow-sm dark:border-gray-800"></span>
     @endif
 </div>
