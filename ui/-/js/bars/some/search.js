// head {
var __nodeId__ = "ss_crm_ui__bars_some_search";
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

            var $search = $("input", $w);
            var $hint = $(".hint", $w);
            var $submitButton = $(".submit_button", $w);

            if ($(window).width() > 960) {
                // $search.focus();
            }

            $search.on("keyup", function (e) {
                $hint.hide();

                var searchQuery = $search.val();

                if (e.which === 13) {
                    if (searchQuery.length === 0) {
                        window.location.href = '/';
                    } else {
                        if (searchQuery.length >= 3) {
                            window.history.replaceState(null, null, '/search/' + searchQuery + '/');

                            w.r('updateSearchQuery', {
                                value: searchQuery
                            });
                        } else {
                            $hint.show();
                        }
                    }
                }

                if (searchQuery.length >= 3) {
                    $submitButton.fadeIn();
                } else {
                    $submitButton.fadeOut();
                }
            });

            $submitButton.click(function () {
                var searchQuery = $search.val();

                if (searchQuery.length >= 3) {
                    w.r('updateSearchQuery', {
                        value: searchQuery
                    });
                }
            });
        }
    });
})(__nodeNs__, __nodeId__);
