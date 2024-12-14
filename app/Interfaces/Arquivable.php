<?php
namespace App\Interfaces;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

interface Arquivable
{
    public function createNewArchive(array $input) : Model;
    public function getRelationshipBuilder(): MorphOne|MorphMany;
}