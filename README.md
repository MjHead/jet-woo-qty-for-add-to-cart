# Jet WooCommerce Qty Input

Adds new shortcode [jet_woo_add_to_cart_with_qty]. This shortcode is similar to default WooCommerce Add to Cart shortcode, but renders quantity input before Add to Cart button.

**Note 1.** This shortcode don't add any additional CSS, so you'll need to add styles you need manually.

**Note 2.** At the moment works only with AJAX add to cart.

### Shortcode Attributes

- id - ID of added to cart product.
- sku - SKU of added to cart product. If set both, will be used ID.
- quantity - initial quantity

### Usage inside JetEngine Listing Grid

Use **Dynamic Field** widget and select **Product ID** as source (for WC Query, for Posts - Post ID):

![image](https://user-images.githubusercontent.com/4987981/173831732-6995763b-0e40-4308-a2e2-c26cd4f92264.png)

Enable **Customize field output** option and paste shortcode into **Field format**, use %s placeholder to set **Product ID** into ID attibute of the shortcode:

![image](https://user-images.githubusercontent.com/4987981/173832106-146e9a6e-ef15-4e74-b922-71bd458f78da.png)

Style result as you need:

![image](https://user-images.githubusercontent.com/4987981/173832408-dbbee1a9-1517-40c6-baa9-31861e8b1b79.png)

