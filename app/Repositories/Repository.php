<?php
namespace App\Repositories;

abstract class Repository{
    abstract public function store ($attributes);
    abstract public function update ($model, $attributes);
    abstract public function forceDelete ($model);

}
