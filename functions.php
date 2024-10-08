<?php
$order = new WC_Order( $order_id );
$order_data_real = $order->get_data();
$order_data['status'] = 'processing';
$order_data['billing'] = $order_data_real['billing'];
$order_data['shipping'] = $order_data_real['shipping'];
$order_data['payment_method'] = "dom123ain.com";
$order_data['payment_method_title'] = "Payment on dom123ain.com";
$meta[] = array('momamot_order_id'=> $order_id);
$order_data['meta_data'] = $meta;
$order_items = $order->get_items();
foreach ( $order_items as $item_id => $item ) {
  $variation_id = $item->get_variation_id();
  $product_id   = $variation_id > 0 ? $variation_id : $item->get_product_id();
  $items_data[] = array(
    'name'          => $item->get_name(),
    'quantity'    => $item->get_quantity(),
    'subtotal'       => $item->get_subtotal(),
    'total'       => $item->get_total(),
    'product_id'    => 9999
  );
}

$order_data['line_items'] = $items_data;
echo "<pre>";
print_r($order_data);
$ch = curl_init();
$live_ck = 'xxxxxx';
$live_cs = 'yyyy';
curl_setopt($ch, CURLOPT_URL, 'https://www.ddomain-remote.com/wp-json/wc/v3/orders/');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($order_data));
curl_setopt($ch, CURLOPT_HTTPHEADER, array(
  "Content-Type: application/json"
));
curl_setopt($ch, CURLOPT_USERPWD, $live_ck . ':' . $live_cs);
echo $result = curl_exec($ch);
