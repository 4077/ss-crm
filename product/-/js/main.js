// head {
var __nodeId__ = "ss_crm_product__main";
var __nodeNs__ = "ss_crm_product";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            /*w.e('minicart/update_quantity', function (data) {
                if (o.itemKey === data.itemKey) {
                    var $indicator = $(".in_cart_count", $w);

                    $indicator.html(data.quantity);

                    if (data.quantity > 0) {
                        $indicator.show();
                    } else {
                        $indicator.hide();
                    }
                }
            });*/
        }
    });
})(__nodeNs__, __nodeId__);
