@extends('web.layouts.default')
@section('title', 'Thank You')
@section('content')

<style>
@media (max-width: 768px) {
    #toggleProductsButton {
        display: inline;
    }

    #productsContainer {
        display: none; /* Initially hidden on mobile */
    }

    .container {
        display: flex;
        flex-direction: column; /* Move shipping summary down */
    }
    .order-summary, .order-details {
        width: 100%;
    }
    .individual{
        display: none;
    }
    .content{
        flex-direction:column-reverse;
    }

}

@media (min-width: 769px) {
    #toggleProductsButton {
        display: none;
    }

    #productsContainer {
        display: block; /* Always show on large screens */
    }
}

</style>

<div class="container" style="max-width: 1000px; margin: auto; font-family: Arial, sans-serif; padding: 20px; color: #333;">
    <!-- Order Confirmation Header -->
    <div style="text-align: center; margin-bottom: 30px;">
        <h1 style="color: #577BBF;">Thank You, {{ $name }}!</h1>
        <p>Your order <strong style="color: #577BBF;">#{{ $order->id }}</strong> is confirmed.</p>
        <p>You’ll receive a confirmation email shortly.</p>
    </div>

    <!-- Main Section (Flex Layout) -->
    <div class="content" style="display: flex; gap: 20px; margin-bottom: 20px; flex-wrap: wrap;">
        <!-- Left Section: Order Summary -->
        <div style="flex: 1; border: 1px solid #ddd; border-radius: 8px; padding: 10px; background-color: #F9FAFD; min-width: 280px;">
            <h3 style="color: #577BBF;">Order Summary</h3>
            {{-- <p><strong>Total Amount:</strong> £{{ $order->total_ammount }}</p> --}}
            <h5 style="color: #577BBF;">Shipping Information</h5>
            <p><strong>Name:</strong> {{ $shippingDetails['firstName'] ?? 'N/A' }} {{ $shippingDetails['lastName'] ?? 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $shippingDetails['email'] ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $shippingDetails['phone'] ?? 'N/A' }}</p>
            <p><strong>Address:</strong> {{ $shippingDetails['address'] ?? 'N/A' }} {{ $shippingDetails['address2'] ?? '' }}</p>
            <p><strong>Town:</strong> {{ $shippingDetails['state'] ?? 'N/A' }}</p>
            <p><strong>City:</strong> {{ $shippingDetails['city'] ?? 'N/A' }}</p>
            <p><strong>Postal Code:</strong> {{ $shippingDetails['zip_code'] ?? 'N/A' }}</p>
            <p><strong>Shipping Method:</strong> {{ $shippingDetails['method'] ?? 'N/A' }}</p>
            <p><strong>Shipping Cost:</strong> £{{ $shippingDetails['cost'] ?? '0.00' }}</p>
        </div>

        <!-- Right Section: Order Details -->
        <div style="flex: 1; border: none; padding: 10px; background-color: #F9FAFD; min-width: 280px;">
            <div style="margin-top: 2px; border: 1px solid #ddd; border-radius: 8px; padding: 20px; background-color: #FFFFFF;">
                    <!-- Collapsible Button -->
                    <div class="button"><button 
                    id="toggleProductsButton" 
                    onclick="toggleProductsSection()" 
                    style="display: flex; justify-content: space-between; align-items: center; width: 100%; background-color: #1AA7C0; border-radius: 10px; padding: 5px; margin-bottom:5px;"
                >
                    <span style="color: #fff; font-size: 16px; padding:5px;">Products</span>
                    <span style="font-size: 16px; font-weight: bold; color: #fff; padding:5px;">£{{ $order->total_ammount ?? '0.00' }}</span>
                </button></div>
                <!-- Products Container -->
                <div id="productsContainer" style="flex: 1;">
                    {{-- <h3 style="margin-bottom: 20px; color: #1AA7C0;">Products in Your Order</h3> --}}
                    <div style="display: flex; flex-wrap: wrap; gap: 20px;">
                        @foreach ($orderDetails as $detail)
                        <!-- Product Card -->
                        <div style="flex: 1 1 calc(50% - 20px); display: flex; justify-content: space-between; align-items: center; padding: 15px; border: 1px solid #ddd; border-radius: 8px; background-color: #F9FAFD;">
                            <div style="display: flex; align-items: center; gap: 15px;">
                                <!-- Product Image -->
                                <img 
                                    src="/storage/{{ $detail['variant'] && isset($detail['variant']['image']) ? $detail['variant']['image'] : $detail['product']['main_image'] ?? 'default-image.jpg' }}" 
                                    alt="{{ $detail['variant'] ? $detail['variant']['title'] : $detail['product']['title'] }}" 
                                    style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px; border: 1px solid #ddd;" />
                                
                                <!-- Product Details -->
                                <div>
                                    <p style="margin: 0; font-size: 16px; font-weight: bold; color: #577BBF;">{{ $detail['product']['title'] ?? 'Product Title' }}</p>
                                    <p style="margin: 5px 0 0; font-size: 14px;">Quantity: x{{ $detail['product_qty'] ?? '0' }}</p>
                                    <p style="margin: 5px 0 0; font-size: 14px;">Price: £{{ $detail['variant'] && isset($detail['variant']['price']) ? $detail['variant']['price'] : $detail['product']['price'] }}</p>
                                    
                                    @if ($detail['variant'])
                                    <p style="margin: 5px 0 0; font-size: 14px;">Variant: {{ $detail['variant']['title'] ?? 'N/A' }} - {{ $detail['variant']['value'] ?? 'N/A' }}</p>
                                    @endif
                                </div>
                            </div>
                
                            <!-- Individual Product Total -->
                            <p class="individual" style="margin: 0; font-size: 16px; font-weight: bold; text-align: right; color: #1AA7C0;">
                                £{{ $detail['product_qty'] * ($detail['variant'] && isset($detail['variant']['price']) ? $detail['variant']['price'] : $detail['product']['price']) }}
                            </p>
                        </div>
                        @endforeach
                    </div>
                    <div class="totalamount" style="margin-top: 20px; border-top: 1px solid #ddd; padding-top: 15px; text-align: right;">
                        <p style="margin: 5px 0; font-size: 16px;"><strong>Shipping:</strong> £{{ $shippingDetails['cost'] ?? '0.00' }}</p>
                        <h3 style="margin: 10px 0; font-size: 18px; font-weight: bold; color: #577BBF;"><strong>Total:</strong> £{{ $order->total_ammount ?? '0.00' }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
     {{-- <!-- Order Totals -->
     <div style="margin-top: 20px; border-top: 1px solid #ddd; padding-top: 15px; text-align: right;">
        <p style="margin: 5px 0; font-size: 16px;"><strong>Shipping:</strong> £{{ $shippingDetails['cost'] ?? '0.00' }}</p>
        <h3 style="margin: 10px 0; font-size: 18px; font-weight: bold; color: #577BBF;"><strong>Total:</strong> £{{ $order->total_ammount ?? '0.00' }}</h3>
    </div> --}}

    <a href="/" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background-color: #1AA7C0; color: #fff; font-size: 14px; text-align:center; text-decoration: none; border-radius: 5px; font-weight: bold;">
        Continue Shopping
    </a>
</div>

@stop

@pushOnce('scripts')
<script>
    function toggleProductsSection() {
        const container = document.getElementById('productsContainer');
        const button = document.getElementById('toggleProductsButton');
        if (container.style.display === 'none') {
            container.style.display = 'block';
            // button.textContent = 'Hide Products in Your Order';
        } else {
            container.style.display = 'none';
            // button.textContent = 'Show Products in Your Order';
        }
    }
</script>
@endPushOnce
