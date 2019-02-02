// head {
var __nodeId__ = "ss_crm_blocks__header";
var __nodeNs__ = "ss_crm_blocks";
// }

(function (__nodeNs__, __nodeId__) {
    $.widget(__nodeNs__ + "." + __nodeId__, $.ewma.node, {
        options: {},

        __create: function () {
            var w = this;
            var o = w.options;
            var $w = w.element;

            var $search = $(".search input", $w);
            var $hint = $(".search .hint", $w);

            if ($(window).width() > 960) {
                $search.focus();
            }

            $search.on("keyup", function (e) {
                $hint.hide();

                if (e.which === 13) {
                    var searchQuery = $search.val();

                    if (searchQuery.length === 0) {
                        window.location.href = '/';
                    } else {
                        if (searchQuery.length >= 3) {
                            window.history.replaceState(null, null, '/поиск/' + searchQuery + '/');

                            request(o.paths.updateSearchQuery, {
                                value: searchQuery
                            });
                        } else {
                            $hint.show();
                        }
                    }
                }
            });
        }
    });
})(__nodeNs__, __nodeId__);
