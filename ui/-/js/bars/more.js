// head {
var __nodeId__ = "ss_crm_ui__bars_more";
var __nodeNs__ = "ss_crm_ui";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.bind();
        },

        // some_buttons_gc

        bind: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $(".ordering.button", $w).rebind("click", function () {
                w.w('mainBar').changeMainButton("ordering");
                w.r('toggleOrdering');
            });

            $(".tree.button", $w).rebind("click", function () {
                w.toggleSome('tree');
            });

            $(".filter.button", $w).rebind("click", function () {
                w.toggleSome('filter');
            });

            $(".search.button", $w).rebind("click", function () {
                w.toggleSome('search');
            });

            $(".qrcode.button", $w).rebind("click", function () {
                w.w('mainBar').changeMainButton("qrcode");
                w.r('qrScan');
            });
        },

        toggleSome: function (some) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            w.w('mainBar').changeMainButton(some);

            var $someBar = $(w.w('someBar').element);

            var visible = $someBar.is(":visible");

            if (visible) {
                if (some !== o.selectedSome) {
                    w.r('selectSome', {
                        some: some
                    });

                    o.selectedSome = some;
                } else {
                    $someBar.hide();

                    w.r('setSomeBarVisibility', {
                        visible: false
                    });
                }
            } else {
                w.r('selectSome', {
                    some: some
                }, false, function (response) {
                    ewma.processResponse(response);

                    $someBar.show();
                });

                o.selectedSome = some;
            }
        },

        toggle: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $w.toggle();

            w.r('setVisibility', {
                visible: $w.is(':visible')
            });
        }
    });
})(__nodeNs__, __nodeId__);
