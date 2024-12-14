<?php
namespace App\Livewire\Forms;

use Illuminate\Database\Eloquent\Model;
use Livewire\Form;
abstract class AbstractForm extends Form
{
    public abstract function save() : mixed;
    public function verify()
    {
        $this->validate(
            $this->getRules()
        );
    }
}