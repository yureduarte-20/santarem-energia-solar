<?php
namespace App\Livewire\Forms;
use Livewire\Form;
abstract class AbstractForm extends Form
{
    public function verify()
    {
        $this->validate(
            $this->getRules()
        );
    }
}