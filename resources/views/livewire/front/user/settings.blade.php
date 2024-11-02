<div x-data="{ tab: 'account' }" class="relative py-6">
    <div class="mx-auto flex w-full flex-col-reverse md:grid md:max-w-theme md:grid-cols-12 md:gap-8">
        <div class="col-span-8 bg-white p-4 shadow dark:bg-slate-800 dark:text-slate-200 sm:rounded-lg">
            <a class="flex items-center text-gray-500 hover:text-primary-700"
                href="{{ route('user.show', ['user' => getCurrentUser()]) }}">
                <x-icons.arrow-left class="h-6 w-6" />
                <span
                    class="ml-1">{{ getCurrentUser()->name ? getCurrentUser()->name : getCurrentUser()->username }}
                </span>
            </a>
            <div x-show="tab === 'account'" x-cloak>
                <div class="mt-6">
                    <form wire:submit="saveAccount">
                        <section>
                            <x-forms.label for="name" value="{{ __('Name') }}" class="mb-2 font-semibold" />
                            <x-forms.input wire:model="name" name="name" type="text" />
                        </section>

                        <section class="mt-6">
                            <x-forms.label for="username" value="{{ __('Username') }}" class="mb-2 font-semibold" />
                            <x-forms.input wire:model="username" name="username" type="text" />
                        </section>

                        <section class="mt-6">
                            <x-forms.label for="email" value="{{ __('Email') }}" class="mb-2 font-semibold" />
                            <x-forms.input wire:model="email" name="email" type="text" />
                        </section>

                        <section class="mt-6">
                            <x-buttons.primary-button>{{ __('Update') }}</x-buttons.primary-button>
                        </section>
                    </form>
                    @unless (Auth::user()->isAdmin())
                        <section class="mt-10">
                            <div class="-mx-4 space-y-6 border-t-2 border-red-600 bg-gray-100 px-4 py-6 sm:p-6">
                                <div>
                                    <h2 class="text-lg font-semibold uppercase leading-6 text-red-500">
                                        {{ __('Danger Zone') }}</h2>
                                    <h3 class="my-2">
                                        {{ __('Once you delete your account, there is no going back. Please be certain.') }}
                                    </h3>
                                    <div class="text-sm leading-5 text-gray-800">
                                        <h3>{{ __('Deleting your account will:') }}</h3>
                                        <ul class="list-disc pl-5">
                                            <li>{{ __('Delete any and all content you have, such as articles, comments, or your bookmarked list.') }}
                                            </li>
                                            <li>{{ __('Allow your username to become available to anyone.') }}</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <section class="mt-6">
                                <x-buttons.primary-button
                                    class="bg-red-500 hover:bg-red-600"
                                    x-on:confirm="{
                                    title: '{{ __('Delete Account?') }}',
                                    description: '{{ __('Please be aware that deleting your account will also remove all of your data. This cannot be undone.') }}',
                                    icon: 'error',
                                    iconColor: 'text-red-500',
                                    iconBackground: 'bg-transparent',
                                    accept: {
                                        label: '{{ __('Delete Account') }}',
                                        method: 'deleteAccount',
                                    },
                                    params: 1
                                }">
                                    {{ __('Delete Account') }}
                                </x-buttons.primary-button>
                            </section>
                        </section>
                    @endunless
                </div>
            </div>

            <div x-show="tab === 'security'" x-clock>
                <div class="mt-6">
                    <form wire:submit="updatePassword">
                        @if (Auth::user()->hasPassword())
                            <section class="mt-6">
                                <x-forms.label for="currentPassword" value="{{ __('Current Password') }}"
                                    class="mb-2 font-semibold" />
                                <x-forms.input name="currentPassword" type="password"
                                    wire:model="currentPassword" value="currentPassword" />
                            </section>
                        @endif

                        <section class="mt-6">
                            <x-forms.label for="newPassword" value="{{ __('New Password') }}"
                                class="mb-2 font-semibold" />
                            <x-forms.input id="newPassword" name="newPassword" type="password"
                                wire:model="newPassword" value="newPassword" />
                        </section>

                        <section class="mt-6">
                            <x-forms.label for="confirmPassword" value="{{ __('Confirm Password') }}"
                                class="mb-2 font-semibold" />
                            <x-forms.input id="confirmPassword" name="confirmPassword" type="password"
                                wire:model="confirmPassword"
                                value="confirmPassword" />
                        </section>
                        <section class="mt-6">
                            <x-buttons.primary-button>{{ __('Update') }}</x-buttons.primary-button>
                        </section>
                    </form>
                </div>
            </div>

            <div x-show="tab === 'profile'" x-cloak>
                <div class="mt-6">
                    <form wire:submit="saveProfile">
                        <section class="mt-6" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                            <div class="flex justify-between">
                                <x-forms.label for="bio" value="{{ __('Bio') }}" class="mb-2 font-semibold" />
                                <span class="text-xs font-semibold text-gray-700 dark:text-slate-200"><span
                                        x-html="count"></span> / <span
                                        x-html="$refs.countme.maxLength"></span>
                                </span>
                            </div>
                            <x-forms.textarea wire:model="bio" name="bio" id="bio" rows="5"
                                placeholder="{{ __('Tell us a little bit about yourself') }}" maxlength="200"
                                x-ref="countme"
                                x-on:keyup="count = $refs.countme.value.length">
                            </x-forms.textarea>
                        </section>

                        <section class="mt-6" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                            <div class="flex justify-between">
                                <x-forms.label for="website" value="{{ __('Your Website') }}"
                                    class="mb-2 font-semibold" />
                                <span class="text-xs font-semibold text-gray-700 dark:text-slate-200"><span
                                        x-html="count"></span> / <span
                                        x-html="$refs.countme.maxLength"></span>
                                </span>
                            </div>
                            <x-forms.input wire:model="website" name="website" type="text"
                                placeholder="https://yoursite.com"
                                maxlength="50" x-ref="countme"
                                x-on:keyup="count = $refs.countme.value.length" />
                        </section>

                        <section class="mt-6" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                            <div class="flex justify-between">
                                <x-forms.label for="location" value="{{ __('Location') }}"
                                    class="mb-2 font-semibold" />
                                <span class="text-xs font-semibold text-gray-700 dark:text-slate-200"><span
                                        x-html="count"></span> / <span
                                        x-html="$refs.countme.maxLength"></span>
                                </span>
                            </div>
                            <x-forms.input wire:model="location" name="location" type="text"
                                placeholder="{{ __('Buckingham Palace, UK') }}"
                                maxlength="50" x-ref="countme"
                                x-on:keyup="count = $refs.countme.value.length" />
                        </section>

                        <section class="mt-6" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                            <div class="flex justify-between">
                                <x-forms.label for="company" value="{{ __('Company') }}"
                                    class="mb-2 font-semibold" />
                                <span class="text-xs font-semibold text-gray-700 dark:text-slate-200"><span
                                        x-html="count"></span> / <span
                                        x-html="$refs.countme.maxLength"></span>
                                </span>
                            </div>
                            <x-forms.input wire:model="company" name="company" type="text"
                                placeholder="{{ __('What do you do? Example: CEO at Meta Company Inc.') }}"
                                maxlength="50"
                                x-ref="countme"
                                x-on:keyup="count = $refs.countme.value.length" />
                        </section>

                        <section class="mt-6" x-data="{ count: 0 }" x-init="count = $refs.countme.value.length">
                            <div class="flex justify-between">
                                <x-forms.label for="education" value="{{ __('Education') }}"
                                    class="mb-2 font-semibold" />
                                <span class="text-xs font-semibold text-gray-700 dark:text-slate-200"><span
                                        x-html="count"></span> / <span
                                        x-html="$refs.countme.maxLength"></span>
                                </span>
                            </div>
                            <x-forms.input wire:model="education" name="education" type="text"
                                placeholder="{{ __('Where did you go to school?') }}"
                                maxlength="50" x-ref="countme"
                                x-on:keyup="count = $refs.countme.value.length" />
                        </section>

                        <section class="mt-6">
                            <x-buttons.primary-button>{{ __('Save') }}</x-buttons.primary-button>
                        </section>
                    </form>
                </div>
            </div>

            <div x-show="tab === 'social'" x-cloak>
                <div class="mt-6">
                    <form wire:submit='saveSocialProfiles'>
                        <section>
                            <x-forms.label for="facebook" value="Facebook" class="mb-2 font-semibold" />
                            <x-forms.input wire:model="facebook" name="facebook" type="text"
                                placeholder="https://facebook.com/username" />
                        </section>

                        <section class="mt-6">
                            <x-forms.label for="twitter" value="Twitter" class="mb-2 font-semibold" />
                            <x-forms.input wire:model="twitter" name="twitter" type="text"
                                placeholder="https://twitter.com/username" />
                        </section>

                        <section class="mt-6">
                            <x-forms.label for="instagram" value="Instagram" class="mb-2 font-semibold" />
                            <x-forms.input wire:model="instagram" name="instagram" type="text"
                                placeholder="https://instagram.com/username" />
                        </section>

                        <section class="mt-6">
                            <x-forms.label for="tiktok" value="Tiktok" class="mb-2 font-semibold" />
                            <x-forms.input wire:model="tiktok" name="tiktok" type="text"
                                placeholder="https://tiktok.com/username" />
                        </section>

                        <section class="mt-6">
                            <x-forms.label for="youtube" value="Youtube" class="mb-2 font-semibold" />
                            <x-forms.input wire:model="youtube" name="youtube" type="text"
                                placeholder="https://youtube.com/channel" />
                        </section>

                        <section class="mt-6">
                            <x-buttons.primary-button>{{ __('Save') }}</x-buttons.primary-button>
                        </section>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-span-4 mb-6 md:mt-0">
            <div class="bg-white p-4 shadow dark:bg-slate-800 dark:text-slate-200 sm:rounded-lg">
                <div class="mb-3 font-bold">{{ __('Settings') }}</div>
                <div class="flex flex-col text-gray-700 dark:text-white">
                    <button
                        class="-mx-4 flex items-center px-4 py-3 hover:bg-primary-50 dark:hover:bg-primary-800 dark:hover:text-white"
                        @click="tab = 'account'"
                        :class="{
                            'text-black dark:text-white font-semibold bg-primary-100 dark:bg-primary-900': tab ===
                                'account'
                        }">
                        <x-icons.user.settings class="mr-3 h-6 w-6" />
                        <span>{{ __('Account') }}</span>
                    </button>
                    <button
                        class="-mx-4 flex items-center px-4 py-3 hover:bg-primary-50 dark:hover:bg-primary-800 dark:hover:text-white"
                        @click="tab = 'security'"
                        :class="{
                            'text-black dark:text-white font-semibold bg-primary-100 dark:bg-primary-900': tab ===
                                'security'
                        }">
                        <x-icons.user.security class="mr-3" />
                        <span>{{ __('Security') }}</span>
                    </button>
                    <button
                        class="-mx-4 flex items-center px-4 py-3 hover:bg-primary-50 dark:hover:bg-primary-800 dark:hover:text-white"
                        @click="tab = 'profile'"
                        :class="{
                            'text-black dark:text-white font-semibold bg-primary-100 dark:bg-primary-900': tab ===
                                'profile'
                        }">
                        <x-icons.user.profile class="mr-3" />
                        <span>{{ __('Profile') }}</span>
                    </button>
                    <button
                        class="-mx-4 flex items-center px-4 py-3 hover:bg-primary-50 dark:hover:bg-primary-800 dark:hover:text-white"
                        @click="tab = 'social'"
                        :class="{
                            'text-black dark:text-white font-semibold bg-primary-100 dark:bg-primary-900': tab ===
                                'social'
                        }">
                        <x-icons.user.social-profiles class="mr-3" />
                        <span>{{ __('Social Profiles') }}</span>
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
