<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputController extends Controller
{
    public function hello(Request $request):string {
        $name = $request->input("name");
        return "Hello $name";
    }

    public function helloFirstName(Request $request):string 
    {
        $firstName = $request->input('name.first');
        return "Hello $firstName";
    }

    public function helloInput(Request $request):string {
        $input = $request->input(); // semua yang dikirim baik dari query params atau request body bakalan masuk ke dalam array $input
        return json_encode($input);
    }

    public function helloArray(Request $request):string
    {
        $names = $request->input('products.*.name'); // hanya ambil nama produknya aja 
        return json_encode($names);
    }

    public function inputType(Request $request):string
    {
        // typecast
        $name= $request->input("name");
        $married = $request->boolean('married');
        $birthDate = $request->date('birth_date','Y-m-d');
        return json_encode([
            'name'=> $name,
            'married'=> $married,
            'birth_date'=> $birthDate->format('Y-m-d')
        ]);
    }

    public function filterOnly(Request $request):string {
        // pilih ini aja
        $name = $request->only(['name.first','name.last']);
        return json_encode($name);
    }

    public function filterExcept(Request $request):string 
    { // pilih semua kecuali
        $user = $request->except("admin");
        return json_encode($user);
    }

    public function filterMerge(Request $request):string
    { // tetap timpa data user apapun valuenya
        $request->merge([
            "admin"=>false
        ]);
        $user = $request->input();
        return json_encode($user);
    }
}
