<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ in_array(app()->getLocale(), ['ku', 'ar']) ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('invoice.settings') }} — Beston Oil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }
        body { background: #d0d0d0; font-family: 'Segoe UI', Arial, sans-serif; min-height: 100vh; }

        /* Nav */
        .top-nav {
            background: #1565c0; color: #fff; display: flex; align-items: center;
            justify-content: space-between; padding: 0 28px; height: 52px;
            position: sticky; top: 0; z-index: 100;
        }
        .nav-brand { font-size: 1.1rem; font-weight: 700; color: #fff; text-decoration: none; }
        .nav-links { display: flex; gap: 8px; align-items: center; }
        .nav-btn { padding: 6px 16px; border-radius: 4px; font-size: 0.88rem; font-weight: 600; cursor: pointer; text-decoration: none; border: none; }
        .nav-btn-outline { background: transparent; color: #fff; border: 1.5px solid rgba(255,255,255,0.6); }
        .nav-btn-outline:hover { background: rgba(255,255,255,0.12); }
        .nav-btn-solid { background: #fff; color: #1565c0; }
        .nav-btn-solid:hover { background: #e3f0ff; }
        .lang-btns { display: flex; gap: 6px; margin-left: 12px; }
        [dir="rtl"] .lang-btns { margin-left: 0; margin-right: 12px; }
        .lang-btn { padding: 4px 10px; border-radius: 4px; background: rgba(255,255,255,0.15); color: #fff; border: none; cursor: pointer; font-size: 0.8rem; }
        .lang-btn:hover { background: rgba(255,255,255,0.3); }

        /* Page */
        .page-wrapper { max-width: 700px; margin: 32px auto; padding: 0 16px; }

        .page-title {
            font-size: 1.4rem; font-weight: 700; color: #222;
            margin-bottom: 20px; display: flex; align-items: center; gap: 10px;
        }

        .flash {
            padding: 12px 16px; border-radius: 6px; margin-bottom: 18px;
            font-size: 0.92rem; font-weight: 600;
            background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7;
        }

        .card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.12);
            overflow: hidden;
        }

        .card-section {
            padding: 22px 28px;
            border-bottom: 1px solid #e5e7eb;
        }
        .card-section:last-child { border-bottom: none; }

        .section-title {
            font-size: 0.85rem;
            font-weight: 700;
            color: #1565c0;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            margin-bottom: 16px;
        }

        .form-row { display: flex; flex-direction: column; margin-bottom: 14px; }
        .form-row:last-child { margin-bottom: 0; }
        .form-row label {
            font-size: 0.82rem; font-weight: 600; color: #555;
            margin-bottom: 5px; text-transform: uppercase; letter-spacing: 0.4px;
        }
        .form-row input[type="text"],
        .form-row select {
            padding: 9px 12px; border: 1.5px solid #ccc; border-radius: 5px;
            font-size: 0.95rem; font-family: inherit; width: 100%;
        }
        .form-row input:focus, .form-row select:focus { outline: none; border-color: #1565c0; }

        /* Logo section */
        .logo-section { display: flex; gap: 24px; align-items: flex-start; flex-wrap: wrap; }
        .logo-preview {
            width: 110px; height: 110px; border: 2px dashed #ccc; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: #f8faff; overflow: hidden; flex-shrink: 0;
        }
        .logo-preview img { max-width: 100%; max-height: 100%; object-fit: contain; }
        .logo-upload-area { flex: 1; min-width: 220px; }
        .logo-upload-area label {
            font-size: 0.82rem; font-weight: 600; color: #555;
            text-transform: uppercase; letter-spacing: 0.4px; display: block; margin-bottom: 6px;
        }
        .file-input-wrapper { position: relative; }
        .file-input-wrapper input[type="file"] {
            padding: 8px; border: 1.5px solid #ccc; border-radius: 5px;
            font-size: 0.88rem; width: 100%; cursor: pointer;
        }
        .file-input-wrapper input[type="file"]:focus { outline: none; border-color: #1565c0; }
        .file-hint { font-size: 0.78rem; color: #888; margin-top: 5px; }

        /* Save button */
        .card-footer {
            padding: 18px 28px;
            display: flex;
            justify-content: flex-end;
            background: #f8faff;
            border-top: 1px solid #e5e7eb;
        }
        .btn-save {
            background: #1565c0; color: #fff; border: none;
            padding: 10px 32px; border-radius: 6px; font-size: 0.95rem;
            font-weight: 700; cursor: pointer;
        }
        .btn-save:hover { background: #1976d2; }

        .error-msg { color: #dc2626; font-size: 0.82rem; margin-top: 4px; }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="top-nav">
        <a class="nav-brand" href="{{ route('invoice.create') }}">Beston Oil</a>
        <div class="nav-links">
            <a href="{{ route('invoice.create') }}" class="nav-btn nav-btn-solid">+ {{ __('invoice.new_invoice') }}</a>
            <a href="{{ route('invoices.index') }}" class="nav-btn nav-btn-outline">{{ __('invoice.all_invoices') }}</a>
            <a href="{{ route('settings.edit') }}" class="nav-btn nav-btn-outline">⚙️ {{ __('invoice.settings') }}</a>
            <div class="lang-btns">
                <button class="lang-btn" onclick="window.location='/change-language/en'">EN</button>
                <button class="lang-btn" onclick="window.location='/change-language/ku'">KU</button>
                <button class="lang-btn" onclick="window.location='/change-language/ar'">AR</button>
            </div>
        </div>
    </nav>

    <div class="page-wrapper">
        <div class="page-title">⚙️ {{ __('invoice.settings') }}</div>

        @if(session('success'))
            <div class="flash">✓ {{ session('success') }}</div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="card">

                <!-- Logo section -->
                <div class="card-section">
                    <div class="section-title">{{ __('invoice.logo_upload') }}</div>
                    <div class="logo-section">
                        <div class="logo-preview">
                            <img id="logo-preview-img" src="{{ logo_url() }}" alt="Logo">
                        </div>
                        <div class="logo-upload-area">
                            <label>{{ __('invoice.logo_change') }}</label>
                            <div class="file-input-wrapper">
                                <input type="file" name="logo" id="logo-input" accept="image/*"
                                    onchange="previewLogo(this)">
                            </div>
                            <p class="file-hint">PNG, JPG, GIF or SVG — max 2 MB</p>
                            @error('logo') <p class="error-msg">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>

                <!-- Company details -->
                <div class="card-section">
                    <div class="section-title">{{ __('invoice.company_name_label') }}</div>
                    <div class="form-row">
                        <label>{{ __('invoice.company_name_label') }}</label>
                        <input type="text" name="company_name"
                               value="{{ old('company_name', $settings['company_name'] ?? '') }}" required>
                        @error('company_name') <p class="error-msg">{{ $message }}</p> @enderror
                    </div>
                    <div class="form-row">
                        <label>{{ __('invoice.company_address_label') }}</label>
                        <input type="text" name="company_address"
                               value="{{ old('company_address', $settings['company_address'] ?? '') }}">
                    </div>
                    <div class="form-row">
                        <label>{{ __('invoice.company_phone_label') }}</label>
                        <input type="text" name="company_phone"
                               value="{{ old('company_phone', $settings['company_phone'] ?? '') }}">
                    </div>
                    <div class="form-row">
                        <label>{{ __('invoice.company_location_label') }}</label>
                        <input type="text" name="company_location"
                               value="{{ old('company_location', $settings['company_location'] ?? '') }}"
                               placeholder="{{ __('invoice.company_location_placeholder') }}">
                    </div>
                    <div class="form-row">
                        <label>{{ __('invoice.company_info_label') }}</label>
                        <textarea name="company_info" rows="3"
                                  placeholder="{{ __('invoice.company_info_placeholder') }}"
                                  style="padding:9px 12px;border:1.5px solid #ccc;border-radius:5px;font-size:0.95rem;font-family:inherit;width:100%;resize:vertical;">{{ old('company_info', $settings['company_info'] ?? '') }}</textarea>
                    </div>
                </div>

                <!-- Default currency -->
                <div class="card-section">
                    <div class="section-title">{{ __('invoice.default_currency') }}</div>
                    <div class="form-row">
                        <label>{{ __('invoice.default_currency') }}</label>
                        <select name="default_currency">
                            <option value="IQD" @selected(($settings['default_currency'] ?? 'IQD') === 'IQD')>IQD — د.ع (Iraqi Dinar)</option>
                            <option value="USD" @selected(($settings['default_currency'] ?? 'IQD') === 'USD')>USD — $ (US Dollar)</option>
                        </select>
                    </div>
                </div>

            </div><!-- /.card -->

            <div class="card-footer" style="border-radius: 0 0 10px 10px;">
                <button type="submit" class="btn-save">💾 {{ __('invoice.save_settings') }}</button>
            </div>

        </form>
    </div>

    <script>
        function previewLogo(input) {
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = e => {
                    document.getElementById('logo-preview-img').src = e.target.result;
                };
                reader.readAsDataURL(input.files[0]);
            }
        }
    </script>
</body>
</html>
