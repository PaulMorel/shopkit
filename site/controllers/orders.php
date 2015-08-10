<?php

return function($site, $pages, $page) {
    // Only logged-in users can see this page
    $user = $site->user();

    $action = get('action');

    // Mark order as shipped
    if ($action === 'mark_shipped') {
        try {
            page('shop/orders/' . get('update_id'))->update(array(
                'status' => 'Shipped'
            ));
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }
    // Mark order as pending
    if ($action === 'mark_pending') {
        try {
            page('shop/orders/' . get('update_id'))->update(array(
                'status' => 'Pending'
            ));
        } catch(Exception $e) {
            echo $e->getMessage();
        }
    }

    if ($user and $user->hasPanelAccess()) {
        // If admin, show all orders
        $orders = $page->children()->sortBy('txn_date','desc');
    } else if ($user) {
        // If logged in, show this user's orders
        $orders = $page->children()->sortBy('txn_date','desc')->filterBy('payer_email',$user->email());
    } else if (get('txn_id') != '') {
        // If transaction ID passed from PayPal, show just that one order
        $orders = $page->children()->sortBy('txn_date','desc')->filterBy('txn_id',get('txn_id'));
    } else {
        // If not logged in, don't show orders
        $orders = false;
    }

<<<<<<< HEAD
    return [
        'user' => $site->user(),
        'cart' => Cart::getCart(),
        'orders' => $orders
    ];
=======
    return ['orders' => $orders];
>>>>>>> b0f4e76db9be7d91388bb224ff5e33af303e179f
};