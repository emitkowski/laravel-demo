<?php

namespace App\Models\Traits;
use App\Models\Address;

/**
 * Trait Addressable
 *
 * @package App\Models\Traits
 */
trait Addressable
{
    /**
     * Addresses Relation
     */
    public function addresses()
    {
        return $this->morphMany('App\Models\Address', 'addressable')->orderBy('type', 'desc');
    }

    /**
     * Set the address as default for its type
     *
     * @param $address
     * @return bool
     */
    public function makeDefaultAddress(Address $address)
    {
        $current_addresses = $this->addresses()->where('type', $address->type)->where('default', 1)->get();

        foreach ($current_addresses as $current_address) {
            $current_address->removeDefault();
        }

        return $address->setDefault();
    }

    /**
     * Check if has default address for type
     *
     * @param $type
     * @return string
     */
    public function hasDefaultAddressForType($type)
    {
        $default_address = $this->addresses()->where('type', $type)->where('default', 1)->first();

        if ($default_address) {
            return true;
        }

        return false;
    }

    /**
     * Find and set new default address for type to first found
     *
     * @param $type
     * @return bool
     */
    public function findNewDefaultForAddressType($type)
    {
        $address = $this->addresses()->where('type', $type)->where('default', 0)->first();

        if ($address) {
            $address->setDefault();
        }

        return true;
    }


}