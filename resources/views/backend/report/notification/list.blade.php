@extends('backend.layouts.app')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0 font-size-18">Notification</h4>
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                        <li class="breadcrumb-item">Notification</li>
                        <li class="breadcrumb-item active">List</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered nowrap"
                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                                <tr>
                                    <th>S/N</th>
                                    <th>Payment Collection Details</th>
                                </tr>
                            </thead>


                            <tbody>
                                @php
                                    $sl = 1;
                                @endphp
                                @foreach ($notifications as $notification)
                                    <tr>
                                        <td>{{ $sl++ }}</td>
                                        <td>
                                            <a href="{{route('customer.transaction', $notification->customer->id)}}" class="text-reset notification-item">
                                                <div class="media">
                                                    <div class="avatar-xs mr-3">
                                                        <span class="avatar-title bg-primary rounded-circle font-size-16">
                                                            <img src="/{{$notification->customer->image ? $notification->customer->image : 'demo.svg'}}" height="45">
                                                        </span>
                                                    </div>
                                                    <div class="media-body">
                                                        <h6 class="mt-0 mb-1">Collection Money</h6>
                                                        <div class="font-size-12 text-muted">
                                                            <p class="mb-1">There is a day to collect the due amount from "{{$notification->customer->customer_name}}". Invoice number is {{$notification->sale->invoice}}. The amount is {{$notification->amount}} tk.</p>
                                                            <p class="mb-0"><i class="mdi mdi-clock-outline"></i>
                                                                <?php
                                                                    $timestamp = strtotime($notification->date);
                                                                    $notification_date = date('d-m-Y', $timestamp);
                                                                ?>
                                                                {{$notification_date}} 
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div> <!-- end col -->
    </div> <!-- end row -->
@endsection
