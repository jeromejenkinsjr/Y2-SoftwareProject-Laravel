<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscribeController extends Controller
{
    public function checkout(Request $request)
    {
        $user = $request->user();

        $validated = $request->validate([
            'plan' => 'required|in:teacher,student',
        ]);

        $plan = $validated['plan'];

        // Fetch the Stripe Price ID based on selected plan
        $priceId = $plan === 'teacher'
            ? config('services.stripe.price_teacher')
            : config('services.stripe.price_student');

        return $user->newSubscription('default', $priceId)
            ->trialDays(14) // Change to 14 if you want a trial
            ->checkout([
                'success_url' => route('subscribe.success'),
                'cancel_url' => route('subscribe.cancel'),
            ]);
    }

    public function success(Request $request)
    {
        $user = $request->user();

        $user->update([
            'premium' => true,
        ]);

        return view('subscribe-success');
    }

    public function cancel()
    {
        return view('subscribe-cancel');
    }
}