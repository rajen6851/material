<x-admin-layout>
    <x-slot name="title">Add Section Heading - Admin</x-slot>

    <style>
        .section-heading-wrapper {
            max-width: 900px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .section-heading-card {
            background: #ffffff;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }

        .section-heading-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 8px;
        }

        .form-control-custom {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            font-size: 14px;
            color: #111827;
            background: #fff;
            outline: none;
            transition: 0.2s;
            box-sizing: border-box;
        }

        .form-control-custom:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
        }

        .form-control-custom::placeholder {
            color: #9ca3af;
        }

        .button-wrapper {
            display: flex;
            gap: 10px;
            margin-top: 25px;
        }

        .btn-custom {
            display: inline-block;
            padding: 10px 20px;
            border-radius: 8px;
            border: none;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-save {
            background: #16a34a;
            color: #ffffff;
        }

        .btn-save:hover {
            background: #15803d;
        }

        .btn-cancel {
            background: #6b7280;
            color: #ffffff;
        }

        .btn-cancel:hover {
            background: #4b5563;
        }

        .error-message {
            color: #dc2626;
            font-size: 13px;
            margin-top: 5px;
        }

        @media (max-width: 768px) {
            .section-heading-wrapper {
                margin: 20px auto;
                padding: 0 15px;
            }

            .section-heading-card {
                padding: 20px;
            }

            .button-wrapper {
                flex-direction: column;
            }

            .btn-custom {
                text-align: center;
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>

    <div class="section-heading-wrapper">

        <div class="section-heading-card">

            <h2 class="section-heading-title">
                Add Section Heading
            </h2>

            @if ($errors->any())
                <div style="background:#fee2e2; color:#991b1b; padding:12px; border-radius:8px; margin-bottom:20px;">
                    <ul style="margin:0; padding-left:20px;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.section-headings.store') }}"
                  method="POST">

                @csrf

                <div class="form-group">
                    <label class="form-label">
                        Section Key
                    </label>

                    <input type="text"
                           name="section_key"
                           class="form-control-custom"
                           placeholder="featured_products"
                           value="{{ old('section_key') }}"
                           required>

                    @error('section_key')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label class="form-label">
                        Heading
                    </label>

                    <input type="text"
                           name="heading"
                           class="form-control-custom"
                           placeholder="FEATURED PRODUCTS"
                           value="{{ old('heading') }}"
                           required>

                    @error('heading')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="form-group">
                    <label class="form-label">
                        Subheading
                    </label>

                    <input type="text"
                           name="subheading"
                           class="form-control-custom"
                           placeholder="Our Top Picks"
                           value="{{ old('subheading') }}">

                    @error('subheading')
                        <div class="error-message">
                            {{ $message }}
                        </div>
                    @enderror
                </div>


                <div class="button-wrapper">

                    <button type="submit"
                            class="btn-custom btn-save">
                        Save
                    </button>

                    <a href="{{ route('admin.section-headings.index') }}"
                       class="btn-custom btn-cancel">
                        Cancel
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-admin-layout>