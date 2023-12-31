! function(i) {
    "use strict";
    var t = function() {};
    t.prototype.initSwitchery = function() {
        i('[data-plugin="switchery"]').each(function(t, e) {
            new Switchery(i(this)[0], i(this).data())
        })
    }, t.prototype.initMultiSelect = function() {
        i('[data-plugin="multiselect"]').multiSelect(i(this).data()), i("#my_multi_select3,#my_multi_select4,#my_multi_select5,#my_multi_select6").multiSelect({
            selectableHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader: "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function(t) {
                var e = this,
                    n = e.$selectableUl.prev(),
                    a = e.$selectionUl.prev(),
                    i = "#" + e.$container.attr("id") + " .ms-elem-selectable:not(.ms-selected)",
                    s = "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
                e.qs1 = n.quicksearch(i).on("keydown", function(t) {
                    if (40 === t.which) return e.$selectableUl.focus(), !1
                }), e.qs2 = a.quicksearch(s).on("keydown", function(t) {
                    if (40 == t.which) return e.$selectionUl.focus(), !1
                })
            },
            afterSelect: function() {
                this.qs1.cache(), this.qs2.cache()
            },
            afterDeselect: function() {
                this.qs1.cache(), this.qs2.cache()
            }
        })
    }, t.prototype.initSelect2 = function() {
        i('[data-toggle="select2"]').select2(), i(".select2-limiting").select2({
            maximumSelectionLength: 2
        })
    }, t.prototype.initInputmask = function() {
        i('[data-toggle="input-mask"]').each(function(t, e) {
            var n = i(e).data("maskFormat"),
                a = i(e).data("reverse");
            null != a ? i(e).mask(n, {
                reverse: a
            }) : i(e).mask(n)
        })
    }, t.prototype.initTouchspin = function() {
        var a = {};
        i('[data-toggle="touchspin"]').each(function(t, e) {
            var n = i.extend({}, a, i(e).data());
            i(e).TouchSpin(n)
        }), i("input[name='demo3_21']").TouchSpin({
            initval: 40,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        }), i("input[name='demo3_22']").TouchSpin({
            initval: 40,
            buttondown_class: "btn btn-primary",
            buttonup_class: "btn btn-primary"
        })
    }, t.prototype.initTimepicker = function() {
        i("#timepicker").timepicker({
            defaultTIme: !1,
            icons: {
                up: "mdi mdi-chevron-up",
                down: "mdi mdi-chevron-down"
            }
        }), i("#timepicker2").timepicker({
            showMeridian: !1,
            icons: {
                up: "mdi mdi-chevron-up",
                down: "mdi mdi-chevron-down"
            }
        }), i("#timepicker3").timepicker({
            minuteStep: 15,
            icons: {
                up: "mdi mdi-chevron-up",
                down: "mdi mdi-chevron-down"
            }
        })
    }, t.prototype.initColorpicker = function() {
        i("#default-colorpicker").colorpicker({
            format: "hex"
        }), i("#rgba-colorpicker").colorpicker(), i("#component-colorpicker").colorpicker({
            format: null
        })
    }, t.prototype.initDaterangepicker = function() {
        i(".input-daterange-datepicker").daterangepicker({
            buttonClasses: ["btn", "btn-sm"],
            applyClass: "btn-success",
            cancelClass: "btn-secondary"
        }), i(".input-daterange-timepicker").daterangepicker({
            timePicker: !0,
            timePickerIncrement: 30,
            locale: {
                format: "MM/DD/YYYY h:mm A"
            },
            buttonClasses: ["btn", "btn-sm"],
            applyClass: "btn-success",
            cancelClass: "btn-secondary"
        }), i(".input-limit-datepicker").daterangepicker({
            format: "MM/DD/YYYY",
            minDate: "06/01/2019",
            maxDate: "06/30/2019",
            buttonClasses: ["btn", "btn-sm"],
            applyClass: "btn-success",
            cancelClass: "btn-secondary",
            dateLimit: {
                days: 6
            }
        }), i("#reportrange span").html(moment().subtract(29, "days").format("MMMM D, YYYY") + " - " + moment().format("MMMM D, YYYY")), i("#reportrange").daterangepicker({
            format: "MM/DD/YYYY",
            startDate: moment().subtract(29, "days"),
            endDate: moment(),
            minDate: "01/01/2012",
            maxDate: "12/31/2015",
            dateLimit: {
                days: 60
            },
            showDropdowns: !0,
            showWeekNumbers: !0,
            timePicker: !1,
            timePickerIncrement: 1,
            timePicker12Hour: !0,
            ranges: {
                Today: [moment(), moment()],
                Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                "Last 7 Days": [moment().subtract(6, "days"), moment()],
                "Last 30 Days": [moment().subtract(29, "days"), moment()],
                "This Month": [moment().startOf("month"), moment().endOf("month")],
                "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")]
            },
            opens: "left",
            drops: "down",
            buttonClasses: ["btn", "btn-sm"],
            applyClass: "btn-success",
            cancelClass: "btn-secondary",
            separator: " to ",
            locale: {
                applyLabel: "Submit",
                cancelLabel: "Cancel",
                fromLabel: "From",
                toLabel: "To",
                customRangeLabel: "Custom",
                daysOfWeek: ["Su", "Mo", "Tu", "We", "Th", "Fr", "Sa"],
                monthNames: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                firstDay: 1
            }
        }, function(t, e, n) {
            console.log(t.toISOString(), e.toISOString(), n), i("#reportrange span").html(t.format("MMMM D, YYYY") + " - " + e.format("MMMM D, YYYY"))
        })
    }, t.prototype.initMaxLength = function() {
        i("input#defaultconfig").maxlength({
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        }), i("input#thresholdconfig").maxlength({
            threshold: 20,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        }), i("input#alloptions").maxlength({
            alwaysShow: !0,
            separator: " out of ",
            preText: "You typed ",
            postText: " chars available.",
            validate: !0,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        }), i("textarea#textarea").maxlength({
            alwaysShow: !0,
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        }), i("input#placement").maxlength({
            alwaysShow: !0,
            placement: "top-left",
            warningClass: "badge badge-success",
            limitReachedClass: "badge badge-danger"
        })
    }, t.prototype.init = function() {
        this.initSwitchery(), this.initMultiSelect(), this.initSelect2(), this.initInputmask(), this.initTouchspin(), this.initTimepicker(), this.initColorpicker(), this.initDaterangepicker(), this.initMaxLength()
    }, i.Components = new t, i.Components.Constructor = t
}(window.jQuery),
function(t) {
    "use strict";
    window.jQuery.Components.init()
}();