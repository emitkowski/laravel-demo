<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddressRequest;
use App\Models\Address;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;

/**
 * Class AddressController
 *
 * @package App\Http\Controllers
 */
class AddressController extends Controller
{
    use PolymorphicResponse;

    /**
     * Address Model
     *
     * @var Address
     */
    private $address_model;

    /**
     * Create a new controller instance.
     *
     * @param Address $address_model
     */
    public function __construct(Address $address_model)
    {
        $this->middleware('auth');
        $this->address_model = $address_model;
    }

    /**
     * Get Addresses
     *
     * @param $type
     * @param $id
     * @return JsonResponse
     */
    public function index($type, $id)
    {
        if (auth()->user()->cant('view', [Address::class, $id])) {
            return response()->json(['Permission Denied']);
        }

        $object = $this->getObject($type, $id);

        if (is_a($object, JsonResponse::class)) {
            return $object;
        }

        return response()->json($object->addresses);
    }

    /**
     * Store Address
     *
     * @param AddressRequest $request
     * @param $type
     * @param $id
     * @return JsonResponse
     */
    public function store(AddressRequest $request, $type, $id)
    {
        if (auth()->user()->cant('create', [Address::class, $id])) {
            return response()->json(['Permission Denied']);
        }

        $object = $this->getObject($type, $id);

        if (is_a($object, JsonResponse::class)) {
            return $object;
        }

        $address = new Address();
        $address->type = $request->input('type');
        $address->address = $request->input('address');
        $address->address2 = $request->input('address2');
        $address->city = $request->input('city');
        $address->state = $request->input('state');
        $address->postal = $request->input('postal');
        $address->postal_additional = $request->input('postal_additional');
        $address->country = $request->input('country');
        $address->phone = $request->input('phone');

        if (!$object->hasDefaultAddressForType($request->input('type'))) {
            $address->default = 1;
        }


        $object->addresses()->save($address);

        return response()->json('success');
    }


    /**
     * Update Address
     *
     * @param AddressRequest $request
     * @param Address $address
     * @return JsonResponse
     */
    public function update(AddressRequest $request, Address $address)
    {
        if (auth()->user()->cant('update', $address)) {
            return response()->json(['Permission Denied']);
        }

        $address->type = $request->input('type');
        $address->address = $request->input('address');
        $address->address2 = $request->input('address2');
        $address->city = $request->input('city');
        $address->state = $request->input('state');
        $address->postal = $request->input('postal');
        $address->postal_additional = $request->input('postal_additional');
        $address->country = $request->input('country');
        $address->phone = $request->input('phone');

        if ($address->isDirty('type')) {

            // Find new default for this type if switching address type
            if ($address->isDefault()) {
                $address->addressable->findNewDefaultForAddressType($address->type);
                $address->default = 0;
            }

            if (!$address->addressable->hasDefaultAddressForType($request->input('type'))) {
                $address->default = 1;
            }

        }

        $address->save();

        return response()->json('success');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Address $address
     * @return JsonResponse
     * @throws \Exception
     */
    public function destroy(Address $address)
    {
        if (auth()->user()->cant('delete', $address)) {
            return response()->json(['Permission Denied']);
        }

        if (!$address) {
            return response()->json('Address Not Found');
        }

        try {
            // Pick new default before delete
            if ($address->isDefault()) {
                $address->addressable->findNewDefaultForAddressType($address->type);
            }

            $address->delete();
        } catch (QueryException $exception) {
            return response()->json(['failed'], 400);
        }


        return response()->json('success');
    }

    /**
     * Set Default Address
     *
     * @param Address $address
     * @return JsonResponse
     */
    public function setDefault(Address $address)
    {
        if (auth()->user()->cant('update', $address)) {
            return response()->json(['Permission Denied']);
        }

        $address->addressable->makeDefaultAddress($address);

        return response()->json('success');
    }

}
