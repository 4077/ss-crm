// head {
var __nodeId__ = "ss_crm_ui__main";
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

        elements: {
            $portA:       null,
            $portB:       null,
            $portC:       null,
            $dockLeft:    null,
            $dockCenter:  null,
            $dockRight:   null,
            $layerCenter: null,
            $layerFs:     null
        },

        bind: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var $window = $(window);

            w.elements.$portA = $("[port='A']", $w);
            w.elements.$portB = $("[port='B']", $w);
            w.elements.$portC = $("[port='C']", $w);
            w.elements.$dockLeft = $("[dock='left']", $w);
            w.elements.$dockCenter = $("[dock='center']", $w);
            w.elements.$dockRight = $("[dock='right']", $w);
            w.elements.$layerCenter = $("[layer='center']", $w);
            w.elements.$layerFs = $("[layer='fs']", $w);

            $window.resize(function () {
                w.renderLayout();
            });

            var dockScrollTimeout;

            $(".port", $w).rebind("scroll." + __nodeId__, function () {
                var $dock = $(this);

                clearTimeout(dockScrollTimeout);

                dockScrollTimeout = setTimeout(function () {
                    var port = $dock.attr("port");

                    w.r('updateScroll', {
                        port:        port,
                        scroll_left: $dock.scrollLeft(),
                        scroll_top:  $dock.scrollTop()
                    });
                }, 400);
            });

            w.render();
        },

        render: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $.each(o.ports, function (port, data) {
                $(".port[port='" + port + "']", $w).scrollTop(data.scroll_top).scrollLeft(data.scroll_left);
            });

            w.renderLayout();
        },

        portsDocks: {
            B: 'left',
            C: 'right'
        },

        renderLayout: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var ww = $(window).width();

            if (ww < 1050) {
                w.elements.$portC.appendTo(w.elements.$layerCenter);

                w.portsDocks.C = 'layer';
            } else {
                w.elements.$portC.appendTo(w.elements.$dockLeft);

                w.portsDocks.C = 'left';

                w.elements.$layerCenter.hide();
            }

            if (ww < 700) {
                w.elements.$portB.appendTo(w.elements.$layerCenter);

                w.portsDocks.B = 'layer';
            } else {
                w.elements.$portB.appendTo(w.elements.$dockRight);

                w.portsDocks.B = 'right';
            }
        },

        showPort: function (port) {
            var w = this;

            if (w.portsDocks[port] === 'layer') {
                $(".port", w.elements.$layerCenter).hide();
                $(".port[port='" + port + "']", w.elements.$layerCenter).show();

                w.elements.$layerCenter.show();

                w.w('mainBar').showCloseButton(function () {
                    w.elements.$layerCenter.hide();
                });
            }
        }

        // portB
    });
})(__nodeNs__, __nodeId__);
