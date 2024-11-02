<div class="js-cookie-consent cookie-consent fixed inset-x-0 bottom-20 pb-2 sm:bottom-4">
    <div class="mx-auto max-w-[53rem] px-2">
        <div class="rounded-lg bg-primary-100 p-4 shadow-2xl dark:bg-primary-900 dark:bg-opacity-90">
            <div class="flex flex-wrap items-center justify-between">
                <div class="block w-full flex-1 items-center sm:w-0 md:inline">
                    <p class="cookie-consent__message ml-3 text-black dark:text-white">
                        {!! trans('cookie-consent::texts.message') !!}
                    </p>
                </div>
                <div class="mt-2 w-full flex-shrink-0 sm:mt-0 sm:w-auto">
                    <button
                        class="js-cookie-consent-agree cookie-consent__agree flex w-full cursor-pointer items-center justify-center rounded-lg bg-primary-500 px-4 py-2 text-sm font-semibold text-white shadow hover:bg-primary-600 hover:shadow-md sm:w-auto">
                        {{ trans('cookie-consent::texts.agree') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
