<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
	/**
	 * Route example: GET /redirect/to
	 * Purpose: mengembalikan response string sederhana.
	 * Catatan: dapat dipakai sebagai target redirect dari redirectFrom().
	 */
	public function redirectTo(Request $request): string
	{
		return "Redirect To";
	}

	/**
	 * Route example: GET /redirect/from
	 * Purpose: mengembalikan RedirectResponse ke path "/redirect/to".
	 * Behaviour: menggunakan helper redirect() -> mengirim 302 redirect ke client.
	 */
	public function redirectFrom(Request $request): RedirectResponse
	{
		return redirect("/redirect/to");
	}

	/**
	 * Route binding (dengan name): 
	 * Route::get('/redirect/name/{name}', [RedirectController::class, 'redirectHello'])->name('redirect-hello');
	 * Purpose: menerima parameter {name} dari URL dan mengembalikan greeting "Hello {name}".
	 */
	public function redirectHello(string $name): string
	{
		return  "Hello $name";
	}

	/**
	 * Route example: GET /redirect/name
	 * Purpose: redirect ke named route 'redirect-hello' dengan parameter name => 'Ivriel'.
	 * Effect: mengarahkan client ke /redirect/name/Ivriel (named route membentuk URL dari parameter).
	 * Contoh alur:
	 *  - Pengguna ke /redirect/name
	 *  - Controller melakukan redirect()->route('redirect-hello', ['name'=>'Ivriel'])
	 *  - Browser dikirim 302 ke /redirect/name/Ivriel
	 *  - Browser meminta /redirect/name/Ivriel -> method redirectHello mengembalikan "Hello Ivriel"
	 */
	public function redirectName(): RedirectResponse
	{
		return redirect()->route("redirect-hello",[
			"name" =>"Ivriel"
		]);
	}

    public function redirectAction():RedirectResponse
    {
        return redirect()->action([RedirectController::class,"redirectHello"],['name'=>'Ivriel']);
    }

    public function redirectAway():RedirectResponse
    {
        return redirect()->away("https://www.shankarapaperstraw.com");
    }
}
