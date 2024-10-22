<?php

namespace App\Modules\Post\Http\Controllers;

use App\Core\Controllers\Controller;
use App\Modules\Post\Infrastructure\Models\Privacy;
use Illuminate\Http\Request;

class PrivacyController extends Controller
{
    public function index()
    {
        return Privacy::all();
    }

    public function store(Request $request)
    {
        $request->validate(['privacy_name' => 'required|string|max:255']);
        return Privacy::create($request->all());
    }

    public function show(Privacy $privacy)
    {
        return $privacy;
    }

    public function update(Request $request, Privacy $privacy)
    {
        $request->validate(['privacy_name' => 'required|string|max:255']);
        $privacy->update($request->all());
        return $privacy;
    }

    public function destroy(Privacy $privacy)
    {
        $privacy->delete();
        return response()->noContent();
    }
}
