<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $settings = Setting::allAsArray();
        return view('settings.edit', compact('settings'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'company_name'     => 'required|string|max:120',
            'company_address'  => 'nullable|string|max:300',
            'company_phone'    => 'nullable|string|max:60',
            'company_location' => 'nullable|string|max:200',
            'company_info'     => 'nullable|string|max:500',
            'default_currency' => 'required|in:IQD,USD',
            'logo'             => 'nullable|file|mimes:png,jpg,jpeg,gif,svg,webp|max:4096',
        ]);

        Setting::set('company_name',     $data['company_name']);
        Setting::set('company_address',  $data['company_address']  ?? '');
        Setting::set('company_phone',    $data['company_phone']    ?? '');
        Setting::set('company_location', $data['company_location'] ?? '');
        Setting::set('company_info',     $data['company_info']     ?? '');
        Setting::set('default_currency', $data['default_currency']);

        // Handle logo upload
        if ($request->hasFile('logo')) {
            $file = $request->file('logo');

            // Make sure the uploads directory exists
            $uploadDir = public_path('uploads');
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Delete old uploaded logo if it exists
            $old = Setting::get('company_logo');
            if ($old && file_exists(public_path($old))) {
                @unlink(public_path($old));
            }

            $ext      = strtolower($file->getClientOriginalExtension());
            $filename = 'logo_' . time() . '.' . $ext;
            $file->move($uploadDir, $filename);

            Setting::set('company_logo', 'uploads/' . $filename);
        }

        return redirect()->route('settings.edit')
                         ->with('success', __('invoice.settings_saved'));
    }
}
