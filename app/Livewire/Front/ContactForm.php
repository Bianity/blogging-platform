<?php

namespace App\Livewire\Front;

use App\Models\Contact;
use Livewire\Component;
use WireUi\Traits\Actions;

class ContactForm extends Component
{
    use Actions;

    public $name;

    public $email;

    public $subject;

    public $message;

    public function submit()
    {
        $validated = $this->validate([
            'name' => 'required|min:5|max:150',
            'email' => 'required|email|max:150',
            'subject' => 'required|max:150',
            'message' => 'required|min:5|max:500',
        ]);

        Contact::create($validated);

        $this->notification()->success(
            $title = __('Message has been sent successfully')
        );

        $this->reset();
    }

    public function render()
    {
        return view('livewire.front.contact-form');
    }
}
