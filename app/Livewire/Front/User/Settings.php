<?php

namespace App\Livewire\Front\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Livewire\Component;
use WireUi\Traits\Actions;

class Settings extends Component
{
    use AuthorizesRequests;
    use Actions;

    public $user;

    public $name;

    public $username;

    public $email;

    public $bio;

    public $website;

    public $location;

    public $company;

    public $education;

    public $facebook;

    public $twitter;

    public $instagram;

    public $tiktok;

    public $youtube;

    public $currentPassword = '';

    public $newPassword = '';

    public $confirmPassword = '';

    public function mount()
    {
        $this->name = auth()->user()->name;
        $this->username = auth()->user()->username;
        $this->email = auth()->user()->email;

        $this->bio = auth()->user()->profile->bio;
        $this->website = auth()->user()->profile->website;
        $this->location = auth()->user()->profile->location;
        $this->company = auth()->user()->profile->company;
        $this->education = auth()->user()->profile->education;

        $this->facebook = auth()->user()->profile->facebook;
        $this->twitter = auth()->user()->profile->twitter;
        $this->instagram = auth()->user()->profile->instagram;
        $this->tiktok = auth()->user()->profile->tiktok;
        $this->youtube = auth()->user()->profile->youtube;
    }

    protected function rulesWithoutCurrentPassword(): array
    {
        return [
            'newPassword' => [
                'required',
                Password::min(8)->numbers(),
            ],
            'confirmPassword' => 'required|same:newPassword',
        ];
    }

    protected function rulesWithCurrentPassword(): array
    {
        return [
            'currentPassword' => [
                'required', function ($attribute, $value, $fail) {
                    if (! Hash::check($value, auth()->user()->password)) {
                        $fail('Your password was not updated, since the provided current password does not match.');
                    }
                },
            ],
            'newPassword' => [
                'required',
                Password::min(8)->numbers(),
            ],
            'confirmPassword' => 'required|same:newPassword',
        ];
    }

    public function updatePassword()
    {
        if (auth()->user()->hasPassword()) {
            $this->validate($this->rulesWithCurrentPassword());
        }

        $this->validate($this->rulesWithoutCurrentPassword());

        $updatePass = auth()->user()->update([
            'password' => Hash::make($this->newPassword),
        ]);

        $this->notification()->success(
            $title = __('Password successfully updated!'),
        );
    }

    public function saveAccount()
    {
        if ($this->name) {
            $validatedName = $this->validate([
                'name' => 'min:3|max:150',
            ]);
            auth()->user()->update($validatedName);
        }

        if ($this->username) {
            $validatedUsername = $this->validate([
                'username' => ['min:3', 'max:150', Rule::unique('users')->ignore(auth()->id())],
            ]);
            auth()->user()->update($validatedUsername);
        }

        if ($this->email) {
            $validatedEmail = $this->validate([
                'email' => ['min:10', 'max:150', Rule::unique('users')->ignore(auth()->id())],
            ]);
            auth()->user()->update($validatedEmail);
        }

        // Notify User to update data Account updated!
        $this->notification()->success(
            $title = __('Account successfully updated!'),
        );
    }

    public function saveProfile()
    {
        if ($this->bio) {
            $validatedBio = $this->validate([
                'bio' => 'min:5|max:200',
            ]);
            auth()->user()->profile->update($validatedBio);
        }

        if ($this->website) {
            $validatedWebsite = $this->validate([
                'website' => 'url|min:10|max:100',
            ]);
            auth()->user()->profile->update($validatedWebsite);
        }

        if ($this->location) {
            $validatedLocation = $this->validate([
                'location' => 'min:3|max:100',
            ]);
            auth()->user()->profile->update($validatedLocation);
        }

        if ($this->company) {
            $validatedCompany = $this->validate([
                'company' => 'min:3|max:100',
            ]);
            auth()->user()->profile->update($validatedCompany);
        }

        if ($this->education) {
            $validatedEducation = $this->validate([
                'education' => 'min:10|max:100',
            ]);
            auth()->user()->profile->update($validatedEducation);
        }

        // Notify User to update data
        $this->notification()->success(
            $title = __('Profile successfully updated!'),
        );
    }

    public function saveSocialProfiles()
    {
        if ($this->facebook) {
            $validatedFacabook = $this->validate([
                'facebook' => 'url|min:6',
            ]);
            auth()->user()->profile->update($validatedFacabook);
        }

        if ($this->twitter) {
            $validatedTwitter = $this->validate([
                'twitter' => 'url|min:6',
            ]);
            auth()->user()->profile->update($validatedTwitter);
        }

        if ($this->instagram) {
            $validatedInstagram = $this->validate([
                'instagram' => 'url|min:6',
            ]);
            auth()->user()->profile->update($validatedInstagram);
        }

        if ($this->tiktok) {
            $validatedTiktok = $this->validate([
                'tiktok' => 'url|min:6',
            ]);
            auth()->user()->profile->update($validatedTiktok);
        }

        if ($this->youtube) {
            $validatedYoutube = $this->validate([
                'youtube' => 'url|min:6',
            ]);
            auth()->user()->profile->update($validatedYoutube);
        }

        // Notify User to update data
        $this->notification()->success(
            $title = __('Social profiles successfully updated!'),
        );
    }

    public function deleteAccount()
    {
        $this->authorize('delete', getCurrentUser());

        if (getCurrentUser()->stories->count() > 0) {
            $this->notification()->warning(
                $title = __('Can\'t delete account!'),
                $description = __('Sorry but you have ').getCurrentUser()->stories->count().__(' stories please delete them before deleting account!'),
            );
        } else {
            getCurrentUser()->delete();

            return redirect()->route('home');
        }
    }

    public function render()
    {
        return view('livewire.front.user.settings');
    }
}
