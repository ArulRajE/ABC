$(document).ready(function() {
    "use strict";
    $("#progressbarwizard1").bootstrapWizard({
        tabClass: "nav nav-tabs"
    }), $("#progressbarwizard").bootstrapWizard({
        tabClass: "nav nav-tabs",
        onTabShow: function(t, a, r) {
            var s = (r + 1) / a.find("li").length * 100;
            $("#progressbarwizard").find(".bar").css({
                width: s + "%"
            })
        }
    }), $("#btnwizard").bootstrapWizard({
        tabClass: "nav nav-tabs",
        nextSelector: ".button-next",
        previousSelector: ".button-previous",
        firstSelector: ".button-first",
        lastSelector: ".button-last"
    }), $("#progressbarwizard11").bootstrapWizard({
        tabClass: "nav nav-tabs",
        onNext: function(t, a, r) {
            var s = $($(t).data("targetForm"));
            if (s) return event.preventDefault(), event.stopPropagation(), !1
        }
    })
});