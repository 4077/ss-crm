// head {
var __nodeId__ = "ss_crm_product__quantifyKnob";
var __nodeNs__ = "ss_crm_product";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var $magnitudeSelectorButton = $("> .magnitude", $w);
            var $magnitudeSelector = $(".magnitude_selector", $w);

            $magnitudeSelectorButton.click(function () {
                $magnitudeSelector.show();
            });

            var $input = $("input", $w);

            var $decButton = $(".dec.button", $w);
            var $incButton = $(".inc.button", $w);

            $decButton.click(function () {
                delta(1);
            });

            $incButton.click(function () {
                delta(-1);
            });

            function delta(delta) {
                var value = parseInt($input.val());

                value += delta;

                $input.val(value).trigger("change");
            }
        }
    });
})(__nodeNs__, __nodeId__);
