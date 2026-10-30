<x-admin-layout>
    <x-slot name="title">Edit Section Heading - Admin</x-slot>

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

        .page-title {
            margin: 0 0 25px;
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            display: block;
            margin-bottom: 8px;
            font-size: 14px;
            font-weight: 600;
            color: #374151;
        }

        .form-control-custom {
            width: 100%;
            padding: 11px 14px;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #111827;
            font-size: 14px;
            outline: none;
            box-sizing: border-box;
            transition: 0.2s;
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
            border: none;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
            transition: 0.2s;
        }

        .btn-update {
            background: #2563eb;
            color: #ffffff;
        }

        .btn-update:hover {
            background: #1d4ed8;
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

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            border: 1px solid #fecaca;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .section-key-info {
            margin-top: 6px;
            font-size: 12px;
            color: #6b7280;
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
                width: 100%;
                text-align: center;
                box-sizing: border-box;
            }
        }
    </style>


    <div class="section-heading-wrapper">

        <div class="section-heading-card">

            <h2 class="page-title">
                Edit Section Heading
            </h2>


            {{-- Validation Errors --}}
            @if ($errors->any())

                <div class="alert-error">

                    <ul style="margin:0; padding-left:20px;">

                        @foreach ($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            @endif


            <form action="{{ route('admin.section-headings.update', $sectionHeading->id) }}"
                  method="POST">

                @csrf
                @method('PUT')


                {{-- Section Key --}}
                <div class="form-group">

                    <label class="form-label">
                        Section Key
                    </label>

                    <input type="text"
                           name="section_key"
                           class="form-control-custom"
                           value="{{ old('section_key', $sectionHeading->section_key) }}"
                           required>

                    <div class="section-key-info">
                        Example: featured_products
                    </div>

                    @error('section_key')

                        <div class="error-message">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Heading --}}
                <div class="form-group">

                    <label class="form-label">
                        Heading
                    </label>

                    <input type="text"
                           name="heading"
                           class="form-control-custom"
                           placeholder="FEATURED PRODUCTS"
                           value="{{ old('heading', $sectionHeading->heading) }}"
                           required>

                    @error('heading')

                        <div class="error-message">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Subheading --}}
                <div class="form-group">

                    <label class="form-label">
                        Subheading
                    </label>

                    <input type="text"
                           name="subheading"
                           class="form-control-custom"
                           placeholder="Our Top Picks"
                           value="{{ old('subheading', $sectionHeading->subheading) }}">

                    @error('subheading')

                        <div class="error-message">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- Buttons --}}
                <div class="button-wrapper">

                    <button type="submit"
                            class="btn-custom btn-update">
                        Update
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