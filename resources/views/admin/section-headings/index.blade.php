<x-admin-layout>
    <x-slot name="title">Section Headings - Admin</x-slot>

    <style>
        .section-heading-wrapper {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .page-title {
            margin: 0;
            font-size: 26px;
            font-weight: 700;
            color: #1f2937;
        }

        .add-btn {
            display: inline-block;
            background: #2563eb;
            color: #ffffff;
            padding: 10px 18px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            transition: 0.2s;
        }

        .add-btn:hover {
            background: #1d4ed8;
            color: #ffffff;
        }

        .success-message {
            background: #dcfce7;
            color: #166534;
            border: 1px solid #bbf7d0;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 14px;
        }

        .table-card {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .table-wrapper {
            width: 100%;
            overflow-x: auto;
        }

        .heading-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        .heading-table thead {
            background: #f3f4f6;
        }

        .heading-table th {
            padding: 14px 16px;
            text-align: left;
            font-size: 13px;
            font-weight: 700;
            color: #374151;
            border-bottom: 1px solid #e5e7eb;
        }

        .heading-table td {
            padding: 14px 16px;
            font-size: 14px;
            color: #4b5563;
            border-bottom: 1px solid #e5e7eb;
            vertical-align: middle;
        }

        .heading-table tbody tr:hover {
            background: #f9fafb;
        }

        .section-key {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            padding: 5px 9px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .heading-text {
            font-weight: 600;
            color: #111827;
        }

        .subheading-text {
            color: #6b7280;
        }

        .action-buttons {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .edit-btn {
            background: #f59e0b;
            color: #ffffff;
            border: none;
            padding: 7px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            cursor: pointer;
        }

        .edit-btn:hover {
            background: #d97706;
            color: #ffffff;
        }

        .delete-btn {
            background: #dc2626;
            color: #ffffff;
            border: none;
            padding: 7px 12px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
        }

        .delete-btn:hover {
            background: #b91c1c;
        }

        .empty-row {
            text-align: center !important;
            padding: 40px 20px !important;
            color: #9ca3af !important;
        }

        @media (max-width: 768px) {

            .section-heading-wrapper {
                margin: 20px auto;
                padding: 0 15px;
            }

            .page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 15px;
            }

            .add-btn {
                width: 100%;
                text-align: center;
                box-sizing: border-box;
            }

            .page-title {
                font-size: 22px;
            }
        }
    </style>


    <div class="section-heading-wrapper">

        <!-- Header -->
        <div class="page-header">

            <h2 class="page-title">
                Section Headings
            </h2>

            <a href="{{ route('admin.section-headings.create') }}"
               class="add-btn">
                + Add Heading
            </a>

        </div>


        <!-- Success Message -->
        @if(session('success'))

            <div class="success-message">
                {{ session('success') }}
            </div>

        @endif


        <!-- Table -->
        <div class="table-card">

            <div class="table-wrapper">

                <table class="heading-table">

                    <thead>
                        <tr>
                            <th width="60">#</th>
                            <th>Section Key</th>
                            <th>Heading</th>
                            <th>Subheading</th>
                            <th width="180">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($headings as $heading)

                            <tr>

                                <td>
                                    {{ $loop->iteration }}
                                </td>

                                <td>
                                    <span class="section-key">
                                        {{ $heading->section_key }}
                                    </span>
                                </td>

                                <td>
                                    <span class="heading-text">
                                        {{ $heading->heading }}
                                    </span>
                                </td>

                                <td>
                                    <span class="subheading-text">
                                        {{ $heading->subheading ?: '-' }}
                                    </span>
                                </td>

                                <td>

                                    <div class="action-buttons">

                                        <a href="{{ route('admin.section-headings.edit', $heading->id) }}"
                                           class="edit-btn">
                                            Edit
                                        </a>


                                        <form action="{{ route('admin.section-headings.destroy', $heading->id) }}"
                                              method="POST"
                                              style="margin:0;">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="delete-btn"
                                                    onclick="return confirm('Are you sure you want to delete this heading?')">
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="empty-row">
                                    No section headings found.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-admin-layout>