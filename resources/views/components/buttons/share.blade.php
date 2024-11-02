 <div class="relative" x-data="{ open: false }">
     <button
         title="{{ __('Share') }}"
         aria-expanded="false"
         aria-haspopup="true"
         @click.prevent="open = !open"
         :aria-expanded="open"
         class="group flex items-center focus:outline-none">
         <div
             class="flex h-8 w-8 items-center justify-center rounded-lg group-hover:bg-purple-500/10">
             <x-icons.share class="h-4 w-4 text-gray-600 group-hover:text-purple-500 dark:text-slate-200" />
         </div>
     </button>
     <div
         class="max-w-56 shadow-popup dark:shadow-card dark:border-primary-900 absolute top-full -left-24 z-50 mt-2 overflow-hidden rounded-lg bg-white dark:border dark:bg-slate-900"
         @click.outside="open = false"
         @keydown.escape.window="open = false"
         x-show="open"
         x-transition:enter="transition ease-out duration-200 transform"
         x-transition:enter-start="opacity-0 -translate-y-2"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-out duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         x-cloak>
         <x-share-links :story="$story" />
     </div>
 </div>
