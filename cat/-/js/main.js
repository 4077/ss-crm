// head {
var __nodeId__ = "ss_crm_cat__main";
var __nodeNs__ = "ss_crm_cat";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.bind();
            w.bindEvents();
        },

        bindEvents: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            /*w.e('minicart/update_quantity', function (data) {
                var $product = $(".product[item_key='" + data.itemKey + "']", $w);

                if ($product.length) {
                    var $indicator = $product.find(".in_cart_count");

                    $indicator.html(data.quantity);

                    if (data.quantity > 0) {
                        $indicator.show();
                    } else {
                        $indicator.hide();
                    }
                }
            });*/

            /*for (var i in o.itemsKeys) {
                (function () {
                    var itemKey = o.itemsKeys[i];

                    w.e('minicart/update_quantity/' + itemKey, function (data) {
                        var $indicator = $(".product[item_key='" + itemKey + "']", $w).find(".in_cart_count");

                        $indicator.html(data.quantity);

                        if (data.quantity > 0) {
                            $indicator.show();
                        } else {
                            $indicator.hide();
                        }
                    });
                })();
            }*/
        },

        loading: false,

        appendProducts: function (data) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.loading = false;

            $(".products", $w).append(data.productsViews);

            w.bindProducts(o.offset);

            o.offset += data.count;
        },

        pageAppendProducts: function (data) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.loading = false;


        },

        bind: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var $port = $w.closest(".port");

            $port.rebind("scroll." + __nodeId__, function () {
                if (!w.loading) {
                    var scrollHeight = $port.get(0).scrollHeight;
                    var scrollTop = $port.scrollTop();
                    var portHeight = $port.height();

                    if (scrollHeight - scrollTop - portHeight < o.minTailHeight) {
                        w.loading = true;

                        w.r('loadProducts', {
                            products_data: o.productsData,
                            offset:        o.offset
                        });
                    }
                }
            });

            $(".cat, .page", $w).click(function () {
                var xpack = $(this).attr("xpack");

                w.r('openCat', {
                    cat: xpack
                });
            });

            w.bindProducts();
        },

        bindProducts: function (offset) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var $products;

            if (offset) {
                $products = $(".product[offset='" + offset + "']", $w);
            } else {
                $products = $(".product", $w);
            }

            $products.click(function (e) {
                var xpack = $(this).attr("xpack");

                $(".product", $w).removeClass("selected");

                $(this).addClass("selected");

                if (!o.guestMode) {
                    w.r('openProduct', {
                        product: xpack
                    });
                }

                e.stopPropagation();
            });

            $(".add_to_cart_button", $products).click(function (e) {
                var xpack = $(this).closest(".product").attr("xpack");

                w.r('addToCart', {
                    product: xpack
                });

                e.stopPropagation();
            });
        }
    });
})(__nodeNs__, __nodeId__);
