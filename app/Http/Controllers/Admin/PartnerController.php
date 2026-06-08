<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePartnerRequest;
use App\Models\Partner;
use Illuminate\Support\Facades\Storage;

class PartnerController extends Controller
{
    public function index()
    {
        return view('admin.partners.index', [
            'partners' => Partner::orderBy('sort_order')->paginate(15),
        ]);
    }

    public function create()
    {
        return view('admin.partners.create');
    }

    public function store(StorePartnerRequest $request)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }
        Partner::create($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner added.');
    }

    public function edit(Partner $partner)
    {
        return view('admin.partners.edit', compact('partner'));
    }

    public function update(StorePartnerRequest $request, Partner $partner)
    {
        $data = $request->validated();
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('logo')) {
            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }
            $data['logo'] = $request->file('logo')->store('partners', 'public');
        }
        $partner->update($data);

        return redirect()->route('admin.partners.index')->with('success', 'Partner updated.');
    }

    public function destroy(Partner $partner)
    {
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }
        $partner->delete();

        return redirect()->route('admin.partners.index')->with('success', 'Partner removed.');
    }
}
