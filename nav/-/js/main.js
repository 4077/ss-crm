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

            var $catNodes = $(".cat_node", $w);

            $catNodes.rebind("click", function () {
                w.r('selectCat', {
                    cat_id: $(this).attr("instance")
                });
            });
        },

        setSelection: function (nodeId) {
            var w = this;
            var o = w.options;
            var $w = w.element;

            $(".node.selected", $w).removeClass("selected");
            $(".nodes[node_id='" + nodeId + "'] > .node").addClass("selected");
        }
    });
})(__nodeNs__, __nodeId__);
