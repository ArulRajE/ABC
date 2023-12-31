$(document).ready(function() {
    $("#datatable").DataTable();
    var a = $("#datatable-buttons").DataTable({
        lengthChange: !1,
        buttons: ["copy", "csv", "excel", "pdf", "print"],
        buttons: [{
            extend: "copy",
            className: "btn-sm"
        }, {
            extend: "csv",
            className: "btn-sm"
        }, {
            extend: "excel",
            className: "btn-sm"
        }, {
            extend: "pdf",
            className: "btn-sm"
        }, {
            extend: "print",
            className: "btn-sm"
        }]
    });
    $("#fixed-header-datatable").DataTable({
        fixedHeader: !0
    }), $("#keytable-datatable").DataTable({
        keys: !0
    }), $("#responsive-datatable").DataTable(), $("#scroller-datatable").DataTable({
        ajax: "../assets/data/scroller-demo.json",
        deferRender: !0,
        scrollY: 380,
        scrollCollapse: !0,
        scroller: !0
    }), a.buttons().container().appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)")
});