<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ContactUsMail;

class PageController extends Controller
{
    public function about()
    {
        return view('about.index');
    }

    public function faq()
    {
        return view('faq.index');
    }

    // CONTACT
    public function contactUsShow()
    {
        return view('contact.index');
    }
    public function contactUs(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);
        /// ini nanti ke emai nya
        Mail::to('kendramahardhika20@gmail.com')->send(new ContactUsMail($request->all()));

        return back()->with('success', 'Pesan Email Berhasil dikirim');
    }
}
