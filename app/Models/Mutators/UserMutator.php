<?php

namespace App\Models\Mutators;

trait UserMutator
{
    /**
     * Email Mutator
     *
     * @param $value
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }

    /**
     * First Name Mutator
     *
     * @param $value
     */
    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst(strtolower($value));
    }

    /**
     * Last Name Mutator
     *
     * @param $value
     */
    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst(strtolower($value));
    }
}