<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Device;

class DeviceController extends Controller
{
    public function index()
    {
        return view('devices.index');
    }

    public function show(Device $device)
    {
        return view('devices.show', compact('device'));
    }

    public function update(Request $request, Device $device)
    {
        return redirect()->route('devices.index');
    }

    public function destroy(Device $device)
    {
        return redirect()->route('devices.index');
    }
}