 <div wire:poll.60s="getNotificationsCount" class="group" x-data="{ isOpen: false }">
     <div class="relative">
         <button class="flex items-center px-2 focus:outline-none"
             aria-label="{{ __('Notifications') }}"
             x-cloak
             x-on:click="
     isOpen = !isOpen
     if(isOpen){
         Livewire.dispatch('getNotifications')
     }
     ">
             <svg class="h-7 w-7 text-gray-900 group-hover:text-primary-500 dark:text-slate-200 dark:group-hover:text-primary-500"
                 :class="isOpen ? 'text-primary-500 origin-center rotate-12' : ''"
                 viewBox="0 0 24 24"
                 fill="none"
                 xmlns="http://www.w3.org/2000/svg">
                 <path
                     d="M12.02 2.90991C8.70997 2.90991 6.01997 5.59991 6.01997 8.90991V11.7999C6.01997 12.4099 5.75997 13.3399 5.44997 13.8599L4.29997 15.7699C3.58997 16.9499 4.07997 18.2599 5.37997 18.6999C9.68997 20.1399 14.34 20.1399 18.65 18.6999C19.86 18.2999 20.39 16.8699 19.73 15.7699L18.58 13.8599C18.28 13.3399 18.02 12.4099 18.02 11.7999V8.90991C18.02 5.60991 15.32 2.90991 12.02 2.90991Z"
                     stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" />
                 <path
                     d="M13.87 3.19994C13.56 3.10994 13.24 3.03994 12.91 2.99994C11.95 2.87994 11.03 2.94994 10.17 3.19994C10.46 2.45994 11.18 1.93994 12.02 1.93994C12.86 1.93994 13.58 2.45994 13.87 3.19994Z"
                     stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round"
                     stroke-linejoin="round" />
                 <path
                     d="M15.02 19.0601C15.02 20.7101 13.67 22.0601 12.02 22.0601C11.2 22.0601 10.44 21.7201 9.90002 21.1801C9.36002 20.6401 9.02002 19.8801 9.02002 19.0601"
                     stroke="currentColor" stroke-width="1.5" stroke-miterlimit="10" />
             </svg>
             @if ($notificationsCount)
                 <span
                     class="absolute -top-2 left-1/2 flex items-center justify-center rounded-md bg-red-500 px-1.5 py-0.5 text-xs text-white shadow">
                     {{ $notificationsCount }}
                 </span>
             @endif
         </button>
     </div>

     <div
         x-cloak
         x-show="isOpen"
         x-transition.duration.300ms @click.away="isOpen = false"
         @keydown.escape.window="isOpen = false"
         class="absolute right-0 top-full z-50 h-fit w-full bg-white text-sm font-medium shadow-dialog dark:bg-slate-800 dark:text-slate-200 md:right-32 md:w-96 md:rounded-t-xl lg:right-48">
         <div
             class="flex items-center justify-between border-b border-slate-500/10 px-10 py-2 dark:border-slate-700 md:px-5">
             <div class="text-lg font-semibold">
                 {{ __('Notifications') }}</div>
             @if ($notifications->isNotEmpty())
                 <button
                     wire:click="clearAllNotifications"
                     @click="isOpen = false"
                     class="text-sm font-semibold text-primary-500 transition duration-150 ease-in hover:text-primary-700">{{ __('Clear All') }}</button>
             @endif
         </div>

         <ul class="max-h-96 overflow-y-auto">
             @if ($notifications->isNotEmpty() && !$isLoading)
                 @foreach ($notifications as $notification)
                     @includeIf("notifications.{$notification->data['type']}")
                 @endforeach
             @elseif ($isLoading)
                 @foreach (range(1, 3) as $item)
                     <li class="flex animate-pulse items-center px-10 py-3 transition duration-150 ease-in md:px-5">
                         <div class="h-10 w-10 rounded-xl bg-gray-200"></div>
                         <div class="ml-4 flex-1 space-y-2">
                             <div class="h-4 w-full rounded bg-gray-200"></div>
                             <div class="h-4 w-full rounded bg-gray-200"></div>
                             <div class="h-4 w-1/2 rounded bg-gray-200"></div>
                         </div>
                     </li>
                 @endforeach
             @else
                 <li class="mx-auto w-40 py-6">
                     <x-icons.staff.no-notifications />
                     <div class="mt-6 text-center text-sm font-bold text-gray-500">{{ __('No new notifications') }}
                     </div>
                 </li>
             @endif
         </ul>
     </div>
 </div>
