@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Sale : {{$sale->invoice}}</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Sale</li>
                    <li class="breadcrumb-item active">Payment Schedule</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <section class="card p-3">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>S/N</th>
                            <th>Date</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $sl = 1;
                        @endphp
                        @if($payment_dates && $payment_amounts)
                            @foreach ($payment_dates as $index => $date)
                            <tr>
                                <td>{{ $sl++ }}</td>
                                <td>
                                    <?php
                                        $timestamp = strtotime($date);
                                        $e_date = date('d-m-Y', $timestamp);
                                    ?>
                                    {{$e_date}}
                                </td>
                                <td>{{ $payment_amounts[$index] }}</td>
                            </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
          </section>
    </div> <!-- end col -->
</div> <!-- end row -->
@endsection