<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class Logout extends Component
{
    public function logout()
    {
        // تحديد الحارس المناسب
        $guard = Auth::check();

        Auth::logout();
        session()->flush();
        session()->invalidate();
        session()->regenerateToken();

        return $this->redirectRoute('login');
    }
    public function render()
    {
        return view('livewire.auth.logout');
    }
}
