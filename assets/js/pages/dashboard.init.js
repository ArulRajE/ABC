! function(e) {
    "use strict";
    var a = function() {
        this.$realData = []
    };
    a.prototype.createBarChart = function(e, a, r, t, o, i) {
        Morris.Bar({
            element: e,
            data: a,
            xkey: r,
            ykeys: t,
            labels: o,
            hideHover: "auto",
            resize: !0,
            gridLineColor: "rgba(108, 120, 151, 0.1)",
            barSizeRatio: .2,
            barColors: i
        })
    }, a.prototype.createLineChart = function(e, a, r, t, o, i, n, l, s) {
        Morris.Line({
            element: e,
            data: a,
            xkey: r,
            ykeys: t,
            labels: o,
            fillOpacity: i,
            pointFillColors: n,
            pointStrokeColors: l,
            behaveLikeLine: !0,
            gridLineColor: "rgba(108, 120, 151, 0.1)",
            hideHover: "auto",
            resize: !0,
            pointSize: 0,
            lineColors: s
        })
    }, a.prototype.createDonutChart = function(e, a, r) {
        Morris.Donut({
            element: e,
            data: a,
            resize: !0,
            colors: r,
            backgroundColor: "#fff"
        })
    }, a.prototype.init = function() {
        // this.createBarChart("morris-bar-example", [{
        //     y: "2011",
        //     a: 35
        // },{
        //     y: "2021",
        //     a: 36
        // }], "y", ["a"], ["States"], ["#fe6271"]);

        // this.createBarChart("morris-bar-example-dt", [{
        //     y: "2011",
        //     a: 640
        // },{
        //     y: "2021",
        //     a: 734
        // }], "y", ["a"], ["Districts"], ["#fe6271"]);

        //  this.createBarChart("morris-bar-example-sd", [{
        //     y: "2011",
        //     a: 5988
        // },{
        //     y: "2021",
        //     a: 6723
        // }], "y", ["a"], ["Sub Districts"], ["#fe6271"]);

        //  this.createBarChart("morris-bar-example-vt", [{
        //     y: "2011",
        //     a: 644824
        // },{
        //     y: "2021",
        //     a: 639078
        // }], "y", ["a"], ["Villages"], ["#fe6271"]);

        //  this.createBarChart("morris-bar-example-tw", [{
        //     y: "2011",
        //     a: 4041
        // },{
        //     y: "2021",
        //     a: 9930
        // }], "y", ["a"], ["Towns"], ["#fe6271"]);

        //  this.createBarChart("morris-bar-example-wd", [{
        //     y: "2011",
        //     a: 1234
        // },{
        //     y: "2021",
        //     a: 1234
        // }], "y", ["a"], ["Wards"], ["#fe6271"]);

        // this.createLineChart("morris-line-example", [{
        //     y: "2008",
        //     a: 50,
        //     b: 0
        // }, {
        //     y: "2009",
        //     a: 75,
        //     b: 50
        // }, {
        //     y: "2010",
        //     a: 30,
        //     b: 80
        // }, {
        //     y: "2011",
        //     a: 50,
        //     b: 50
        // }, {
        //     y: "2012",
        //     a: 75,
        //     b: 10
        // }, {
        //     y: "2013",
        //     a: 50,
        //     b: 40
        // }, {
        //     y: "2014",
        //     a: 75,
        //     b: 50
        // }, {
        //     y: "2015",
        //     a: 100,
        //     b: 70
        // }], "y", ["a", "b"], ["Series A", "Series B"], ["0.9"], ["#ffffff"], ["#999999"], ["#ddd", "#fe8995"]);
        // this.createDonutChart("morris-donut-example", [{
        //     label: "Download Sales",
        //     value: 12
        // }, {
        //     label: "In-Store Sales",
        //     value: 30
        // }, {
        //     label: "Mail-Order Sales",
        //     value: 20
        // }], ["#fe8995", "#fe6271", "#ddd"])
    }, e.Dashboard = new a, e.Dashboard.Constructor = a
}(window.jQuery),
function(e) {
    "use strict";
    window.jQuery.Dashboard.init()
}();