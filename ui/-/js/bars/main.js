// head {
var __nodeId__ = "ss_crm_ui__bars_main";
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

        bind: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var $navButton = $(".nav.button", $w);
            var $notificationsButton = $(".notifications.button", $w);
            var $backButton = $(".back.button", $w);
            var $closeButton = $(".close.button", $w);
            var $mainButton = $(".main.button", $w);
            var $moreButton = $(".more.button", $w);

            //

            /*var togglePortC = function (view) {
                var $leftDock = $(w.w('someBar').element);

                var visible = $leftDock.is(":visible");

                if (visible) {
                    if (some !== o.selectedView) {
                        w.r('selectSome', {
                            some: some
                        });

                        o.selectedSome = some;
                    } else {
                        $leftDock.hide();

                        w.r('setSomeBarVisibility', {
                            visible: false
                        });
                    }
                } else {
                    w.r('selectSome', {
                        some: some
                    });

                    o.selectedSome = some;

                    $leftDock.show();
                }
            };*/

            $navButton.rebind("click", function () {
                w.w('main').elements.$portC.toggle();
                w.w('main').showPort('C');
            });

            /*$notificationsButton.rebind("click", function () {
                w.r('setLeftDockContent', {
                    type: 'notifications'
                });
            });*/

            $backButton.rebind("click", function () {
                w.r('back');
            });

            p($closeButton);

            $closeButton.rebind("click", function () {
                w.r('close');
            });

            //
            //
            //

            // some_buttons_gc

            var $moreButtons = $(".more_buttons", $mainButton);

            $(".ordering.more_button", $w).rebind("click", function () {
                w.w('moreBar').r('toggleOrdering');
            });

            $(".tree.more_button", $w).rebind("click", function () {
                w.w('moreBar').toggleSome('tree');
            });

            $(".filter.more_button", $w).rebind("click", function () {
                w.w('moreBar').toggleSome('filter');
            });

            $(".search.more_button", $w).rebind("click", function () {
                w.w('moreBar').toggleSome('search');
            });

            $(".qrcode.more_button", $w).rebind("click", function () {
                w.w('moreBar').r('qrScan');
            });

            var moreButtonsWidth = $moreButtons.width();

            $(".more_buttons", $mainButton).draggable({
                axis:     'x',
                distance: 10,
                drag:     function (e, ui) {
                    var left = ui.position.left;

                    ui.position.left = constrains(left, -moreButtonsWidth + 60, 0);
                },
                stop:     function (e, ui) {
                    var left = ui.position.left;
                    var setLeft = Math.round(left / 60) * 60;

                    $moreButtons.animate({left: setLeft}, 200);

                    w.r('setMainButton', {
                        left: setLeft
                    });
                }
            });

            //
            //
            //

            $moreButton.rebind("click", function () {
                w.w('moreBar').toggle();
            });
        },

        changeMainButton: function (some) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var n = o.moreButtons.indexOf(some);

            $(".more_buttons", $(".main.button", $w)).animate({left: n * -60}, 200);
        },

        showCloseButton: function (handler) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var $backButton = $(".back.button", $w);
            var $closeButton = $(".close.button", $w);

            $backButton.addClass("hidden");
            $closeButton.removeClass("hidden");

            $closeButton.rebind("click", function () {
                handler();

                $backButton.removeClass("hidden");
                $closeButton.addClass("hidden");
            });
        }
    });
})(__nodeNs__, __nodeId__);
