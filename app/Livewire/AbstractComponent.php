<?php

namespace App\Livewire;

use Livewire\Component;

abstract class AbstractComponent extends Component
{
    abstract public function rules(): array;

    abstract public function store();

    abstract public function render();
}
