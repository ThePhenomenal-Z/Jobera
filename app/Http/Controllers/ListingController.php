<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ListingController extends Controller
{
    // Show all listings
    public function index() {
        return view('listing.index', [
            //latest function will return all the listing sorted by the latest
            'listings' => Listing::latest()->filter(request(['tags','search']))->paginate(6)
        ]);
    }

    //Show single listing
    public function show(Listing $listing) {
        return view('listing.show', [
            'listing' => $listing
        ]);
    }

    // Show Create Form
    public function create() {
        return view('listing.create');
    }

    // Store Listing Data
    public function store(Request $request) {
       
        $formFields = $request->validate([
            'title' => 'required',
            'company_name' => ['required', Rule::unique('listings')],
            'location' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);
        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $formFields['user_id'] = auth()->id();

        Listing::create($formFields);

        //you can get a flash measage also by
        //Session::flash()
        return redirect('/')->with('message', 'Listing created successfully!');
    }

    // Show Edit Form
    public function edit(Listing $listing) {
        if($listing->user_id != auth()->id()){
            abort(403, 'Unauthorized Action');
        }
        return view('listing.edit', ['listing' => $listing]);
    }

    // Update Listing Data
    public function update(Request $request, Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        $formFields = $request->validate([
            'title' => 'required',
            'company_name' => ['required'],
            'location' => 'required',
            'email' => ['required', 'email'],
            'tags' => 'required',
            'description' => 'required'
        ]);

        if($request->hasFile('logo')) {
            $formFields['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $listing->update($formFields);

        return redirect('/')->with('message', 'Listing updated successfully!');
    }

    //Delete Listing
    public function destroy(Listing $listing) {
        // Make sure logged in user is owner
        if($listing->user_id != auth()->id()) {
            abort(403, 'Unauthorized Action');
        }
        
        // if($listing->logo && Storage::disk('public')->exists($listing->logo)) {
        //     Storage::disk('public')->delete($listing->logo);
        // }
        $listing->delete();
        return redirect('/')->with('message', 'Listing deleted successfully');
    }

    // Manage Listings
    public function manage() {
        return view('listing.manage', ['listings' => auth()->user()->listings()->get()]);
    }
}