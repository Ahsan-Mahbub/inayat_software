@extends('backend.layouts.app')
@section('content')
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Client Message</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="/">Dashboard</a></li>
                    <li class="breadcrumb-item">Client</li>
                    <li class="breadcrumb-item active">Send Message</li>
                </ol>
            </div>
        </div>
    </div>
</div><div class="row justify-content-center">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <form class="needs-validation" novalidate="" action="{{route('customer.message.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label>Select Customer *</label>
                            <div class="text-right">
                                <button type="button" class="btn btn-primary mb-3" id="selectAllButton">Select All</button>
                            </div>
                            <div class="d-flex flex-wrap">
                                @foreach($customers as $customer)
                                <div class="form-check mt-3 mr-3">
                                    <input class="form-check-input customer-checkbox" type="checkbox" name="customer_phone[]"
                                        value="{{$customer->phone}}" id="customer_name{{$customer->id}}">
                                    <label class="form-check-label" for="customer_name{{$customer->id}}">
                                        {{$customer->customer_name}}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="d-block">Message *</label>
                            <textarea rows="3" class="form-control" name="message" required placeholder="Write a Message"></textarea>
                        </div>
                    </div>
                    <div class="text-center">
                        <button class="btn btn-primary" type="submit">Send Message</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script>
    document.getElementById('selectAllButton').addEventListener('click', function () {
        var checkboxes = document.querySelectorAll('.customer-checkbox');
        var allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
        
        checkboxes.forEach(function (checkbox) {
            checkbox.checked = !allChecked;
        });
        this.textContent = allChecked ? 'Select All' : 'Deselect All';
    });
</script>
@endsection