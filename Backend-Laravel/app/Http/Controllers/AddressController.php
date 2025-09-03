<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAddressRequest;
use App\Http\Requests\UpdateAddressRequest;
use App\Models\Address;
use Illuminate\Http\Request;

class AddressController extends Controller
{
    /**
     * GET /addresses
     */
    public function index(Request $request)
    {
        return $request->user()->addresses()->latest()->get();
    }

    /**
     * POST /addresses
     */
    public function store(StoreAddressRequest $request)
    {
        $addr = $request->user()->addresses()->create($request->validated());
        return response()->json($addr, 201);
    }

    /**
     * GET /addresses/{address}
     */
    public function show(Request $request, Address $address)
    {
        $this->authorizeOwner($request, $address);
        return $address;
    }

    /**
     * PUT/PATCH /addresses/{address}
     */
    public function update(UpdateAddressRequest $request, Address $address)
    {
        $this->authorizeOwner($request, $address);
        $address->update($request->validated());
        return $address->fresh();
    }

    /**
     * DELETE /addresses/{address}
     */
    public function destroy(Request $request, Address $address)
    {
        $this->authorizeOwner($request, $address);
        $address->delete();
        return response()->noContent();
    }

    /**
     * PATCH /addresses/{address}/set-default
     * body: { "type": "shipping" | "billing" | "both" }
     */
    public function setDefault(Request $request, Address $address)
    {
        $this->authorizeOwner($request, $address);

        $type = $request->validate([
            'type' => ['required','in:shipping,billing,both']
        ])['type'];

        if (in_array($type, ['shipping','both'], true)) {
            $request->user()->addresses()->update(['is_default_shipping' => false]);
            $address->is_default_shipping = true;
        }

        if (in_array($type, ['billing','both'], true)) {
            $request->user()->addresses()->update(['is_default_billing' => false]);
            $address->is_default_billing = true;
        }

        $address->save();

        return $address->fresh();
    }

    private function authorizeOwner(Request $request, Address $address): void
    {
        abort_unless($address->user_id === $request->user()->id, 403, 'Forbidden');
    }
}
