@extends('emails.customer.layout')

@section('content')
    <h1>Invoice from {{ $organization->name ?? $organization->org_code }}</h1>

    <p>Hi {{ $invoice->billing_name }},</p>

    <p>
        Please find your invoice attached to this email.
    </p>

    <div class="amount-box">
        <div class="label">Amount Due</div>
        <div class="amount">R {{ number_format((float) $invoice->amount_due, 2) }}</div>
        <div class="due">Due {{ \Carbon\Carbon::parse($invoice->due_date)->format('d M Y') }}</div>
    </div>

    <p>Invoice number: <strong>{{ $invoice->invoice_number }}</strong></p>

    @if($invoice->notes)
        <p>{{ $invoice->notes }}</p>
    @endif

    <p>If you have any questions, please reply to this email.</p>
@endsection