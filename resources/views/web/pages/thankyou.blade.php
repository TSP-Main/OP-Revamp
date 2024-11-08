<!doctype html>
<html class="no-js" lang="eng">

<head>
    <!-- Include any necessary head elements here -->
    <title>Thank You | Online Pharmacy 4U</title>
    <!-- Include other necessary CSS/JS here -->
</head>

<body>
    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-N89QLBLT"
        height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- Body content -->
    <div class="d-none fifththanks">
        <div class="content">
            <div class="wrapper-1">
                <div class="wrapper-2">
                    <h1 class="text-thank">Thank you!</h1>
                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Magnam earum molestiae natus architecto! Nam, eaque.</p>
                    <button class="go-home">Go home</button>
                </div>
                <div class="footer-like">
                    <p>Email not received? <a href="#">Click here to send again</a></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Include scripts -->
    @include('web.includes.script')

    <!-- Push transaction data to dataLayer -->
    <script>
        window.dataLayer = window.dataLayer || [];
        window.dataLayer.push({
            'ecommerce': {
                'purchase': {
                    'actionField': {
                        'id': '{{ $transactionId }}', // This is the transaction ID from the controller
                        'revenue': '{{ $transactionTotal }}', // This is the total transaction value
                        'currency': '{{ $currency }}' // The currency of the transaction
                    }
                }
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
