@extends('layouts.skydash')

@php
use Illuminate\Support\Facades\Storage;
@endphp

@section('content')
<div class="row">
    <div class="col-md-12 grid-margin">
        <div class="row">
            <div class="col-12 col-xl-8 mb-4 mb-xl-0">
                @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor']))
                    <h3 class="font-weight-bold">All Enrollments</h3>
                    <h6 class="font-weight-normal mb-0">View and manage student enrollments</h6>
                @else
                    <h3 class="font-weight-bold">My Enrollments</h3>
                    <h6 class="font-weight-normal mb-0">Track your learning progress</h6>
                @endif
            </div>
            <div class="col-12 col-xl-4">
                <div class="justify-content-end d-flex">
                    @if(!auth()->check() || !auth()->user()->hasAnyRole(['admin', 'instructor']))
                        <a href="{{ route('courses.index') }}" class="btn btn-primary">
                            <i class="icon-plus"></i> Browse Courses
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Enrollments DataTable -->
<div class="row">
    <div class="col-md-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <div class="table-responsive">
                    <table id="enrollmentsTable" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>User</th>
                                <th>Course</th>
                                <th>Status</th>
                                <th>Progress</th>
                                <th>Enrolled At</th>
                                <th>Completed At</th>
                                <th>Payment Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($enrollments as $index => $enroll)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $enroll->user->name }}</td>
                                <td>{{ $enroll->course->title }}</td>
                                <td>{{ $enroll->status }}</td>
                                <td>{{ $enroll->progress }}%</td>
                                <td>{{ $enroll->created_at }}</td>
                                <td>{{ $enroll->completed_at ?? '-' }}</td>
                                <td>{{ $enroll->payment_status }}</td>
                                <td>
                                    <button class="btn btn-sm btn-primary">Detail</button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
<style>
    /* General DataTable Styles */
    #enrollmentsTable_wrapper .dataTables_length,
    #enrollmentsTable_wrapper .dataTables_filter {
        margin-bottom: 20px;
    }
    
    #enrollmentsTable_wrapper .dataTables_filter {
        text-align: right;
    }
    
    #enrollmentsTable_wrapper .dataTables_filter input {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        margin-left: 10px;
        width: 250px;
    }
    
    #enrollmentsTable_wrapper .dataTables_length select {
        border-radius: 8px;
        padding: 8px 12px;
        border: 1px solid #ddd;
        margin: 0 5px;
    }
    
    .badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }
    
    .badge-success {
        background-color: #28a745;
        color: white;
    }
    
    .badge-info {
        background-color: #17a2b8;
        color: white;
    }
    
    .badge-warning {
        background-color: #ffc107;
        color: #333;
    }
    
    .progress {
        background-color: #e9ecef;
        border-radius: 10px;
        min-width: 80px;
    }
    
    .progress-bar {
        border-radius: 10px;
    }
    
    .btn-group .btn {
        margin-right: 5px;
    }
    
    .btn-group .btn:last-child {
        margin-right: 0;
    }
    
    #enrollmentsTable tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Mobile Responsive Styles */
    @media (max-width: 768px) {
        #enrollmentsTable_wrapper .dataTables_length,
        #enrollmentsTable_wrapper .dataTables_filter {
            margin-bottom: 15px;
        }
        
        #enrollmentsTable_wrapper .dataTables_filter {
            text-align: left;
            margin-top: 10px;
        }
        
        #enrollmentsTable_wrapper .dataTables_filter input {
            width: 100%;
            margin-left: 0;
            margin-top: 10px;
        }
        
        #enrollmentsTable_wrapper .dataTables_length {
            margin-bottom: 10px;
        }
        
        #enrollmentsTable_wrapper .dataTables_info,
        #enrollmentsTable_wrapper .dataTables_paginate {
            margin-top: 15px;
            text-align: center !important;
        }
        
        #enrollmentsTable_wrapper .dataTables_paginate .pagination {
            justify-content: center;
        }
        
        /* Make table cells stack on mobile */
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.child,
        table.dataTable.dtr-inline.collapsed > tbody > tr > th.child,
        table.dataTable.dtr-inline.collapsed > tbody > tr > td.dataTables_empty {
            padding: 0.5rem;
        }
        
        /* Responsive table child row styling */
        .dtr-details {
            list-style: none;
            padding: 0;
        }
        
        .dtr-details li {
            padding: 0.5rem 0;
            border-bottom: 1px solid #eee;
        }
        
        .dtr-details li:last-child {
            border-bottom: none;
        }
        
        .dtr-title {
            font-weight: 600;
            color: #333;
            margin-right: 10px;
            min-width: 120px;
            display: inline-block;
        }
        
        .dtr-data {
            color: #666;
        }
    }
    
    /* Tablet Styles */
    @media (min-width: 769px) and (max-width: 1024px) {
        #enrollmentsTable_wrapper .dataTables_filter input {
            width: 200px;
        }
    }
    
    /* Responsive child row styles */
    table.dataTable.dtr-inline.collapsed > tbody > tr > td:first-child:before,
    table.dataTable.dtr-inline.collapsed > tbody > tr > th:first-child:before {
        background-color: #667eea;
        border: 2px solid white;
        box-shadow: 0 0 3px rgba(0, 0, 0, 0.2);
        top: 50%;
        transform: translateY(-50%);
    }
    
    table.dataTable.dtr-inline.collapsed > tbody > tr.parent > td:first-child:before,
    table.dataTable.dtr-inline.collapsed > tbody > tr.parent > th:first-child:before {
        background-color: #28a745;
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap4.min.js"></script>
<script>
    (function($) {
        'use strict';
        $(document).ready(function() {
            var sortColumn = @if(auth()->check() && auth()->user()->hasAnyRole(['admin', 'instructor'])) 5 @else 4 @endif;
            
            $('#enrollmentsTable').DataTable({
                responsive: {
                    details: {
                        type: 'column',
                        target: 'tr'
                    }
                },
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                order: [[sortColumn, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search enrollments...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ enrollments",
                    infoEmpty: "No enrollments available",
                    infoFiltered: "(filtered from _MAX_ total enrollments)",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    },
                    emptyTable: "No enrollments found"
                },
                columnDefs: [
                    {
                        targets: -1, // Last column (Actions)
                        orderable: false,
                        searchable: false,
                        responsivePriority: 1
                    },
                    {
                        targets: 'no-sort',
                        orderable: false
                    }
                ],
                autoWidth: false
            });
            
            // Style DataTables elements
            $('#enrollmentsTable').each(function() {
                var datatable = $(this);
                // SEARCH - Add the placeholder for Search and Turn this into in-line form control
                var search_input = datatable.closest('.dataTables_wrapper').find('div[id$=_filter] input');
                search_input.attr('placeholder', 'Search enrollments...');
                search_input.removeClass('form-control-sm');
                // LENGTH - Inline-Form control
                var length_sel = datatable.closest('.dataTables_wrapper').find('div[id$=_length] select');
                length_sel.removeClass('form-control-sm');
            });
        });
    })(jQuery);
</script>
@endpush
@endsection
