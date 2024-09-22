<!-- All JS Plugins -->
<script src="<?php echo e(asset('js/plugins.js')); ?>"></script>
<!-- Main JS -->
<script src="<?php echo e(asset('js/main.js')); ?>"></script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function addToCart(id) {
        var quantity = $('.cart-plus-minus-box').val();
        var variantId = $('#variant_id').val();
        $.ajax({
            url: '<?php echo e(route("web.cart.add")); ?>',
            type: 'post',
            data: {
                id: id,
                variantId: variantId,
                quantity: quantity,
            },
            dataType: 'json',
            success: function(response) {
                if (response.status == true) {
                    $('#add_to_cart_modal').modal('show');
                    // window.loation.href = "<?php echo e(route('web.view.cart')); ?>";
                    $('.mini-cart-icon sup').text(response.count); 
                    $('.mini-cart-subtotal').text(response.subtotal); 
                    updateMiniCart(response.cartItems);
                } else {
                    alert(response.message);
                }
            }
        });
    }

    function deleteItem(rowId, isMini){
        if(confirm("Are you sure you want to delete?")){
            $.ajax({
                url: '<?php echo e(route("web.cart.delete")); ?>',
                type: 'post',
                data: {rowId:rowId, isMini:isMini},
                dataType: 'json',
                success: function(response){
                    if(response.status == true){
                        if(isMini){
                            location.reload();
                        }
                        else{
                            window.location.href = "<?php echo e(route('web.view.cart')); ?>";
                        }
                    }
                }
            });
        }
    }

    function updateMiniCart(cartItems) {
        var miniCartProductArea = $('.mini-cart-product-area');
        miniCartProductArea.empty();
        var image_src = "<?php echo e(asset('storage/')); ?>";
        $.each(cartItems, function(rowId, item) {
            var miniCartItem = $('<div class="mini-cart-item clearfix">' +
                                    '<div class="mini-cart-img">' +
                                        '<a href="#"><img src="' + image_src + '/' + item.options.productImage + '" alt="Image"></a>' +
                                        '<span class="mini-cart-item-delete"><a href="javascript:void(0)" onclick="deleteItem(\''+rowId+'\',1)"><i class="icon-cancel"></i></span>' +
                                    '</div>' +
                                    '<div class="mini-cart-info">' +
                                        '<h6><a href="#">' + item.name + '</a></h6>' +
                                        '<span class="mini-cart-quantity">' + item.qty + ' x ' + item.price + '</span>' +
                                    '</div>' +
                                '</div>');
            miniCartProductArea.append(miniCartItem);
        });
    }
</script><?php /**PATH C:\laragon\www\OP-Phill\resources\views/web/includes/script.blade.php ENDPATH**/ ?>