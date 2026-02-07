public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        // Redirect to that admin residents page we made!
        return redirect()->intended('admin/residents');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
}