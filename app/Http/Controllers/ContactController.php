<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Tracker\CreateMetricRequest;

class ContactController extends Controller {

    public function create(Request $request) {
        //return view('contact.create');
        return view('footer.contact', [
            'webmasterEmail' => 'info@tracal.mjeffe.com',
        ]);

    }

    public function store(Request $request) {
        return view('contact.thankyou');
    }
}
