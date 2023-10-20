function numbersOnly12(evt) {
  evt = evt ? evt : event;
  var charCode = evt.charCode
    ? evt.charCode
    : evt.keyCode
    ? evt.keyCode
    : evt.which
    ? evt.which
    : 0;

  if (
    (charCode >= 48 && charCode <= 57) ||
    charCode == 8 ||
    charCode == 9 ||
    charCode == 13 ||
    charCode == 37 ||
    charCode == 39
  ) {
    return true;
  }
  return false;
}
function getcpachanew() {
  // alert('ubbbb');

  $("#captchaCode").attr("src", "assets/captcha.php?" + new Date().getTime());
  // $('#captcha_code .captcha-input').load('assets/captcha.php'+(new Date()).getTime());

  //   $('.captcha-input').css('background-image', 'url(assets/captcha.php?' + (new Date()).getTime() + ')');
  //modified by sahana to unset the value for captcha.
  $("#captcha_Code").val("");
  return false;
}

function get_poplistof(dataof, comefrom) {
  if (comefrom == "DT") {
    $("#remarks_all_hist").modal("show");
    var tablejig = $("#remarks-datatable-list").DataTable({
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
      ],
      processing: true,
      serverSide: true,
      bServerSide: true,
      bDestroy: true,
      ajax: {
        url: "insert_data.php",
        type: "POST",
        data: function (d) {
          d.formname = "get_all_remarks";
          d.data = dataof;
          d.comefrom = comefrom;
        },
      },
      order: [[1, "asc"]],
      columnDefs: [
        {
          targets: 0,
          className: "wrap",
          render: function (dataa, type, row, meta) {
            if (type === "display") {
              data = dataa.replaceAll(";", ";<br />");
              data = data.replaceAll("- ;", "-");
            }
            return data;
          },
        },
        {
          targets: 3,
          render: function (dataaa, type, row, meta) {
            // console.log(dataaa);
            // console.log(row);
            if (type === "display") {
              data =
                '<a href="Alldocuments/' +
                row[3] +
                "/" +
                encodeURIComponent(row[4]) +
                '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" style="color:#4667cc;" title="" data-original-title=""></i></a>';
            }
            return data;
          },
        },
        { targets: 4, visible: false },
      ],
    });
  } else if (comefrom == "ST") {
    $("#remarks_all_hist").modal("show");
    var tablejig = $("#remarks-datatable-list").DataTable({
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
      ],
      processing: true,
      serverSide: true,
      bServerSide: true,
      bDestroy: true,
      ajax: {
        url: "insert_data.php",
        type: "POST",
        data: function (d) {
          d.formname = "get_all_remarks";
          d.data = dataof;
          d.comefrom = comefrom;
        },
      },
      order: [[1, "asc"]],
      columnDefs: [
        {
          targets: 0,
          className: "wrap",
          render: function (dataa, type, row, meta) {
            if (type === "display") {
              data = dataa.replaceAll(";", ";<br />");
              data = data.replaceAll("- ;", "-");
            }
            return data;
          },
        },
        {
          targets: 3,
          render: function (dataaa, type, row, meta) {
            // console.log(dataaa);
            // console.log(row);
            if (type === "display") {
              data =
                '<a href="Alldocuments/' +
                row[3] +
                "/" +
                encodeURIComponent(row[4]) +
                '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" style="color:#4667cc;" title="" data-original-title=""></i></a>';
            }
            return data;
          },
        },
        { targets: 4, visible: false },
      ],
    });
  } else if (comefrom == "SD") {
    $("#remarks_all_hist").modal("show");
    var tablejig = $("#remarks-datatable-list").DataTable({
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
      ],
      processing: true,
      serverSide: true,
      bServerSide: true,
      bDestroy: true,
      ajax: {
        url: "insert_data.php",
        type: "POST",
        data: function (d) {
          d.formname = "get_all_remarks";
          d.data = dataof;
          d.comefrom = comefrom;
        },
      },
      order: [[1, "asc"]],
      columnDefs: [
        {
          targets: 0,
          className: "wrap",
          render: function (dataa, type, row, meta) {
            if (type === "display") {
              data = dataa.replaceAll(";", ";<br />");
              data = data.replaceAll("- ;", "-");
            }
            return data;
          },
        },
        {
          targets: 3,
          render: function (dataaa, type, row, meta) {
            // console.log(dataaa);
            // console.log(row);
            if (type === "display") {
              data =
                '<a href="Alldocuments/' +
                row[3] +
                "/" +
                encodeURIComponent(row[4]) +
                '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" style="color:#4667cc;" title="" data-original-title=""></i></a>';
            }
            return data;
          },
        },
        { targets: 4, visible: false },
      ],
    });
  } else if (comefrom == "VT") {
    $("#remarks_all_hist").modal("show");
    var tablejig = $("#remarks-datatable-list").DataTable({
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
      ],
      processing: true,
      serverSide: true,
      bServerSide: true,
      bDestroy: true,
      ajax: {
        url: "insert_data.php",
        type: "POST",
        data: function (d) {
          d.formname = "get_all_remarks";
          d.data = dataof;
          d.comefrom = comefrom;
        },
      },
      order: [[1, "asc"]],
      columnDefs: [
        {
          targets: 0,
          className: "wrap",
          render: function (dataa, type, row, meta) {
            if (type === "display") {
              data = dataa.replaceAll(";", ";<br />");
              data = data.replaceAll("- ;", "-");
            }
            return data;
          },
        },
        {
          targets: 3,
          render: function (dataaa, type, row, meta) {
            // console.log(dataaa);
            // console.log(row);
            if (type === "display") {
              data =
                '<a href="Alldocuments/' +
                row[3] +
                "/" +
                encodeURIComponent(row[4]) +
                '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" style="color:#4667cc;" title="" data-original-title=""></i></a>';
            }
            return data;
          },
        },
        { targets: 4, visible: false },
      ],
    });
  }

  return false;
}

//modified by sahana for reuse of document || modified by sahana JC_22
function getdoc_list(docids, stids) {
  // Show the modal popup
  $("#con-link-document").modal("show");

  // Create a DataTable
  var tablejig = $("#alreadydoc-datatable-list").DataTable({
    // Specify DataTable options
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    processing: true,
    serverSide: true,
    bServerSide: true,
    bDestroy: true,
    ajax: {
      // Set the URL to which the AJAX request will be sent
      url: "insert_data.php",
      // Specify data to be sent with the AJAX request
      type: "POST",
      data: function (d) {
        d.formname = "getdocalreadyuploadlist_doc";
        d.docids = docids;
      },
    },
    // Specify DataTable columns and column options
    columnDefs: [
      {
        targets: 0,
        checkboxes: {
          selectRow: true,
          selectAll: false,
        },
        render: function (data, type, row, meta) {
          if (row[14] == 0) {
            if (row[13] == 1) {
              return '<input class="delivery_option_checkbox" type="checkbox" data-key="76," data-id_address="22" value="76," style="margin-top: 10px; cursor: pointer" required>';
            } else {
              return '<input class="delivery_option_checkbox" type="checkbox" data-key="76," data-id_address="22" value="76," style="margin-top: 10px; cursor: not-allowed" disabled required>';
            }
          } else {
            return '<input class="delivery_option_checkbox" type="checkbox" data-key="76," data-id_address="22" value="76," style="margin-top: 10px; cursor: not-allowed" disabled required>';
          }
        },
      },
      { targets: 1, visible: false },
      { targets: 4, className: "wrap" },
      { targets: 5, className: "wrap" },
      {
        targets: 2,
        render: function (dataa, type, row, meta) {
          if (type === "display") {
            data =
              '<a href="Alldocuments/' +
              stids +
              "/" +
              encodeURIComponent(dataa) +
              '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" style="color:#4667cc;" title="" data-original-title=""></i></a>';
          }
          return data;
        },
      },
      //modified by yogesh and sahana to delete pending link document
      {
        targets: 13,
        render: function (data, type, row, meta) {
          var deleteButton = "";
          if (row[13] == 0) {
            deleteButton =
              '<a href="javascript:void(0);" class="btn btn-danger delete-btn" onclick="deletependoc(' +
              row[1] +
              ', \'deletetablerowpen\')"><i class="fa fa-trash"></i></a>';
          } else {
            deleteButton =
              '<a href="javascript:void(0);" class="btn btn-danger delete-btn" disabled style="cursor: not-allowed;"><i class="fa fa-trash" style="cursor: not-allowed;"></i></a>';
          }
          return deleteButton;
        },
      },
      { targets: 14, visible: false },
      { targets: 15, visible: false }, //modified by sahana to differentaite with action and without action in link document status
    ],
    // Enable row selection with checkboxes (cannot select other row when one checkbox row is been selected)
    //   'select': {
    // 'style': 'os',
    // 'selector': 'td:not(:first-child)'
    // 'selector': 'td:first-child'
    //   },
    order: [[1, "asc"]],
    initComplete: function (settings, json) {
      // Set the value of the first data ID to a hidden input field
      if (json.data.length > 0) {
        $("#dataids").val(json.data[0][2]);
      }
    },
  });

  // modified by sahana for Disable other checkboxes when one is selected
  //if the checkbox is already checked and the row has the 'selected' class, clicking on it again won't uncheck the checkbox.
  $("#alreadydoc-datatable-list").on(
    "change",
    'input[type="checkbox"]',
    function () {
      var checkbox = $(this);
      var checked = checkbox.prop("checked");
      var checkboxes = $(
        '#alreadydoc-datatable-list input[type="checkbox"]'
      ).not(checkbox);
      var row = checkbox.closest("tr");

      if (checked && !row.hasClass("selected")) {
        row.addClass("selected");
        checkboxes.prop("disabled", true);
        checkboxes.css("cursor", "not-allowed");
        checkbox.prop("checked", true);

        var table = $("#alreadydoc-datatable-list").DataTable();
        table.rows().deselect();
        table.row(row).select();

        showInput();
      } else if (!checked && row.hasClass("selected")) {
        checkbox.prop("checked", true);
      }
      return false;
    }
  );

  return false;
}

//modified by sahana to delete pending link document
function deletependoc(docId) {
  Swal.fire({
    title: "Are you sure?",
    type: "warning",
    showCancelButton: true, // enable the cancel button
    confirmButtonColor: "#348cd4",
    cancelButtonColor: "#6c757d",
    confirmButtonText: "Yes, delete it!",
    preConfirm: function () {
      return new Promise(function (resolve) {
        var formData = new FormData();
        formData.append("formname", "deletedoc");
        formData.append("deletedids", docId);

        $.ajax({
          url: "insert_data.php",
          type: "POST",
          data: formData,
          contentType: false,
          cache: false,
          processData: false,
          success: function (data) {
            if (data === "deletedata") {
              Swal.fire({
                title: "Deleted",
                text: "Your record has been deleted.",
                type: "success",
              }).then(function (t) {
                location.reload();
              });
            } else if (data === "error") {
              Command: toastr["error"]("Server Problem try after sometime.");
            }
          },
          error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
              Command: toastr["error"]("Not connect.n Verify Network.");
            } else if (jqXHR.status == 404) {
              Command: toastr["error"]("Requested page not found. [404]");
            } else if (jqXHR.status == 500) {
              Command: toastr["error"]("Internal Server Error [500].");
            } else if (exception === "timeout") {
              Command: toastr["error"]("Time out error.");
            } else if (exception === "abort") {
              Command: toastr["error"]("Ajax request aborted.");
            } else {
              Command: toastr["error"]("Uncaught Error.n");
            }
          },
        }).done(function (response) {
          resolve(response);
        });
      });
    },
  }).then(function () {
    $("#con-link-document").modal("hide");
    location.reload();
  });
  return;
}

function gettext_data(val, i) {
  var status = $("#oremovenew" + i + "").is(":checked");
  if (
    ($("#comefromcheck").val() == "State" ||
      $("#comefromcheck").val() == "Village / Town") &&
    $("#clickpopup").val() == "Rename"
  ) {
    if (status == true) {
      $("#newnamecheck" + i + "").val("");
      if (i == "") {
        $(".ORRN").css("display", "block");
        $("#assignbtn").attr("disabled", false);
      } else {
        $(".ORRNN" + i + "").css("display", "block");
        $("#assignbtn").attr("disabled", false);
      }

      $("#newnamecheck" + i + "").prop("required", true);
    } else {
      $("#newnamecheck" + i + "").val("");
      if (i == "") {
        $(".ORRN").css("display", "none");

        if ($("#comefromcheck").val() == "Village / Town") {
          if ($("#vlevel_1").val() == $("#vStatus2021_1").val()) {
            $("#assignbtn").attr("disabled", true);
          } else {
            $("#assignbtn").attr("disabled", false);
          }
        } else {
          if ($("#toStatus_1").val() == $("#Statusyear_1").val()) {
            $("#assignbtn").attr("disabled", true);
            $(".add_button_name").attr("disabled", true);
          } else {
            $(".add_button_name").attr("disabled", false);
            $("#assignbtn").attr("disabled", false);
          }
        }
      } else {
        $(".ORRNN" + i + "").css("display", "none");

        if ($("#comefromcheck").val() == "Village / Town") {
          if (
            $("#vlevel_" + i + "").val() == $("#vStatus2021_" + i + "").val()
          ) {
            $("#assignbtn").attr("disabled", true);
          } else {
            $("#assignbtn").attr("disabled", false);
          }
        } else {
          if (
            $("#toStatus_" + i + "").val() == $("#Statusyear_" + i + "").val()
          ) {
            $("#assignbtn").attr("disabled", true);
          } else {
            $("#assignbtn").attr("disabled", false);
          }
        }
      }

      $("#newnamecheck" + i + "").prop("required", false);
    }
  } else {
    if (status == true) {
      $("#newnamecheck" + i + "").val("");
      if (i == "") {
        $(".ORRN").css("display", "block");
        $("#assignbtn").attr("disabled", false);
      } else {
        $(".ORRNN" + i + "").css("display", "block");
        $("#assignbtn").attr("disabled", false);
      }

      $("#newnamecheck" + i + "").prop("required", true);
    } else {
      $("#newnamecheck" + i + "").val("");
      if (i == "") {
        $(".ORRN").css("display", "none");
      } else {
        $(".ORRNN" + i + "").css("display", "none");
      }
      $("#newnamecheck" + i + "").prop("required", false);
    }

    $("#assignbtn").attr("disabled", false);
  }

  return false;
}

function linkeddocument(thisdata, datavalue, come) {
  getselecteddocumentredirect(datavalue, come, thisdata.value);
}

function reloadpage() {
  var doc = $("#docids").val();

  $('input[type="radio"]').attr("disabled", false);

  $('input[name="startfrom"]').prop("checked", false);
  $("#actionuse").css("display", "none");
  $(".disbut").attr("disabled", false);
  $("#daynamor").html("");

  $("#backbtnnew").css("visibility", "visible");
  $("#nextstep2").css("visibility", "hidden");

  return false;
}
function capitalizeFirstLetter(str) {
  var splitStr = str.toLowerCase().split(" ");
  for (var i = 0; i < splitStr.length; i++) {
    // You do not need to check if i is larger than splitStr length, as your for does that for you
    // Assign it back to the array
    splitStr[i] =
      splitStr[i].charAt(0).toUpperCase() + splitStr[i].substring(1);
  }
  // Directly return the joined string
  return splitStr.join(" ");
}
function get_doctype_data(data, doccome) {
  if (data.value != "" && data.value == "Others" && doccome == "") {
    $(".otherrmk").css("display", "block");
    $(".otherrmk").prop("required", true);
    $(".sdoc").css("display", "none");
    $(".sdoc").prop("required", false);
    $("#selectdocumnent_releted").val("").trigger("change");
  } else if (
    data.value != "" &&
    (data.value == "Resolution" ||
      data.value == "Clarification" ||
      data.value == "Collector Letter" ||
      data.value == "Others") &&
    doccome == "comefromdocadd"
  ) {
    $(".sdoc").css("display", "block");
    $(".sdoc").prop("required", true);
    $(".otherrmk").css("display", "none");
    $(".otherrmk").prop("required", false);
    $("#selectdocumnent_releted").val("").trigger("change");
  } else {
    $(".sdoc").css("display", "none");
    $(".sdoc").prop("required", false);
    $(".otherrmk").css("display", "none");
    $(".otherrmk").prop("required", false);
    $("#selectdocumnent_releted").val("").trigger("change");
  }
  return false;
}

function newdocumentadded() {
  $("#adddocnew").val(1);
  $("#adddocument").submit();
}

function selecteddocumentrow() {
  var rows_selected = $("#alreadydoc-datatable-list")
    .DataTable()
    .column(0)
    .checkboxes.selected();
  // console.log(rows_selected[0]);
  // return false;
  if (rows_selected.length >= 1) {
    $("#alreadydoc-datatable-list").modal("hide");
    // redirectcompleted(rows_selected[0]);
    window.location.href =
      "adddocument?idsdoc=" + rows_selected[0] + "&come=comefromdocreuse";
  } else {
    Command: toastr["warning"]("Select at least one record.");
    return false;
  }
}

function getsubdistcon(st, dt) {
  // JIGAR

  if (dt != "") {
    $.ajax({
      type: "POST",

      url: "insert_data.php",
      data: "formname=getconsd&STID=" + st + "&DTID=" + dt,
    }).done(function (result) {
      $("#SDID").children().remove();

      $("#SDID").append(
        $("<option>", {
          value: "",
          text: "Select Sub-District Name",
        })
      );

      $(JSON.parse(result)).each(function () {
        $("#SDID").append(
          $("<option>", {
            value: this.id,
            text: this.Name,
          })
        );
      });

      $("#SDID").val("").trigger("change");
    });
  }
}
function reportfilter(valdata) {
  $("#SDID").children().remove();

  $("#SDID").append(
    $("<option>", {
      value: "",
      text: "Select Sub-District Name",
    })
  );

  //    $('#SDID').val('').trigger('change');

  var pcatable1 = $("#ReportPCA-Village-datatable").DataTable({
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    scrollX: "100%",
    pageLength: 25,
    scrollY: "550px",
    processing: true,
    serverSide: true,
    bServerSide: true,
    bDestroy: true,
    //   "oLanguage": {"sProcessing": "<div class='modal-backdrop fade show'><div class='spinner-border text-primary mt-2 mr-2 lod' role='status'></div></div>"},
    ajax: {
      url: "insert_data.php",
      type: "POST",
      data: function (d) {
        d.formname = "getreportPCA";
        d.stids = $("#STID").val();
        d.dtids = $("#DTID").val();
        d.sdids = $("#SDID").val();
      },
    },
    order: [
      [0, "asc"],
      [2, "asc"],
      [4, "asc"],
      [6, "asc"],
    ],
    initComplete: function (settings, json) {
      if (json.data.length > 0) {
        getsubdistcon($("#STID").val(), valdata.value);
      }
    },
  });
}

function reportfilterst(valdata, come) {
  //modified by sahana to refresh concordance dropdown
  if (come === "ST") {
    $("#DTID").val("").trigger("change");
    $("#SDID").val("").trigger("change");
  }

  // modified by sahana, If the state dropdown is changed, reset the district and sub-district dropdowns
  if (come === "ST") {
    $("#DTID").val("").trigger("change");
    $("#SDID").val("").trigger("change");
  }

  if ($("#STID").val() != "") {
    if (
      $("#STID").val() != "" &&
      $("#DTID").val() == "" &&
      $("#SDID").val() == ""
    ) {
      $("#DTID").children().remove();

      $("#DTID").append(
        $("<option>", {
          value: "",
          text: "Select District Name",
        })
      );

      $("#SDID").children().remove();

      $("#SDID").append(
        $("<option>", {
          value: "",
          text: "Select Sub-District Name",
        })
      );
    } else if (
      $("#STID").val() != "" &&
      $("#DTID").val() != "" &&
      $("#SDID").val() == ""
    ) {
      $("#SDID").children().remove();

      $("#SDID").append(
        $("<option>", {
          value: "",
          text: "Select Sub-District Name",
        })
      );
    } else if (
      $("#STID").val() != "" &&
      $("#DTID").val() != "" &&
      $("#SDID").val() != ""
    ) {
      if (come == "ST") {
        $("#DTID").append(
          $("<option>", {
            value: "",
            text: "Select District Name",
          })
        );

        $("#SDID").children().remove();

        $("#SDID").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District Name",
          })
        );
      } else if (come == "DT") {
        $("#SDID").children().remove();

        $("#SDID").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District Name",
          })
        );
        $("#SDID").val("").trigger("change");
      }
    }

    // $('#SDID').val('').trigger('change');

    var pcatable1 = $("#ReportPCA-Village-datatable").DataTable({
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
      ],
      scrollX: "100%",
      pageLength: 25,
      scrollY: "550px",
      processing: true,
      serverSide: true,
      bServerSide: true,
      bDestroy: true,
      //   "oLanguage": {"sProcessing": "<div class='modal-backdrop fade show'><div class='spinner-border text-primary mt-2 mr-2 lod' role='status'></div></div>"},
      ajax: {
        url: "insert_data.php",
        type: "POST",
        data: function (d) {
          d.formname = "getreportPCA";
          d.stids = $("#STID").val();
          d.dtids = $("#DTID").val();
          d.sdids = $("#SDID").val();
        },
      },
      order: [
        [0, "asc"],
        [2, "asc"],
        [4, "asc"],
        [6, "asc"],
      ],
      // "initCompletedrawCallback": function (settings, json) {

      //     if (json.data.length > 0) {
      //       // alert(valdata.value);
      //         get_dist_select_data_year_report(valdata.value);
      //     }

      // }
      initComplete: function (settings) {
        // Here the response
        //  console.log(settings);
        var response = settings.json;
        //  console.log(response.other);
        if (response.other.length > 0) {
          if (
            $("#STID").val() != "" &&
            $("#DTID").val() == "" &&
            $("#SDID").val() == ""
          ) {
            $(response.other).each(function () {
              $("#DTID").append(
                $("<option>", {
                  value: this.DTID,
                  text: this.DTName,
                })
              );
            });

            //  $("#SDID").val('').trigger('change');
          } else if (
            $("#STID").val() != "" &&
            $("#DTID").val() != "" &&
            $("#SDID").val() == ""
          ) {
            $(response.other).each(function () {
              $("#SDID").append(
                $("<option>", {
                  value: this.SDID,
                  text: this.SDName,
                })
              );
            });

            // if(come=='DT')
            // {
            //     $("#SDID").val('').trigger('change');
            // }

            //   $("#SDID").val('').trigger('change');
          }
        }
      },
    });
  } else {
    location.reload();

    // $("#DTID").val('').trigger('change');
    //  $("#SDID").val('').trigger('change');
  }
}

function reportfiltersd(valdata) {
  var pcatable1 = $("#ReportPCA-Village-datatable").DataTable({
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
    scrollX: "100%",
    pageLength: 25,
    scrollY: "550px",
    processing: true,
    serverSide: true,
    bServerSide: true,
    bDestroy: true,
    //   "oLanguage": {"sProcessing": "<div class='modal-backdrop fade show'><div class='spinner-border text-primary mt-2 mr-2 lod' role='status'></div></div>"},
    ajax: {
      url: "insert_data.php",
      type: "POST",
      data: function (d) {
        d.formname = "getreportPCA";
        d.stids = $("#STID").val();
        d.dtids = $("#DTID").val();
        d.sdids = $("#SDID").val();
      },
    },
    order: [
      [0, "asc"],
      [2, "asc"],
      [4, "asc"],
      [6, "asc"],
    ],
    // "initComplete": function (settings, json) {

    //     if (json.data.length > 0) {
    //         getsubdistcon($('#STID').val(),valdata.value);
    //     }

    // }
  });
}
function get_filter_new(dataof, come, flag) {
  // modified by sahana, If the state dropdown is changed, reset the district and sub-district dropdowns
  if (come === "stselect") {
    $("#DTID").val("").trigger("change");
    $("#SDID").val("").trigger("change");
  }

  if ($("#STID").val() != "") {
    if (
      $("#STID").val() != "" &&
      $("#DTID").val() == "" &&
      $("#SDID").val() == ""
    ) {
      $("#DTID").children().remove();

      $("#DTID").append(
        $("<option>", {
          value: "",
          text: "Select District Name",
        })
      );

      $("#SDID").children().remove();

      $("#SDID").append(
        $("<option>", {
          value: "",
          text: "Select Sub-District Name",
        })
      );

      if ($("#DTID").val() == "") {
        $("#SDID").val("");
      }
    } else if (
      $("#STID").val() != "" &&
      $("#DTID").val() != "" &&
      $("#SDID").val() == ""
    ) {
      $("#SDID").children().remove();

      $("#SDID").append(
        $("<option>", {
          value: "",
          text: "Select Sub-District Name",
        })
      );
    } else if (
      $("#STID").val() != "" &&
      $("#DTID").val() != "" &&
      $("#SDID").val() != ""
    ) {
      if (flag == "ST") {
        $("#DTID").append(
          $("<option>", {
            value: "",
            text: "Select District Name",
          })
        );

        $("#SDID").children().remove();

        $("#SDID").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District Name",
          })
        );
      } else if (flag == "DT") {
        $("#SDID").children().remove();

        $("#SDID").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District Name",
          })
        );
        $("#SDID").val("").trigger("change");
      }
    }
    //  else if($('#STID').val()!='' && $('#DTID').val()=='' && $('#SDID').val()!='')
    //  {

    //                 if(flag=='ST')
    //                 {

    //                   $("#DTID").append($('<option>', {
    //                 value: '',
    //                 text: 'Select District Name',
    //                 }));

    //                      $("#SDID").children().remove();

    //                 $("#SDID").append($('<option>', {
    //                 value: '',
    //                 text: 'Select Sub-District Name',
    //                 }));

    //                  $('#SDID').val('').trigger('change')

    //                 }
    //                 else if(flag=='DT')
    //                 {

    //                      $("#SDID").children().remove();

    //                 $("#SDID").append($('<option>', {
    //                 value: '',
    //                 text: 'Select Sub-District Name',
    //                 }));
    //                   $('#SDID').val('').trigger('change')
    //                 }

    //  }

    $("#ttable").css("display", "block");
    var tempflag = "";
    var tempflag1 = "";
    var tempflag2 = "";

    tempflag = 28;
    tempflag1 = 0;
    tempflag2 = [3, 6, 13, 14, 17, 20, 27];

    var tablejig1 = $("#ttable-datatable").DataTable({
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
      ],
      processing: true,
      pageLength: 50,
      serverSide: true,
      bServerSide: true,
      bDestroy: true,
      scrollX: true,
      searching: true,
      ajax: {
        url: "insert_data.php",
        type: "POST",
        data: function (d) {
          //   console.log(d);
          d.formname = "getreportPCA_DATA";
          d.come = come;
          d.dataof = dataof;
          d.stids = $("#STID").val();
          d.dtids = $("#DTID").val();
          d.sdids = $("#SDID").val();

          d.flag = flag;
        },
      },
      columnDefs: [
        {
          targets: tempflag,

          render: function (dataa, type, row, meta) {
            if (type === "display") {
              data =
                '<a href="javascript:void(0)" onclick="return get_poplistof(\'' +
                row +
                "','" +
                flag +
                '\');"><i class="mdi mdi-comment-eye fa-2x mb-2" style="color:#4667cc;" data-toggle="tooltip"  data-placement="top" title="" data-original-title="View Remarks"></i></a>';
            }
            return data;
          },
        },

        { targets: tempflag1, visible: false },
        { targets: tempflag2, visible: false },
      ],
      order: [[1, "asc"]],
      initComplete: function (settings) {
        // Here the response
        //  console.log(settings);
        var response = settings.json;
        //  console.log(response.other);
        if (response.other.length > 0) {
          if (
            $("#STID").val() != "" &&
            $("#DTID").val() == "" &&
            $("#SDID").val() == ""
          ) {
            $(response.other).each(function () {
              $("#DTID").append(
                $("<option>", {
                  value: this.DTID,
                  text: this.DTName,
                })
              );
            });

            //  $("#SDID").val('').trigger('change');
          } else if (
            $("#STID").val() != "" &&
            $("#DTID").val() != "" &&
            $("#SDID").val() == ""
          ) {
            $(response.other).each(function () {
              $("#SDID").append(
                $("<option>", {
                  value: this.SDID,
                  text: this.SDName,
                })
              );
            });

            // if(come=='DT')
            // {
            //     $("#SDID").val('').trigger('change');
            // }

            //   $("#SDID").val('').trigger('change');
          }
        }
      },

      //modified by sahana for highlighted to be fixed when the remark is clicked in forread
      createdRow: function (row, data, dataIndex) {
        $(row).on("click", function () {
          if ($(this).hasClass("selected")) {
            $(this).removeClass("selected");
          } else {
            tablejig1.$("tr.selected").removeClass("selected");
            $(this).addClass("selected");
          }
        });
      },
    });
  } else {
    $("#ttable").css("display", "none");
  }
}

function get_filter(data, come, flag) {
  var co = $("#" + come + "").is(":checked");

  if (co == true) {
    $("#t" + flag + "").css("display", "block");
    var tempflag = "";
    var tempflag1 = "";
    var tempflag2 = "";

    if (flag == "DT") {
      tempflag = 8;
      tempflag1 = 3;
      tempflag2 = [7];
    } else if (flag == "SD") {
      tempflag = 10;
      tempflag1 = 4;
      tempflag2 = [9];
    } else if (flag == "VT") {
      tempflag = 24;
      tempflag1 = 0;
      tempflag2 = [3, 6, 11, 12, 15, 18, 23];
    } else {
      tempflag = 10;
      tempflag1 = 4;
      tempflag2 = [9];
    }
    var tablejig1 = $("#t" + flag + "-datatable").DataTable({
      lengthMenu: [
        [10, 25, 50, 100, -1],
        [10, 25, 50, 100, "All"],
      ],
      processing: true,
      pageLength: 50,
      serverSide: true,
      bServerSide: true,
      bDestroy: true,
      scrollX: true,
      searching: true,
      ajax: {
        url: "insert_data.php",
        type: "POST",
        data: function (d) {
          //   console.log(d);
          d.formname = "getreportPCA_DATA";
          d.come = come;
          d.flag = flag;
        },
      },
      columnDefs: [
        {
          targets: tempflag,

          render: function (dataa, type, row, meta) {
            if (type === "display") {
              data =
                '<a href="javascript:void(0)" onclick="return get_poplistof(\'' +
                row +
                "','" +
                flag +
                '\');"><i class="mdi mdi-comment-eye fa-2x mb-2" style="color:#4667cc;" data-toggle="tooltip"  data-placement="top" title="" data-original-title="View Remarks"></i></a>';
            }
            return data;
          },
        },

        { targets: tempflag1, visible: false },
        { targets: tempflag2, visible: false },
      ],
      order: [[1, "asc"]],
    });
  } else {
    $("#t" + flag + "").css("display", "none");
  }
}

function get_users_dist_select_data(data) {
  $.ajax({
    type: "POST",

    url: "insert_data.php",
    data:
      "formname=getdistlistusers&STID2021=" +
      data.value +
      "&adminids=" +
      $("#update_ids").val(),
  }).done(function (result) {
    var dataof = result.split("|");
    if (data.value != "") {
      $("#LKDTIDSa").show();
      $("#LKDTIDSa").html(dataof[1]);
      $("#linksDTID2021").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });
    }
  });
  return false;
}

function addget_users_dist_select_data(data) {
  $.ajax({
    type: "POST",

    url: "insert_data.php",
    data: "formname=addgetdistlistusers&STID2021=" + data.value,
  }).done(function (result) {
    var dataof = result.split("|");
    if (data.value != "") {
      $("#addLKDTIDS").show();
      $("#addLKDTIDS").html(dataof[1]);
      $("#addlinksDTID2021").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });
    } else {
      $("#addLKDTIDS").html("");
    }
  });
  return false;
}

function get_document_dist_select_data(data) {
  $("#lDTID2021").val("").trigger("change");
  $("#lDTID2021").children().remove();

  $.ajax({
    type: "POST",

    url: "insert_data.php",
    data: "formname=getdistlistdocument&STID2021=" + data.value,
  }).done(function (result) {
    var dataof = result.split("|");

    $("#lDTID2021").append(
      $("<option>", {
        value: "",
        text: "Select Districts Name",
      })
    );

    $(JSON.parse(dataof[0])).each(function () {
      $("#lDTID2021").append(
        $("<option>", {
          value: this.DTID2021,
          text: this.DTName2021,
        })
      );
    });

    if (data.value != "") {
      $(".listcomefrom").html("Districts List 2011-2021");
      $(".listcomefrom1").html("Districts List 2021");
      //   $('#listcomefrom').html('Districts List');

      $("#LKSTIDS").hide();
      $("#LKDTIDS").show();

      $("#LKDTIDS").html(dataof[1]);
      $("#linksDTID2021").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });
    } else {
      $(".listcomefrom").html("State List 2011-2021");
      $(".listcomefrom1").html("State List 2021");
      $("#LKSTIDS").show();
      $("#LKDTIDS").html("");
      $("#LKSDIDS").html("");
      $("#LKVTIDS").html("");

      $("#linkSTID2021 option:selected").each(function () {
        $(this).prop("selected", false);
      });
      $("#linkSTID2021").multiSelect("refresh");
      $("#linkSTID2021").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });
    }
  });
  return false;
}

function selectyears(ids, name) {
  var formData = new FormData();
  formData.append("formname", "setyears");
  formData.append("jcyids", ids);
  formData.append("jcyname", name);
  $.ajax({
    url: "insert_data.php", // Url to which the request is send
    type: "POST",
    data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
    contentType: false, // The content type used when sending data to the server.
    cache: false, // To unable request pages to be cached
    processData: false, // To send DOMDocument or non processed data file it is set to false
    success: function (
      data // A function to be called if request succeeds
    ) {
      var url = window.location.pathname;
      var filename = url.substring(url.lastIndexOf("/") + 1);

      //   if (data == 1) {
      window.location.href = "index";
      // if (filename == 'index') {
      //     window.location.href = 'units';
      // }
      // else {
      //     window.location.href = 'units';

      //     //  location.reload();
      // }

      // }
      // else if (data == 2) {
      //     window.location.href = 'index';
      //     // if (filename == 'index') {
      //     //     window.location.href = 'districts';
      //     // }
      //     // else {
      //     //    //  location.reload();
      //     //    window.location.href = 'districts';
      //     // }
      //     //  window.location.href='districts';
      // }
      // else if (data == 3) {
      //     window.location.href = 'index';
      //     // if (filename == 'index') {
      //     //     window.location.href = 'pcalist';
      //     // }
      //     // else {
      //     //     location.reload();
      //     // }
      //     //   window.location.href='pcalist';
      // }
      // else {
      //     window.location.href = 'index';
      // }

      // window.location.href='index';

      // location.reload();
      // $("#activeyear").html(data);
    },
    error: function (jqXHR, exception) {
      if (jqXHR.status === 0) {
        Command: toastr["error"]("Not connect.n Verify Network.");
      } else if (jqXHR.status == 404) {
        Command: toastr["error"]("Requested page not found. [404]");
      } else if (jqXHR.status == 500) {
        Command: toastr["error"]("Internal Server Error [500].");
      } else if (exception === "timeout") {
        Command: toastr["error"]("Time out error.");
      } else if (exception === "abort") {
        Command: toastr["error"]("Ajax request aborted.");
      } else {
        Command: toastr["error"]("Uncaught Error.n");
      }
    },
  });

  return false;
}

function get_fromvalue1(value, i) {
  var partiallyids1 = $("#partiallyids1").val();
  if (value == "") {
    $(".add_button").attr("disabled", true);
  } 
  if (
    value != "" &&
    $("#clickpopup").val() == "Create" &&
    ($("#comefromcheck").val() == "State" ||
      $("#comefromcheck").val() == "District")
  ) {
    var toaction = document.getElementsByName("newname[]");

    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=get_state_status&comefrom=" +
        $("#comefromcheck").val() +
        "&clickpopup=" +
        $("#clickpopup").val() +
        "&fstids=" +
        value +
        "&i=" +
        i,
    }).done(function (result) {
      var finalresult = result.split("|");
      if (finalresult[0] == "getdata") {
        $("#fstatus" + finalresult[2] + "")
          .val(finalresult[3])
          .trigger("change");
        if ($("#clickpopup").val() == "Create") {
          $('select[name="fstatus[]"] option').prop("disabled", false);
        }

        if (i != "") {
          $("#ostate" + i + "").val(finalresult[3]);
        }

        if (toaction.length != 1) {
          $(".add_button").attr("disabled", true);
          $(".add_button_new").attr("disabled", false);
        } else {
          $(".add_button").attr("disabled", false);
          $("#action" + i + "")
            .val("Split")
            .trigger("change");
        }
      }
    });
  } else if (
    value != "" &&
    ($("#clickpopup").val() == "Create" ||
      $("#clickpopup").val() == "Reshuffle") &&
    $("#comefromcheck").val() == "Village / Town"
  ) {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=get_vt_status&comefrom=" +
        $("#comefromcheck").val() +
        "&clickpopup=" +
        $("#clickpopup").val() +
        "&fstids=" +
        value +
        "&i=" +
        i,
    }).done(function (result) {
      var finalresult = result.split("|");
      if (finalresult[0] == "getdata") {
        //  $("#fstatus"+finalresult[2]+"").val(finalresult[3]).trigger('change');
        if (i != "") {
          $("#ostate" + i + "").val(finalresult[3]);
        }
      }
    });
  } else if (
    value != "" &&
    $("#clickpopup").val() == "Merge" &&
    $("#comefromcheck").val() == "State"
  ) {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=get_state_status&comefrom=" +
        $("#comefromcheck").val() +
        "&clickpopup=" +
        $("#clickpopup").val() +
        "&fstids=" +
        value +
        "&i=" +
        i,
    }).done(function (result) {
      var finalresult = result.split("|");
      if (finalresult[0] == "getdata") {
        //    $("#fstatus"+finalresult[2]+"").val(finalresult[3]).trigger('change');

        var fromdata1 = $("#fromdata").val();

        var fromdata = $('select[name="namefrom[]"] option:selected')
          .map(function () {
            return this.value;
          })
          .get();

        if (fromdata != "") {
          $("select[name*='newnamem[]']").children().remove();

          $("select[name*='newnamem[]']").append(
            $("<option>", {
              value: "",
              text: "Select " + $("#comefromcheck").val() + " / UT",
            })
          );

          $(JSON.parse(fromdata1)).each(function () {
            $("select[name*='newnamem[]']").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });

          $("select[name*='newnamem[]']").val("").trigger("change");
        }

        for (var i = 0; i < fromdata.length; i++) {
          $(
            "select[name*='newnamem[]'] option[value=" + fromdata[i] + "]"
          ).remove();
        }

        if (i != "") {
          $("#ostate" + i + "").val(finalresult[3]);
          var kl = "";
          if (finalresult[3] == "ST") {
            kl = "UT";
          } else {
            kl = "ST";
          }
          $("#fstatus" + finalresult[2] + " option").prop("disabled", false);
          $("#fstatus" + finalresult[2] + " option[value=" + kl + "]").prop(
            "disabled",
            true
          );
          $("#fstatus" + finalresult[2] + "")
            .val(finalresult[3])
            .trigger("change");
        }
      }
    });
  } else if (
    $("#clickpopup").val() == "Merge" &&
    $("#comefromcheck").val() == "Sub-District"
  ) {
    var fromdata = $('select[name="newnamem[]"] option:selected')
      .map(function () {
        return this.value;
      })
      .get();
    var filtered = fromdata.filter(function (el) {
      return el != null && el != "";
    });

    if ($.inArray(value, filtered) == 0) {
      $("select[name*='statenew[]']").val("").trigger("change");
      $("select[name*='districtnew[]']").val("").trigger("change");
      $("select[name*='newnamem[]']").children().remove();
      $("select[name*='newnamem[]']").append(
        $("<option>", {
          value: "",
          text: "Select " + $("#comefromcheck").val() + "",
        })
      );

      $("select[name*='newnamem[]']").val("").trigger("change");
    }
  } else if (
    $("#clickpopup").val() == "Merge" &&
    $("#comefromcheck").val() == "Village / Town"
  ) {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=get_vt_status&comefrom=" +
        $("#comefromcheck").val() +
        "&clickpopup=" +
        $("#clickpopup").val() +
        "&fstids=" +
        value +
        "&i=" +
        i,
    }).done(function (result) {
      var finalresult = result.split("|");
      if (finalresult[0] == "getdata") {
        var fromdata = $('select[name="newnamem[]"] option:selected')
          .map(function () {
            return this.value;
          })
          .get();
        var filtered = fromdata.filter(function (el) {
          return el != null && el != "";
        });

        if ($.inArray(value, filtered) == 0) {
          $("select[name*='statenew[]']").val("").trigger("change");
          $("select[name*='districtnew[]']").val("").trigger("change");
          $("select[name*='sddistrictnew[]']").val("").trigger("change");
          $("select[name*='newnamem[]']").children().remove();
          $("select[name*='newnamem[]']").append(
            $("<option>", {
              value: "",
              text: "Select " + $("#comefromcheck").val() + "",
            })
          );

          $("select[name*='newnamem[]']").val("").trigger("change");
        }

        if (i != "") {
          $("#ostate" + i + "").val(finalresult[3]);
        }
      }
    });
  }
  //  else if(value!='' && $('#clickpopup').val()=='Create' && $('#comefromcheck').val()=='District')
  // {
  //     $('.add_button').attr('disabled', false);
  // }
  else if (
    $("#clickpopup").val() == "Merge" &&
    $("#comefromcheck").val() == "District"
  ) {
    var fromdata = $('select[name="newnamem[]"] option:selected')
      .map(function () {
        return this.value;
      })
      .get();

    // var fromdata1 = $('select[name="namefrom[]"] option:selected').map(function () {
    //        return this.value;

    //    }).get();

    var filtered = fromdata.filter(function (el) {
      return el != null && el != "";
    });

    // var filtered1 = fromdata1.filter(function (el) {
    //                                       return el != null && el != "";
    //                                       });

    // console.log(filtered1);

    if ($.inArray(value, filtered) == 0) {
      $("select[name*='statenew[]']").val("").trigger("change");
      $("select[name*='newnamem[]']").children().remove();
      $("select[name*='newnamem[]']").append(
        $("<option>", {
          value: "",
          text: "Select " + $("#comefromcheck").val() + "",
        })
      );

      $("select[name*='newnamem[]']").val("").trigger("change");
    }
  }
  // else if($('#clickpopup').val()=='Create' && $('#comefromcheck').val()=='Sub-District' && partiallyids1!='')
  //JC_38
  else if (
    ($("#clickpopup").val() == "Create" &&
      $("#comefromcheck").val() == "Sub-District") ||
    ($("#comefromcheck").val() == "Village / Town" && partiallyids1 != "")
  ) {
    if (partiallyids1 != "") {
      var tstids = $("#tstids").val();
      //  alert(tstids);
      $("#statenew1").val(tstids).trigger("change");
      // $("#statenew1").val(tstids).trigger('change');
    }
  }
  // JC_104 Modified by arul for action refresh in district M/PM
  if(value == "" &&
  $("#clickpopup").val() == "Merge"){
  if($("#comefromcheck").val() == "District"){
        $("#action" + i + "")
        .val("")
        .trigger("change");
   } else if($("#comefromcheck").val() == "State"){
    $("#action" + i + "")
        .val("")
        .trigger("change");
        $("#fstatus" + i + "")
        .val("")
        .trigger("change");
  }
  }
}

function get_to_data(value, i) {
  if (
    value.value != "" &&
    $("#clickpopup").val() == "Merge" &&
    $("#comefromcheck").val() == "State"
  ) {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=get_state_status&comefrom=" +
        $("#comefromcheck").val() +
        "&clickpopup=" +
        $("#clickpopup").val() +
        "&fstids=" +
        value.value +
        "&i=" +
        i,
      }).done(function (result) {
      var finalresult = result.split("|");
      //   console.log(finalresult);

      if (finalresult[0] == "getdata") {
        $("#Statusyear_1").val(finalresult[3]).trigger("change");
        $("#toStatus_1").val(finalresult[3]);
      }
    });
    // JC_11 Modified by Arul for disable add M/PM
    $('.add_button').prop('disabled', true);
  } else if (
    value.value != "" &&
    $("#clickpopup").val() == "Rename" &&
    $("#comefromcheck").val() == "State"
  ) {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=get_state_status&comefrom=" +
        $("#comefromcheck").val() +
        "&clickpopup=" +
        $("#clickpopup").val() +
        "&fstids=" +
        value.value +
        "&i=" +
        i,
    }).done(function (result) {
      var finalresult = result.split("|");

      if (finalresult[0] == "getdata") {
        if (finalresult[3] != "") {
          if (i == "") {
            $("#Statusyear_1").val(finalresult[3]).trigger("change");
          } else {
            $("#Status2021_" + i + "")
              .val(finalresult[3])
              .trigger("change");
          }
        }

        if (i == "") {
          i = 1;
        }
        $("#toStatus_" + i + "").val(finalresult[3]);
      }
    });
  } else if (
    value.value != "" &&
    ($("#clickpopup").val() == "Rename" ||
      $("#clickpopup").val() == "Merge" ||
      $("#clickpopup").val() == "Partiallysm") &&
    $("#comefromcheck").val() == "Village / Town"
  ) {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=get_vt_status&comefrom=" +
        $("#comefromcheck").val() +
        "&clickpopup=" +
        $("#clickpopup").val() +
        "&fstids=" +
        value.value +
        "&i=" +
        i,
    }).done(function (result) {
      var finalresult = result.split("|");

      if (finalresult[0] == "getdata") {
        if (i == "") {
          i = 1;
        }

        $("#vStatus2021_" + i + "")
          .val(finalresult[3])
          .trigger("change");
        $("#vlevel_" + i + "").val(finalresult[3]);
        if (finalresult[4] == "") {
          $("#vstatus" + i + "")
            .val("RV")
            .trigger("change");
          $("#ovstatus_" + i + "").val("RV");
        } else if (finalresult[4] != "") {
          //  alert(finalresult[3]);
          // alert(finalresult[4]);
          $("#vstatus" + i + "")
            .val(finalresult[4])
            .trigger("change");
          $("#ovstatus_" + i + "").val(finalresult[4]);
        } else {
          $("#vstatus" + i + "")
            .val(finalresult[4])
            .trigger("change");
          $("#ovstatus_" + i + "").val();
        }
      }
    });
  }
  // JC_104 Modified by Arul for Refresh Status
  else if($("#clickpopup").val() == "Merge" &&
    $("#comefromcheck").val() == "State" &&  value.value == ""){
    $("#Statusyear_1").val('').trigger("change");
    $("#toStatus_1").val('');
    $('.add_button').prop('disabled', false);
    }
  
  // Ends...
}

function get_fromvalue(value, comedata) {
  if (value != "") {
    var fromdata = $("#fromdata").val();
    if (fromdata != "") {
      $("#selected_comemrg").children().remove();

      $("#selected_comemrg").append(
        $("<option>", {
          value: "",
          text: "Select " + $("#comefromcheckmrg").val() + "",
        })
      );

      $(JSON.parse(fromdata)).each(function () {
        $("#selected_comemrg").append(
          $("<option>", {
            value: this.id,
            text: this.Name,
          })
        );
      });

      $("#selected_comemrg").val("").trigger("change");
    }

    $("#selected_comemrg option[value=" + value + "]").remove();
  }
}

function get_sub_district_popup_list(data) {
  var seleted = $("#applyon").val();
  var clickpopup = $("#submergedata #clickpopup").val();

  var fstids = $('select[name="stategetsub[]"] option:selected')
    .map(function () {
      return this.value;
    })
    .get();

  var fdtids = $('select[name="districtgetsub[]"] option:selected')
    .map(function () {
      return this.value;
    })
    .get();
  var fsdids = $('select[name="subdistrictgetsub[]"] option:selected')
    .map(function () {
      return this.value;
    })
    .get();

  var tstids = $("#tstids").val();
  var tdtids = $("#tdtids").val();
  var tsdids = $("#tsdids").val();

  if (data.value != "") {
    if (data.value != fsdids && fsdids != "") {
      var fsdids = fsdids;
    } else {
      var fsdids = data.value;
    }

    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopupsub_vtlist&comefrom=" +
        seleted +
        "&clickpopup=" +
        clickpopup +
        "&fstids=" +
        fstids +
        "&fdtids=" +
        fdtids +
        "&fsdids=" +
        fsdids +
        "&tstids=" +
        tstids +
        "&tdtids=" +
        tdtids +
        "&tsdids=" +
        tsdids,
    }).done(function (result) {
      var finalresult = result.split("|");

      if (finalresult[2] == "State") {
        $("#statestatus").css("display", "block");
        $("#statestatus1").css("display", "block");
      } else {
        $("#statestatus").css("display", "none");
        $("#statestatus1").css("display", "none");
      }

      $("#maintitle").html("Merge / Partially Merge - " + finalresult[2] + "");

      $("#comespan").html("[Merge / Partially Merge - " + finalresult[2] + "]");
      $("#addlable").html("Select " + finalresult[2] + "");
      $("#addlable1").html("Select " + finalresult[2] + "");
      $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");

      // console.log(finalresult);

      if (finalresult[2] != "State" || finalresult[2] != "District") {
        ////Submerge Dropdown village issue by Pavithra
        $("#addbtu,#adddataof,#let").css("display", "block ");

        $("#comefromdata123").html("");
        $("#comefromdata123").html(finalresult[3]);
        $(".haveapartially").prop("disabled", true);
        $("#selected_comesub").multiSelect({
          selectableHeader:
            "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          selectionHeader:
            "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          afterInit: function (t) {
            var e = this,
              n = e.$selectableUl.prev(),
              a = e.$selectionUl.prev(),
              i =
                "#" +
                e.$container.attr("id") +
                " .ms-elem-selectable:not(.ms-selected)",
              s =
                "#" +
                e.$container.attr("id") +
                " .ms-elem-selection.ms-selected";
            (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
              if (40 === t.which) return e.$selectableUl.focus(), !1;
            })),
              (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                if (40 == t.which) return e.$selectionUl.focus(), !1;
              }));
          },
          afterSelect: function (values) {
            var $el = $("#ms-selected_comesub");

            $("#totaldefultselected_1").html(
              $el.find('[class*="ms-elem-selection ms-selected"]').length
            );

            this.qs1.cache(), this.qs2.cache();
            if (this.qs2.matchedResultsCount != 0) {
              $(".haveapartially").prop("disabled", false);
            } else {
              $(".haveapartially").prop("disabled", true);
            }
          },
          afterDeselect: function () {
            var $el = $("#ms-selected_comesub");

            $("#totaldefultselected_1").html(
              $el.find('[class*="ms-elem-selection ms-selected"]').length
            );

            this.qs1.cache(), this.qs2.cache();
            if (this.qs2.matchedResultsCount != 0) {
              $(".haveapartially").prop("disabled", false);
            } else {
              $(".haveapartially").prop("disabled", true);
            }
          },
        });
      }
    });
  } else {
    $("#addbtu,#adddataof,#let").css("display", "none");
  }

  return false;
}

function get_district_popup_sublist(data) {
  
  var seleted = $("#applyon").val();
  var clickpopup = $("#submergedata #clickpopup").val();

  var fstids = $('select[name="stategetsub[]"] option:selected')
    .map(function () {
      return this.value;
    })
    .get();

  var fdtids = $('select[name="districtgetsub[]"] option:selected')
    .map(function () {
      return this.value;
    })
    .get();
  var fsdids = $("#fsdids").val();

  var tstids = $("#tstids").val();
  var tdtids = $("#tdtids").val();
  var tsdids = $("#tsdids").val();

  if (data.value != "") {
    if (data.value != fdtids && fdtids != "") {
      var fdtids = fdtids;
    } else {
      var fdtids = data.value;
    }

    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopupsub_sublist&comefrom=" +
        seleted +
        "&clickpopup=" +
        clickpopup +
        "&fstids=" +
        fstids +
        "&fdtids=" +
        fdtids +
        "&fsdids=" +
        fsdids +
        "&tstids=" +
        tstids +
        "&tdtids=" +
        tdtids +
        "&tsdids=" +
        tsdids,
    }).done(function (result) {
      var finalresult = result.split("|");

      if (finalresult[2] == "State") {
        $("#statestatus").css("display", "block");
        $("#statestatus1").css("display", "block");
      } else {
        $("#statestatus").css("display", "none");
        $("#statestatus1").css("display", "none");
      }

      if (seleted == "State") {
        $("#maintitle").html(
          "Merge / Partially Merge - " + finalresult[2] + " / UT"
        );

        $("#comespan").html(
          "[Merge / Partially Merge - " + finalresult[2] + " / UT]"
        );
        $("#addlable").html("Select " + finalresult[2] + " / UT");
        $("#addlable1").html("Select " + finalresult[2] + " / UT");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " / UT Name");
      } else {
        $("#maintitle").html(
          "Merge / Partially Merge - " + finalresult[2] + ""
        );

        $("#comespan").html(
          "[Merge / Partially Merge - " + finalresult[2] + "]"
        );
        $("#addlable").html("Select " + finalresult[2] + "");
        $("#addlable1").html("Select " + finalresult[2] + "");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
      }

      if (finalresult[1] == "Village / Town") {
        $("#subdistrictstatussub").css("display", "block");
        $("#subdistrictgetsub").prop("required", true);
        $("#subdistrictgetsub").children().remove();
        $("#subdistrictgetsub").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District",
          })
        );
        // $("#action1,#actiona2").children().remove();

        $(JSON.parse(finalresult[0])).each(function () {
          $("#subdistrictgetsub").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });
        $("#subdistrictgetsub").val("").trigger("change");
        //Submerge Dropdown village issue by Pavithra
        // $('#addbtu,#adddataof,#let').css("display", "block");
        $("#addbtu,#adddataof,#let").css("display", "none");
      } else {
        // console.log(finalresult);

        if (finalresult[2] != "State" || finalresult[2] != "District") {
          $("#addbtu,#adddataof,#let").css("display", "block");

          $("#comefromdata123").html("");
          $("#comefromdata123").html(finalresult[3]);
          $(".haveapartially").prop("disabled", true);
          $("#selected_comesub").multiSelect({
            selectableHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function (t) {
              var e = this,
                n = e.$selectableUl.prev(),
                a = e.$selectionUl.prev(),
                i =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selectable:not(.ms-selected)",
                s =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selection.ms-selected";
              (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
                if (40 === t.which) return e.$selectableUl.focus(), !1;
              })),
                (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                  if (40 == t.which) return e.$selectionUl.focus(), !1;
                }));
            },
            afterSelect: function (values) {
              this.qs1.cache(), this.qs2.cache();
              if (this.qs2.matchedResultsCount != 0) {
                $(".haveapartially").prop("disabled", false);
              } else {
                $(".haveapartially").prop("disabled", true);
              }
            },
            afterDeselect: function () {
              this.qs1.cache(), this.qs2.cache();
              if (this.qs2.matchedResultsCount != 0) {
                $(".haveapartially").prop("disabled", false);
              } else {
                $(".haveapartially").prop("disabled", true);
              }
            },
          });
        }
      }
    });
  } else {
    $("#addbtu,#adddataof,#let").css("display", "none");
  }

  return false;
}

function get_district_popup_list(data) {
  
  var seleted = $("#applyon").val();
  var clickpopup = $("#submergedata #clickpopup").val();

  var fstids = $('select[name="stategetsub[]"] option:selected')
    .map(function () {
      return this.value;
    })
    .get();

  var fdtids = $("#fdtids").val();
  var fsdids = $("#fsdids").val();

  var tstids = $("#tstids").val();
  var tdtids = $("#tdtids").val();
  var tsdids = $("#tsdids").val();

  if (data.value != "") {
    if (data.value != fstids && fstids != "") {
      var fstids = fstids;
    } else {
      var fstids = data.value;
    }

    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopupsub_list&comefrom=" +
        seleted +
        "&clickpopup=" +
        clickpopup +
        "&fstids=" +
        fstids +
        "&fdtids=" +
        fdtids +
        "&fsdids=" +
        fsdids +
        "&tstids=" +
        tstids +
        "&tdtids=" +
        tdtids +
        "&tsdids=" +
        tsdids,
    }).done(function (result) {
      var finalresult = result.split("|");

      if (finalresult[2] == "State") {
        $("#statestatus").css("display", "block");
        $("#statestatus1").css("display", "block");
      } else {
        $("#statestatus").css("display", "none");
        $("#statestatus1").css("display", "none");
      }

      if (seleted == "State") {
        $("#maintitle").html(
          "Merge / Partially Merge - " + finalresult[2] + " / UT"
        );

        $("#comespan").html(
          "[Merge / Partially Merge - " + finalresult[2] + " / UT]"
        );
        $("#addlable").html("Select " + finalresult[2] + " / UT");
        $("#addlable1").html("Select " + finalresult[2] + " / UT");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " / UT Name");
      } else {
        $("#maintitle").html(
          "Merge / Partially Merge - " + finalresult[2] + ""
        );

        $("#comespan").html(
          "[Merge / Partially Merge - " + finalresult[2] + "]"
        );
        $("#addlable").html("Select " + finalresult[2] + "");
        $("#addlable1").html("Select " + finalresult[2] + "");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
      }

      if (
        finalresult[1] == "Sub-District" ||
        finalresult[1] == "Village / Town"
      ) {
        $("#subdistrictstatussub").css("display", "none");
        $("#subdistrictgetsub").prop("required", false);

        $("#districtstatussub").css("display", "block");
        $("#districtgetsub").prop("required", true);

        $("#districtgetsub").children().remove();
        $("#districtgetsub").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );
        // $("#action1,#actiona2").children().remove();

        $(JSON.parse(finalresult[0])).each(function () {
          $("#districtgetsub").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });
        $("#districtgetsub").val("").trigger("change");
        $("#addbtu,#adddataof,#let").css("display", "none");
      } else {
        // console.log(finalresult);

        if (finalresult[2] != "State") {
          $("#addbtu,#adddataof,#let").css("display", "block");

          $("#comefromdata123").html("");
          $("#comefromdata123").html(finalresult[3]);
          $(".haveapartially").prop("disabled", true);
          $("#selected_comesub").multiSelect({
            selectableHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function (t) {
              var e = this,
                n = e.$selectableUl.prev(),
                a = e.$selectionUl.prev(),
                i =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selectable:not(.ms-selected)",
                s =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selection.ms-selected";
              (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
                if (40 === t.which) return e.$selectableUl.focus(), !1;
              })),
                (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                  if (40 == t.which) return e.$selectionUl.focus(), !1;
                }));
            },
            afterSelect: function (values) {
              this.qs1.cache(), this.qs2.cache();
              if (this.qs2.matchedResultsCount != 0) {
                $(".haveapartially").prop("disabled", false);
              } else {
                $(".haveapartially").prop("disabled", true);
              }
            },
            afterDeselect: function () {
              this.qs1.cache(), this.qs2.cache();
              if (this.qs2.matchedResultsCount != 0) {
                $(".haveapartially").prop("disabled", false);
              } else {
                $(".haveapartially").prop("disabled", true);
              }
            },
          });
        }
      }
    });
  } else {
    $("#addbtu,#adddataof,#let").css("display", "none");
  }

  return false;
}

function get_district_popup(data, clickpopup) {
  //console.log(data.id);

  var mul = data.id.split("_");

  var seleted = $("#applyon").val();
  var clickpopup = $("#clickpopup").val();

  var fstids = $('select[name="fromstate[]"] option:selected')
    .map(function () {
      return this.value;
    })
    .get();

  var fdtids = $("#fdtids").val();
  var fsdids = $("#fsdids").val();

  var tstids = $("#tstids").val();
  var tdtids = $("#tdtids").val();
  var tsdids = $("#tsdids").val();

  // var clickpopup = $('#clickpopup').val();

  if (seleted == "Sub-District") {
    if (data.value != "" && tstids == "") {
      $("#addbtu,#adddataof,#let").css("display", "block");
      $("#addbtumrg,#adddataofmrg,#letmrg").css("display", "block");
      $("#addbtumrgp,#adddataofmrgp,#letmrgp").css("display", "block");
    } else if (data.value != "" && tstids != "") {
      $("#adddataof,#let").css("display", "block");
      $("#addbtu,#addbtut").css("display", "none");
      $("#addbtumrg,#adddataofmrg,#letmrg").css("display", "block");
      $("#addbtumrgp,#adddataofmrgp,#letmrgp").css("display", "block");
    } else {
      //$('#addbtu,#adddataof,#let').css("display", "none");
      $("#addbtumrg,#adddataofmrg,#letmrg").css("display", "none");
      $("#addbtumrgp,#adddataofmrgp,#letmrgp").css("display", "none");
    }

    $("#subdistrictstatus").css("display", "none");
    $("#subdistrictget").prop("required", false);

    $("#villagestatus").css("display", "none");
    $("#villagestatus").prop("required", false);
  }
  // else
  // {

  //     //$('#addbtu,#adddataof,#let').css("display", "none");
  //   //  $('#addbtumrg,#adddataofmrg,#letmrg').css("display", "block");
  // //$('#addbtumrgp,#adddataofmrgp,#letmrgp').css("display", "none");

  // }

  // if(data.value!='')
  // {

  if (data.value != fdtids && fdtids != "") {
    var fdtids = fdtids;
  } else {
    var fdtids = data.value;
  }

  $.ajax({
    type: "POST",
    url: "insert_data.php",
    data:
      "formname=getdataofpopupsub&comefrom=" +
      seleted +
      "&clickpopup=" +
      clickpopup +
      "&fstids=" +
      fstids +
      "&fdtids=" +
      fdtids +
      "&fsdids=" +
      fsdids +
      "&tstids=" +
      tstids +
      "&tdtids=" +
      tdtids +
      "&tsdids=" +
      tsdids,
  }).done(function (result) {
    var finalresult = result.split("|");

    //    console.log(finalresult);

    if (seleted == "State") {
      $("#statestatus").css("display", "block");
      $("#statestatus1").css("display", "block");
    } else {
      $("#statestatus").css("display", "none");
      $("#statestatus1").css("display", "none");
    }

    // if(clickpopup=='Create')
    // {
    //         if(seleted=='State')
    //         {
    //             $("#maintitle").html("Create New - "+seleted+" / UT");
    //             $("#comespan").html("[Create New - "+seleted+"  / UT]");
    //             $("#addlable").html("Enter "+seleted+" / UT");
    //             $("#addlable1").html("Select "+seleted+" / UT");
    //             $("#name2021").attr("placeholder", ""+seleted+" / UT Name");
    //         }
    //         else
    //         {
    //             $("#maintitle").html("Create New - "+seleted+"");
    //             $("#comespan").html("[Create New - "+seleted+"]");
    //             $("#addlable").html("Enter "+seleted+"");
    //             $("#addlable1").html("Select "+seleted+"");
    //             $("#name2021").attr("placeholder", ""+seleted+" Name");
    //         }

    // }
    if (clickpopup == "Create" || clickpopup == "Addition") {
      // $("#maintitle").html("Create New "+finalresult[2]+"");
      // $("#comespan").html("[Create New "+finalresult[2]+"]");
      // $("#addlable").html("Enter "+finalresult[2]+"");
      // $("#addlable1").html("Select "+finalresult[2]+"");
      // $("#name2021").attr("placeholder", ""+finalresult[2]+" Name");
      if (seleted == "State") {
        $("#maintitle").html("Create New - " + seleted + " / UT");
        $("#comespan").html("[Create New - " + seleted + "  / UT]");
        $("#addlable").html("Enter " + seleted + " / UT");
        $("#addlable1").html("Select " + seleted + " / UT");
        $("#name2021").attr("placeholder", "" + seleted + " / UT Name");
      } else {
        if (clickpopup == "Addition") {
          $("#maintitle").html("Add New Village(s)");
          $("#comespan").html("[Add New Village(s)]");
          $("#addlable").html("Enter Village");
          $("#addlable1").html("Select " + seleted + "");
          $("#name2021").attr("placeholder", "New Village Name");
        } else {
          $("#maintitle").html("Create New - " + seleted + "");
          $("#comespan").html("[Create New - " + seleted + "]");
          $("#addlable").html("Enter " + seleted + "");
          $("#addlable1").html("Select " + seleted + "");
          $("#name2021").attr("placeholder", "" + seleted + " Name");
        }
      }
    } else if (clickpopup == "Partiallysm") {
      if (seleted == "State") {
        $("#maintitle").html("Partially Split & Merge " + seleted + " / UT");

        $("#comespan").html("[Partially Split & Merge " + seleted + " / UT]");
        $("#addlable").html("Enter " + seleted + " / UT");
        $("#addlable1").html("Select " + seleted + " / UT");
        $("#name2021").attr("placeholder", "" + seleted + " / UT Name");
      } else {
        $("#maintitle").html("Partially Split & Merge " + seleted + "");

        $("#comespan").html("[Partially Split & Merge " + seleted + "]");
        $("#addlable").html("Select " + seleted + "");
        $("#addlable1").html("Select " + seleted + "");
        $("#name2021").attr("placeholder", "" + seleted + " Name");
      }
    } else if (clickpopup == "Reshuffle") {
      $("#maintitle").html("Move / Reshuffle " + seleted + "");

      $("#comespan").html("[Move / Reshuffle " + seleted + "]");
      $("#addlable").html("Select " + seleted + "");
      $("#addlable1").html("Select " + seleted + "");
      $("#name2021").attr("placeholder", "" + seleted + " Name");
    } else if (clickpopup == "Rename") {
      if (seleted == "State") {
        $("#maintitle").html("Rename/Status Change " + seleted + " / UT");
        $("#comespan").html("[Rename/Status Change " + seleted + " / UT]");
        $("#addlable").html("Select " + seleted + " / UT");
        $("#addlable1").html("Select " + seleted + " / UT");
        $("#name2021").attr("placeholder", "" + seleted + " / UT Name");
      } else if (seleted == "Village / Town") {
        $("#maintitle").html("Rename/Status Change " + seleted + "");
        $("#comespan").html("[Rename/Status Change " + seleted + "]");
        $("#addlable").html("Select " + seleted + "");
        $("#addlable1").html("Select " + seleted + "");
        $("#name2021").attr("placeholder", "" + seleted + " Name");
      } else {
        $("#maintitle").html("Rename " + seleted + "");

        $("#comespan").html("[Rename " + seleted + "]");
        $("#addlable").html("Select " + seleted + "");
        $("#addlable1").html("Select " + seleted + "");
        $("#name2021").attr("placeholder", "" + seleted + " Name");
      }
    }

    //delete code added
    else if (clickpopup == "Deletion") {
      //     if(seleted=='State')
      //         {
      // $("#maintitle").html("Delete "+seleted+" / UT");
      // $("#comespan").html("[Delete"+seleted+" / UT]");
      // $("#addlable").html("Select "+seleted+" / UT");
      // $("#addlable1").html("Select "+seleted+" / UT");
      // $("#name2021").attr("placeholder", ""+seleted+" / UT Name");
      // }
      if (seleted == "Village / Town") {
        $("#maintitle").html("Delete " + seleted + "");
        $("#comespan").html("[Delete " + seleted + "]");
        $("#addlable").html("Select " + seleted + "");
        $("#addlable1").html("Select " + seleted + "");
        $("#name2021").attr("placeholder", "" + seleted + " Name");
      } else {
        $("#maintitle").html("Delete " + seleted + "");

        $("#comespan").html("[Delete " + seleted + "]");
        $("#addlable").html("Select " + seleted + "");
        $("#addlable1").html("Select " + seleted + "");
        $("#name2021").attr("placeholder", "" + seleted + " Name");
      }
    } else {
      if (seleted == "State") {
        $("#maintitle").html("Merge / Partially Merge - " + seleted + " / UT");
        $("#comespan").html(
          "[Merge / Partially Merge - " + seleted + "  / UT]"
        );
        $("#addlable").html("Select " + seleted + " / UT");
        $("#addlable1").html("Select " + seleted + " / UT");
        $("#name2021").attr("placeholder", "" + seleted + " / UT Name");
      } else {
        $("#maintitle").html("Merge / Partially Merge - " + seleted + "");

        $("#comespan").html("[Merge / Partially Merge - " + seleted + "]");
        $("#addlable").html("Select " + seleted + "");
        $("#addlable1").html("Select " + seleted + "");
        $("#name2021").attr("placeholder", "" + seleted + " Name");
      }
    }

    // if(seleted=='Sub-District')
    // {

    //             if(finalresult[3]=='Create' || finalresult[3]=='Merge' || finalresult[3]=='Partiallysm' || finalresult[3]=='Reshuffle')
    //             {

    //                 if(mul[1]=='undefined' || mul[1]==undefined)
    //                 {
    //                 //   alert(seleted);

    //                         $("#selected_come").children().remove();

    //                         $("#selected_come").append($('<option>', {
    //                         value: '',
    //                         text: 'Select '+seleted+'',
    //                         }));

    //                         $(JSON.parse(finalresult[0])).each(function () {

    //                         $("#selected_come").append($('<option>', {
    //                         value: this.id,
    //                         text: this.Name,
    //                         }));

    //                         });

    // Incomplete Sub-district trigger JC_02

    if (seleted == "Sub-District") {
      if (
        finalresult[3] == "Create" ||
        finalresult[3] == "Merge" ||
        finalresult[3] == "Partiallysm" ||
        finalresult[3] == "Reshuffle"
      ) {
        if (mul[1] == "undefined" || mul[1] == undefined) {
          //   alert(seleted);

          $("#selected_come").children().remove();

          $("#selected_come").append(
            $("<option>", {
              value: "",
              text: "Select " + seleted + "",
            })
          );
          if (data.value != "") {
            $(JSON.parse(finalresult[0])).each(function () {
              $("#selected_come").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });
            if ($("#flagof").val() == "true") {
              $("#selected_come").val(fsdids).trigger("change");
            } else {
              $("#selected_come").val("").trigger("change");
            }
          }

          // JC_02 ends here

          // code changed by bheema
          // $('select[name="namefrom[]"]').change(function() {
          //     var i = 1;
          //     var finalresult = [];
          //     if ($(this).val() != '') {
          //       $("#action" + i).val('Partially Split & Merge').trigger('change');
          //     }
          //      else  {
          //       $("#action" + i).val('').trigger('change');
          //     }
          //     });

          // code changed by bheema
          if ($("#flagof").val() == "true") {
            $('select[name="namefrom[]"]').change(function () {
              var i = 1;

              if ($(this).val() != "") {
                $("#action" + i)
                  .val("Partially Split & Merge")
                  .trigger("change");
              } else {
                $("#action" + i)
                  .val("")
                  .trigger("change");
              }
            });
          }

          $("#action1,#actiona2").children().remove();
          $("#action1,#actiona2").append(
            $("<option>", {
              value: "",
              text: "Select Action",
            })
          );
          $(JSON.parse(finalresult[1])).each(function () {
            $("#action1,#actiona2").append(
              $("<option>", {
                value: this.forreaddetails,
                text: this.forreaddetails,
              })
            );
          });

          // // Reset Sub district

          // if($('#flagof').val()=='true')
          // {
          // $('#selected_come').val(fsdids).trigger('change');

          // }
          // else
          // {
          // $('#selected_come').val('').trigger('change');
          // }

          // // ends here

          // code changed for split bheema
          if (finalresult[3] == "Reshuffle") {
            $("#action1,#actiona2").val("Reshuffle").trigger("change");
          } else if (finalresult[3] == "Create") {
            $("#action1,#actiona2").val("Split").trigger("change");
          } else {
            $("#action1,#actiona2").val("").trigger("change");
          }

          if ($("#partiallyids1").val() == "") {
            $("#statenew1").val("").trigger("change");
          }
          // ends here jc_02
          // partially split & merge autoselect JC_02
          else {
            $("#action1,#actiona2")
              .val("Partially Split & Merge")
              .trigger("change");
          }
          //  //Bheema
          //     $('select[name="namefrom[]"]').change(function(){
          //         var i=1;

          //         if ($(this).val() != '') {
          //             $("#action" + i).val('Select Action').trigger('change');
          //             $("#fstatus" + i).val('Select Status').trigger('change');
          //         } else {
          //             $("#action" + i).val('').trigger('change');
          //             $("#fstatus" + i).val('').trigger('change');
          //         }
          //     });

          //  // ends here

          // modified by srikanth to trigger 2021 dco login
          if ($("#partiallyids1").val() == "") {
            $("#statenew1").val("").trigger("change");
          }
        } else {
          //   console.log(mul[1]);
          $("#id2021" + mul[1] + "")
            .children()
            .remove();

          $("#id2021" + mul[1] + "").append(
            $("<option>", {
              value: "",
              text: "Select " + seleted + "",
            })
          );
          var arr = $('select[name="namefrom[]"] option:selected')
            .map(function () {
              return this.value; // $(this).val()
            })
            .get();

          var filtered = arr.filter(function (el) {
            return el != null && el != "";
          });
          $(JSON.parse(finalresult[0])).each(function () {
            if ($.inArray(this.id, filtered) == -1) {
              $("#id2021" + mul[1] + "").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            }
          });

          $("#id2021" + mul[1] + "")
            .val("")
            .trigger("change");

          $("#action" + mul[1] + "")
            .children()
            .remove();
          $("#action" + mul[1] + "").append(
            $("<option>", {
              value: "",
              text: "Select Action",
            })
          );

          $(JSON.parse(finalresult[1])).each(function () {
            $("#action" + mul[1] + "").append(
              $("<option>", {
                value: this.forreaddetails,
                text: this.forreaddetails,
              })
            );
          });

          if (finalresult[3] == "Reshuffle") {
            $("#action" + mul[1] + "")
              .val("Reshuffle")
              .trigger("change");
          } else if (finalresult[3] == "Create") {
            $("#action" + mul[1] + "")
              .val("")
              .trigger("change");
          } else {
            $("#action" + mul[1] + "")
              .val("")
              .trigger("change");
          }

          $("#statenew1").val("").trigger("change");
        }
      }
    } else {
      // console.log(finalresult);

      if (seleted != "State") {
        if (
          (finalresult[3] == "Create" || finalresult[3] == "Merge") &&
          finalresult[2] == "District"
        ) {
          $("#subdistrictstatus").css("display", "block");
          $("#subdistrictget").prop("required", true);
          $("#subdistrictget").children().remove();
          $("#subdistrictget").append(
            $("<option>", {
              value: "",
              text: "Select Sub-District",
            })
          );
          // $("#action1,#actiona2").children().remove();

          $(JSON.parse(finalresult[0])).each(function () {
            $("#subdistrictget").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });
          //$('#subdistrictget').val('').trigger('change');
          //$('#addbtu').css("display", "none");

          // $('#villagestatus').css("display", "none");
          // $("#villagestatus").prop('required',false);
          // $("#villageget").children().remove();
        } else if (
          (finalresult[3] == "Create" ||
            finalresult[3] == "Merge" ||
            finalresult[3] == "Partiallysm" ||
            finalresult[3] == "Reshuffle") &&
          finalresult[2] == "Village / Town"
        ) {
          if (mul[1] == "undefined" || mul[1] == undefined) {
            $("#sddistrictget_1").children().remove();
            $("#sddistrictget_1").append(
              $("<option>", {
                value: "",
                text: "Select Sub-District",
              })
            );
            if (data.value != "") {
              $(JSON.parse(finalresult[0])).each(function () {
                $("#sddistrictget_1").append(
                  $("<option>", {
                    value: this.id,
                    text: this.Name,
                  })
                );
              });

              if ($("#flagof").val() == "true") {
                $("#sddistrictget_1").val(fsdids).trigger("change");
              } else {
                $("#sddistrictget_1").val("").trigger("change");
              }

              //  $('#sddistrictget_1').val('').trigger('change');
            }

            // JIGGGGG
            $("#statenew1").val("").trigger("change");

            // JIGARGO

            if (finalresult[3] == "Rename" || finalresult[3] == "Addition") {
              req = "";
            } else {
              req = "required";
            }

            $("#comefromdata").html("");
            $("#comefromdata").html(
              '<select class="form-select  mainvaldata" ' +
                req +
                '  name = "namefrom[]" id="selected_come" onchange="return get_fromvalue1(this.value,1)" ><option value="">Select Village / Town</option></select>'
            );
            $("select").select2();
            $(".AC").css({ "margin-left": "" });

            $("#action1").children().remove();
            $("#action1").append(
              $("<option>", {
                value: "",
                text: "Select Action",
              })
            );

            $("#action1").val("").trigger("change");
          } else {
            $("#sddistrictget_" + mul[1] + "")
              .children()
              .remove();
            $("#sddistrictget_" + mul[1] + "").append(
              $("<option>", {
                value: "",
                text: "Select Sub-District",
              })
            );
            if (data.value != "") {
              $(JSON.parse(finalresult[0])).each(function () {
                $("#sddistrictget_" + mul[1] + "").append(
                  $("<option>", {
                    value: this.id,
                    text: this.Name,
                  })
                );
              });

              $("#sddistrictget_" + mul[1] + "")
                .val("")
                .trigger("change");
            }
            $("#did2021" + finalresult[3] + "").html("");
            $("#did2021" + mul[1] + "").html(
              '<select class="form-select selected_come" required name = "namefrom[]" id="id2021' +
                mul[1] +
                '" onchange="return get_fromvalue1(this.value,' +
                mul[1] +
                ')" ><option value="">Select Village / Town</option></select>'
            );
            $("select").select2();
            $(".ACNN" + mul[1] + "").css({ "margin-left": "" });

            $("#action" + mul[1] + "")
              .children()
              .remove();
            $("#action" + mul[1] + "").append(
              $("<option>", {
                value: "",
                text: "Select Action",
              })
            );

            $("#action" + mul[1] + "")
              .val("")
              .trigger("change");
          }
        } else {
          // if((finalresult[3]=='Create' || finalresult[3]=='Rename') && finalresult[2]=='Village / Town' )
          // {
          // $("#selected_come").prop('required',false);

          // }

          $("#subdistrictstatussub").css("display", "block");
          $("#subdistrictgetsub").prop("required", true);
          $("#subdistrictgetsub").children().remove();
          $("#subdistrictgetsub").append(
            $("<option>", {
              value: "",
              text: "Select Sub-District",
            })
          );
          //  $("#action1,#actiona2").children().remove();
          if (data.value != "") {
            $(JSON.parse(finalresult[0])).each(function () {
              $("#subdistrictgetsub").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("#subdistrictgetsub").val("").trigger("change");

            $("#addbtu,#adddataof,#let").css("display", "none");
          }
          // $('#villagestatus').css("display", "none");
          // $("#villagestatus").prop('required',false);
          // $("#villageget").children().remove();
        }
      }
    }
  });

  // }
  // else
  // {
  //   if(mul[1]=='undefined' || mul[1]==undefined)
  //                                                 {
  //                                                     $("#sddistrictget_1").children().remove();
  //                                                     $("#sddistrictget_1").append($('<option>', {
  //                                                     value: '',
  //                                                     text: 'Select Sub-District',
  //                                                     }));

  //                                                   }

  // }

  return false;
}

function get_sub_district_popup_new(data, clickpopup, i) {
  var seleted = $("#applyon").val();
  var clickpopup = $("#clickpopup").val();

  var fstids = $('select[name="fromstate[]"] option:selected')
    .map(function () {
      if (this.value != "") {
        return this.value;
      }
    })
    .get();

  var fdtids = $('select[name="districtget[]"] option:selected')
    .map(function () {
      if (this.value != "") {
        return this.value;
      }
    })
    .get();

  var fsdids = $('select[name="sddistrictget[]"] option:selected')
    .map(function () {
      if (this.value != "") {
        return this.value;
      }
    })
    .get();

  var jigs = new Array();

  $(".namefrom").each(function () {
    if ($(this).val() != "") {
      jigs.push($(this).val());
    }
  });

  //      var jigs = $('select[name="namefrom[]"] option:selected').map(function () {
  //     if(this.value!='')
  //     {
  //         return this.value;
  //     }

  // }).get();

  var fvtids = $("#fvtids").val();

  var tstids = $("#tstids").val();
  var tdtids = $("#tdtids").val();
  var tsdids = $("#tsdids").val();

  if ($("#sddistrictget_" + i + "").val() != "") {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopupsubvillagenew&comefrom=" +
        seleted +
        "&clickpopup=" +
        clickpopup +
        "&fstids=" +
        fstids +
        "&fdtids=" +
        fdtids +
        "&fsdids=" +
        fsdids +
        "&tstids=" +
        tstids +
        "&tdtids=" +
        tdtids +
        "&tsdids=" +
        tsdids +
        "&fvtids=" +
        fvtids +
        "&i=" +
        i +
        "&datavalue=" +
        data.value +
        "&jigs=" +
        jigs,
    }).done(function (result) {
      var finalresult = result.split("|");
      //  console.log(finalresult);

      if (clickpopup == "Create") {
        if (seleted == "State") {
          $("#maintitle").html("Create New - " + finalresult[2] + " / UT");
          $("#comespan").html("[Create New - " + finalresult[2] + "  / UT]");
          $("#addlable").html("Enter " + finalresult[2] + " / UT");
          $("#addlable1").html("Select " + finalresult[2] + " / UT");
          $("#name2021").attr(
            "placeholder",
            "" + finalresult[2] + " / UT Name"
          );
        } else {
          $("#maintitle").html("Create New - " + finalresult[2] + "");
          $("#comespan").html("[Create New - " + finalresult[2] + "]");
          $("#addlable").html("Enter " + finalresult[2] + "");
          $("#addlable1").html("Select " + finalresult[2] + "");
          $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
        }
      } else if (clickpopup == "Partiallysm") {
        if (seleted == "State") {
          $("#maintitle").html(
            "Partially Split & Merge - " + finalresult[2] + " / UT"
          );

          $("#comespan").html(
            "[Partially Split & Merge - " + finalresult[2] + " / UT]"
          );
          $("#addlable").html("Enter " + finalresult[2] + " / UT");
          $("#addlable1").html("Select " + finalresult[2] + " / UT");
          $("#name2021").attr(
            "placeholder",
            "" + finalresult[2] + " / UT Name"
          );
        } else {
          $("#maintitle").html(
            "Partially Split & Merge " + finalresult[2] + ""
          );

          $("#comespan").html(
            "[Partially Split & Merge " + finalresult[2] + "]"
          );
          $("#addlable").html("Select " + finalresult[2] + "");
          $("#addlable1").html("Select " + finalresult[2] + "");
          $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
        }
        //    $("#maintitle").html("Partially Split & Merge "+finalresult[2]+"");

        // $("#comespan").html("[Partially Split & Merge "+finalresult[2]+"]");
        // $("#addlable").html("Enter "+finalresult[2]+"");
        // $("#addlable1").html("Select "+finalresult[2]+"");
        // $("#name2021").attr("placeholder", ""+finalresult[2]+" Name");
      } else if (clickpopup == "Reshuffle") {
        $("#maintitle").html("Move / Reshuffle " + finalresult[2] + "");

        $("#comespan").html("[Move / Reshuffle " + finalresult[2] + "]");
        $("#addlable").html("Select " + finalresult[2] + "");
        $("#addlable1").html("Select " + finalresult[2] + "");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
      } else {
        if (seleted == "State") {
          $("#maintitle").html(
            "Merge / Partially Merge - " + finalresult[2] + " / UT"
          );
          $("#comespan").html(
            "[Merge / Partially Merge - " + finalresult[2] + "  / UT]"
          );
          $("#addlable").html("Select " + finalresult[2] + " / UT");
          $("#addlable1").html("Select " + finalresult[2] + " / UT");
          $("#name2021").attr(
            "placeholder",
            "" + finalresult[2] + " / UT Name"
          );
        } else {
          $("#maintitle").html(
            "Merge / Partially Merge - " + finalresult[2] + ""
          );

          $("#comespan").html(
            "[Merge / Partially Merge - " + finalresult[2] + "]"
          );
          $("#addlable").html("Select " + finalresult[2] + "");
          $("#addlable1").html("Select " + finalresult[2] + "");
          $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
        }
      }

      if (finalresult[2] == "Village / Town") {
        if (i != 1) {
          var idscount = i;

          $("#did2021" + i + "").html("");
          $("#did2021" + i + "").html(finalresult[3]);

          $(".AC").css("margin-left", "16%");
          // $('.haveapartially').prop("disabled", true);
          $("#id2021" + i + "").multiSelect({
            selectableHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function (t) {
              var e = this,
                n = e.$selectableUl.prev(),
                a = e.$selectionUl.prev(),
                i =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selectable:not(.ms-selected)",
                s =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selection.ms-selected";
              (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
                if (40 === t.which) return e.$selectableUl.focus(), !1;
              })),
                (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                  if (40 == t.which) return e.$selectionUl.focus(), !1;
                }));
            },
            afterSelect: function (values) {
              var check = this.$container.attr("id");
              var checkdata = check.split("_");
              var $el = $("#ms-id2021" + i + "");
              $("#totaldefultselected_" + i + "").html(
                $el.find('[class*="ms-elem-selection ms-selected"]').length
              );

              this.qs1.cache(), this.qs2.cache();
              var data = [];
              var data1 = [];
              var $el = $("#id2021" + i + "");
              $el
                .find('[class*="ms-elem-selection ms-selected"]')
                .each(function () {
                  data.push($(this).text());
                  var ii = this.id;
                  var idd = ii.split("-");
                  //  var idddata = idd[0].join("-selectable")
                  data1.push(idd[0]);
                });

              // && $.inArray( $(this).text(), data1 )!= -1

              for (var m = 0; m <= idscount; m++) {
                if (checkdata[1] != m) {
                  $("#id2021" + i + "")
                    .find('[class*="ms-elem-selectable"]')
                    .each(function () {
                      var j = this.id.split("-");
                      if (
                        $.inArray($(this).text(), data) != -1 &&
                        $.inArray(j[0], data1) != -1
                      ) {
                        $(this).addClass("disabled");
                      }
                    });
                }
              }

              if (this.qs2.matchedResultsCount != 0) {
                $("#id2021" + i + "").prop("disabled", false);
              } else {
                $("#id2021" + i + "").prop("disabled", true);
              }
            },
            afterDeselect: function () {
              var check = this.$container.attr("id");
              var checkdata = check.split("_");

              var data = [];
              // var $el=$("#selected_come");
              var $el = $("#ms-id2021" + i + "");
              $("#totaldefultselected_" + i + "").html(
                $el.find('[class*="ms-elem-selection ms-selected"]').length
              );
              $el
                .find('[class*="ms-elem-selection ms-selected"]')
                .each(function () {
                  data.push($(this).text());
                });

              for (var m = 0; m <= idscount; m++) {
                if (checkdata[1] != m) {
                  $("#id2021" + i + "")
                    .find('[class*="ms-elem-selectable"]')
                    .each(function () {
                      if ($.inArray($(this).text(), data) == -1) {
                        $(this).removeClass("disabled");
                      }
                    });
                }
              }

              this.qs1.cache(), this.qs2.cache();
              if (this.qs2.matchedResultsCount != 0) {
                $("#id2021" + i + "").prop("disabled", false);
              } else {
                $("#id2021" + i + "").prop("disabled", true);
              }
            },
          });
        } else {
          var idscount = 1;
          $("#comefromdata").html("");
          $("#comefromdata").html(finalresult[3]);

          $(".AC").css("margin-left", "auto");
          // $('.haveapartially').prop("disabled", true);
          $("#selected_come").multiSelect({
            selectableHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function (t) {
              var e = this,
                n = e.$selectableUl.prev(),
                a = e.$selectionUl.prev(),
                i =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selectable:not(.ms-selected)",
                s =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selection.ms-selected";
              (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
                if (40 === t.which) return e.$selectableUl.focus(), !1;
              })),
                (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                  if (40 == t.which) return e.$selectionUl.focus(), !1;
                }));
            },
            afterSelect: function (values) {
              var check = this.$container.attr("id");
              var checkdata = check.split("_");

              this.qs1.cache(), this.qs2.cache();
              var data = [];
              var data1 = [];
              var $el = $("#ms-selected_come");

              $("#totaldefultselected_1").html(
                $el.find('[class*="ms-elem-selection ms-selected"]').length
              );
              $el
                .find('[class*="ms-elem-selection ms-selected"]')
                .each(function () {
                  data.push($(this).text());
                  var ii = this.id;
                  var idd = ii.split("-");
                  //  var idddata = idd[0].join("-selectable")
                  data1.push(idd[0]);
                });

              // && $.inArray( $(this).text(), data1 )!= -1

              for (var m = 0; m <= idscount; m++) {
                if (checkdata[1] != m) {
                  $("#selected_come")
                    .find('[class*="ms-elem-selectable"]')
                    .each(function () {
                      var j = this.id.split("-");
                      if (
                        $.inArray($(this).text(), data) != -1 &&
                        $.inArray(j[0], data1) != -1
                      ) {
                        $(this).addClass("disabled");
                      }
                    });
                }
              }

              if (this.qs2.matchedResultsCount != 0) {
                $("#selected_come").prop("disabled", false);
              } else {
                $("#selected_come").prop("disabled", true);
              }
            },
            afterDeselect: function () {
              var check = this.$container.attr("id");
              var checkdata = check.split("_");

              var data = [];
              var $el = $("#ms-selected_come");

              $("#totaldefultselected_1").html(
                $el.find('[class*="ms-elem-selection ms-selected"]').length
              );
              $el
                .find('[class*="ms-elem-selection ms-selected"]')
                .each(function () {
                  data.push($(this).text());
                });

              for (var m = 0; m <= idscount; m++) {
                if (checkdata[1] != m) {
                  $("#selected_come")
                    .find('[class*="ms-elem-selectable"]')
                    .each(function () {
                      if ($.inArray($(this).text(), data) == -1) {
                        $(this).removeClass("disabled");
                      }
                    });
                }
              }

              this.qs1.cache(), this.qs2.cache();
              if (this.qs2.matchedResultsCount != 0) {
                $("#selected_come").prop("disabled", false);
              } else {
                $("#selected_come").prop("disabled", true);
              }
            },
          });
        }
        //   $('select[name="namefrom[]"]').change(function() {
        //     var i = 1;
        //     var finalresult = [];
        //     if ($(this).val() != '') {
        //       $("#action" + i).val('Partially Split & Merge').trigger('change');
        //       $('statenew1').val(tstids).trigger('change');
        //     }
        //      else  {
        //       $("#action" + i).val('').trigger('change');
        //     }
        //    });

        //code changed by srikanth//
        if ($("#flagof").val() == "true") {
          $('select[name="namefrom[]"]').change(function () {
            var i = 1;

            if (clickpopup == "Partiallysm" && seleted == "Village / Town") {
              if ($(this).val() != "") {
                $("#action" + i)
                  .val("Partially Split & Merge")
                  .trigger("change");
              } else {
                $("#action" + i)
                  .val("")
                  .trigger("change");
              }
            }
          });
        }
      } else {
        if (i != 1) {
          $("#id2021" + i + "")
            .children()
            .remove();
          $("#id2021" + i + "").append(
            $("<option>", {
              value: "",
              text: "Select " + finalresult[2] + "",
            })
          );
          var arr = $('select[name="namefrom[]"] option:selected')
            .map(function () {
              return this.value; // $(this).val()
            })
            .get();

          var filtered = arr.filter(function (el) {
            return el != null && el != "";
          });

          $(JSON.parse(finalresult[0])).each(function () {
            if ($.inArray(this.id, filtered) == -1) {
              $("#id2021" + i + "").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            }
          });
          $("#id2021" + i + "")
            .val("")
            .trigger("change");
        } else {
          $("#selected_come").append(
            $("<option>", {
              value: "",
              text: "Select " + finalresult[2] + "",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("#selected_come").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });

          $("#selected_come").val("").trigger("change");
        }

        $("#statenew1").val("").trigger("change");
      }

      $("#action" + i + "")
        .children()
        .remove();
      $("#action" + i + "").append(
        $("<option>", {
          value: "",
          text: "Select Action",
        })
      );
      $(JSON.parse(finalresult[1])).each(function () {
        if ($("#flagof").val() == "true") {
          //  alert('innnnn');
          if (
            clickpopup == "Create" &&
            seleted == "Village / Town" &&
            this.forreaddetails == "Full Merge"
          ) {
          } else {
            $("#action" + i + "").append(
              $("<option>", {
                value: this.forreaddetails,
                text: this.forreaddetails,
              })
            );
          }
        } else {
          $("#action" + i + "").append(
            $("<option>", {
              value: this.forreaddetails,
              text: this.forreaddetails,
            })
          );
        }
      });

      if (clickpopup == "Reshuffle") {
        $("#action" + i + "")
          .val("Reshuffle")
          .trigger("change");
      } else if (clickpopup == "Create") {
        $("#action" + i + "")
          .val("Split")
          .trigger("change");
      }
      // jc_02 Partially Split & Merge autoselect
      else {
        $("#action" + i + "")
          .val("Partially Split & Merge")
          .trigger("change");
      }
      // jc_02 ends here
    });
  } else {
    $("#statenew1").val("").trigger("change");

    $("#action" + i + "")
      .children()
      .remove();
    $("#action" + i + "").append(
      $("<option>", {
        value: "",
        text: "Select Action",
      })
    );

    $("#action" + i + "")
      .val("")
      .trigger("change");
    var req = "";
    if (clickpopup == "Rename" || clickpopup == "Addition") {
      req = "";
    } else {
      req = "required";
    }

    if (i == 1) {
      // JIGARGO

      $("#comefromdata").html("");
      $("#comefromdata").html(
        '<select class="form-select  mainvaldata" ' +
          req +
          '  name = "namefrom[]" id="selected_come" onchange="return get_fromvalue1(this.value,1)" ><option value="">Select Village / Town</option></select>'
      );
      $("select").select2();
      $(".AC").css({ "margin-left": "" });
    } else {
      // JIGARGO
      $("#did2021" + i + "").html("");
      $("#did2021" + i + "").html(
        '<select class="form-select selected_come"  ' +
          req +
          ' name = "namefrom[]" id="id2021' +
          i +
          '" onchange="return get_fromvalue1(this.value,' +
          i +
          ')" ><option value="">Select Sub-District</option></select>'
      );
      $("select").select2();
      $(".ACNN" + i + "").css({ "margin-left": "" });
    }
  }

  return false;
}

function get_sub_district_popup_new_______(data, clickpopup, i) {
  var seleted = $("#applyon").val();
  var clickpopup = $("#clickpopup").val();

  // var dids = $('select[name="fromstate[]"] option:selected').map(function () {
  // return this.value;

  // }).get();

  // var districtget = $('select[name="districtget[]"] option:selected').map(function () {
  // return this.value;

  // }).get();

  // var sddistrictget = $('select[name="sddistrictget[]"] option:selected').map(function () {
  // return this.value;

  // }).get();

  var fstids = $('select[name="fromstate[]"] option:selected')
    .map(function () {
      if (this.value != "") {
        return this.value;
      }
    })
    .get();

  var fdtids = $('select[name="districtget[]"] option:selected')
    .map(function () {
      if (this.value != "") {
        return this.value;
      }
    })
    .get();

  var fsdids = $('select[name="sddistrictget[]"] option:selected')
    .map(function () {
      if (this.value != "") {
        return this.value;
      }
    })
    .get();

  var fvtids = $("#fvtids").val();

  var tstids = $("#tstids").val();
  var tdtids = $("#tdtids").val();
  var tsdids = $("#tsdids").val();

  if ($("#sddistrictget_" + i + "").val() != "") {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopupsubvillagenew&comefrom=" +
        seleted +
        "&clickpopup=" +
        clickpopup +
        "&fstids=" +
        fstids +
        "&fdtids=" +
        fdtids +
        "&fsdids=" +
        fsdids +
        "&tstids=" +
        tstids +
        "&tdtids=" +
        tdtids +
        "&tsdids=" +
        tsdids +
        "&fvtids=" +
        fvtids +
        "&i=" +
        i +
        "&datavalue=" +
        data.value,
    }).done(function (result) {
      var finalresult = result.split("|");

      if (clickpopup == "Create") {
        if (seleted == "State") {
          $("#maintitle").html("Create New - " + finalresult[2] + " / UT");
          $("#comespan").html("[Create New - " + finalresult[2] + "  / UT]");
          $("#addlable").html("Enter " + finalresult[2] + " / UT");
          $("#addlable1").html("Select " + finalresult[2] + " / UT");
          $("#name2021").attr(
            "placeholder",
            "" + finalresult[2] + " / UT Name"
          );
        } else {
          $("#maintitle").html("Create New - " + finalresult[2] + "");
          $("#comespan").html("[Create New - " + finalresult[2] + "]");
          $("#addlable").html("Enter " + finalresult[2] + "");
          $("#addlable1").html("Select " + finalresult[2] + "");
          $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
        }
      } else if (clickpopup == "Partiallysm") {
        if (seleted == "State") {
          $("#maintitle").html(
            "Partially Split & Merge - " + finalresult[2] + " / UT"
          );

          $("#comespan").html(
            "[Partially Split & Merge - " + finalresult[2] + " / UT]"
          );
          $("#addlable").html("Enter " + finalresult[2] + " / UT");
          $("#addlable1").html("Select " + finalresult[2] + " / UT");
          $("#name2021").attr(
            "placeholder",
            "" + finalresult[2] + " / UT Name"
          );
        } else {
          $("#maintitle").html(
            "Partially Split & Merge " + finalresult[2] + ""
          );

          $("#comespan").html(
            "[Partially Split & Merge " + finalresult[2] + "]"
          );
          $("#addlable").html("Select " + finalresult[2] + "");
          $("#addlable1").html("Select " + finalresult[2] + "");
          $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
        }
        //    $("#maintitle").html("Partially Split & Merge "+finalresult[2]+"");

        // $("#comespan").html("[Partially Split & Merge "+finalresult[2]+"]");
        // $("#addlable").html("Enter "+finalresult[2]+"");
        // $("#addlable1").html("Select "+finalresult[2]+"");
        // $("#name2021").attr("placeholder", ""+finalresult[2]+" Name");
      } else if (clickpopup == "Reshuffle") {
        $("#maintitle").html("Move / Reshuffle " + finalresult[2] + "");

        $("#comespan").html("[Move / Reshuffle " + finalresult[2] + "]");
        $("#addlable").html("Select " + finalresult[2] + "");
        $("#addlable1").html("Select " + finalresult[2] + "");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
      } else {
        if (seleted == "State") {
          $("#maintitle").html(
            "Merge / Partially Merge - " + finalresult[2] + " / UT"
          );
          $("#comespan").html(
            "[Merge / Partially Merge - " + finalresult[2] + "  / UT]"
          );
          $("#addlable").html("Select " + finalresult[2] + " / UT");
          $("#addlable1").html("Select " + finalresult[2] + " / UT");
          $("#name2021").attr(
            "placeholder",
            "" + finalresult[2] + " / UT Name"
          );
        } else {
          $("#maintitle").html(
            "Merge / Partially Merge - " + finalresult[2] + ""
          );

          $("#comespan").html(
            "[Merge / Partially Merge - " + finalresult[2] + "]"
          );
          $("#addlable").html("Select " + finalresult[2] + "");
          $("#addlable1").html("Select " + finalresult[2] + "");
          $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
        }
      }

      if (i != 1) {
        $("#id2021" + i + "")
          .children()
          .remove();
        $("#id2021" + i + "").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );
        var arr = $('select[name="namefrom[]"] option:selected')
          .map(function () {
            return this.value; // $(this).val()
          })
          .get();

        var filtered = arr.filter(function (el) {
          return el != null && el != "";
        });

        $(JSON.parse(finalresult[0])).each(function () {
          if ($.inArray(this.id, filtered) == -1) {
            $("#id2021" + i + "").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          }
        });
        $("#id2021" + i + "")
          .val("")
          .trigger("change");
      } else {
        $("#selected_come").children().remove();

        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );

        $(JSON.parse(finalresult[0])).each(function () {
          $("#selected_come").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });

        $("#selected_come").val("").trigger("change");
      }

      $("#action" + i + "")
        .children()
        .remove();
      $("#action" + i + "").append(
        $("<option>", {
          value: "",
          text: "Select Action",
        })
      );
      $(JSON.parse(finalresult[1])).each(function () {
        $("#action" + i + "").append(
          $("<option>", {
            value: this.forreaddetails,
            text: this.forreaddetails,
          })
        );
      });

      if (clickpopup == "Reshuffle") {
        $("#action" + i + "")
          .val("Reshuffle")
          .trigger("change");
      } else if (clickpopup == "Create") {
        $("#action" + i + "")
          .val("Split")
          .trigger("change");
      } else {
        $("#action" + i + "")
          .val("")
          .trigger("change");
      }
    });
  } else {
  }

  return false;
}

function getstatus(data, i) {
  var clickpopup = $("#clickpopup").val();
  if (clickpopup == "Rename") {
    // alert($('#ovstatus_'+i+'').val());

    if (data.value != "") {
      if ($("#ovstatus_" + i + "").val() == data.value) {
        $("#assignbtn").attr("disabled", true);
        $(".add_button_name").attr("disabled", true);
      } else {
        $("#assignbtn").attr("disabled", false);
        $(".add_button_name").attr("disabled", false);
      }
    } else {
      $("#assignbtn").attr("disabled", true);
      $(".add_button_name").attr("disabled", true);
    }
  } else if (clickpopup == "Deletion") {
    /// deleteion added
    // alert($('#ovstatus_'+i+'').val());
    //
    if (data.value != "") {
      if ($("#ovstatus_" + i + "").val() == data.value) {
        $("#assignbtn").attr("disabled", true);
        $(".add_button_name").attr("disabled", true);
      } else {
        //
        $("#assignbtn").attr("disabled", false);
        $(".add_button_name").attr("disabled", false);
      }
    } else {
      $("#assignbtn").attr("disabled", true);
      $(".add_button_name").attr("disabled", true);
    }
    //
    //
  }
}

function get_sub(data, i) {
  var clickpopup = $("#clickpopup").val();

  if (i != 1) {
    var vtids = $("#named2021" + i + "").val();
  } else {
    var vtids = $("#named2021").val();
  }

  var seleted = $("#applyon").val();

  $.ajax({
    type: "POST",
    url: "insert_data.php",
    data:
      "formname=get_sub&comefrom=" +
      seleted +
      "&clickpopup=" +
      clickpopup +
      "&data=" +
      data.value +
      "&i=" +
      i +
      "&vtids=" +
      vtids,
  }).done(function (result) {
    var finalresult = result.split("|");

    $("#vstatus" + i + "")
      .children()
      .remove();

    $("#vstatus" + i + "").append(
      $("<option>", {
        value: "",
        text: "Select Status",
      })
    );

    $(JSON.parse(finalresult[0])).each(function () {
      $("#vstatus" + i + "").append(
        $("<option>", {
          value: this.id,
          text: this.Name,
        })
      );
    });

    // alert($('#vStatus2021_'+i+'').val());

    if (
      $("#vStatus2021_" + i + "").val() != "" &&
      $("#vStatus2021_" + i + "").val() == "VILLAGE"
    ) {
      var jj = "";
      if ($("#ovstatus_" + i + "").val() != "") {
        jj = $("#ovstatus_" + i + "").val();
      } else {
        jj = "RV";
      }

      $("#vstatus" + i + "")
        .val(jj)
        .trigger("change");
    }
    // town status auto fetch Srikanth
    else if (
      $("#vStatus2021_" + i + "").val() != "" &&
      $("#vStatus2021_" + i + "").val() == "TOWN"
    ) {
      var jj = "";
      if ($("#ovstatus_" + i + "").val() != "") {
        jj = $("#ovstatus_" + i + "").val();
      } else {
        jj = "/";
      }

      $("#vstatus" + i + "")
        .val(jj)
        .trigger("change");
    } else {
      $("#vstatus" + i + "")
        .val("")
        .trigger("change");
    }

    if (clickpopup == "Rename") {
      $(".add_button_name").attr("disabled", false);

      if ($("#comefromcheck").val() == "Village / Town") {
        if (i != 1) {
          var newna = $("#oremovenew" + i + "").is(":checked");
        } else {
          var newna = $("#oremovenew").is(":checked");
        }
      }

      if (data.value == $("#vlevel_" + i + "").val()) {
        if (newna == true) {
          $("#assignbtn").attr("disabled", false);
          $(".add_button_name").attr("disabled", false);
        } else {
          $("#assignbtn").attr("disabled", true);
          $(".add_button_name").attr("disabled", true);
        }
      } else {
        $("#assignbtn").attr("disabled", true);
        $(".add_button_name").attr("disabled", true);
      }
    }

    // else if(clickpopup=='Addition' && $('#name2021').val()=='')
    // {
    //     $('.add_button_name').attr('disabled', true);
    // }
  });
}

function getvtlist(data, i) {
  var seleted = $("#applyon").val();
  var clickpopup = $("#clickpopup").val();
  if (
    clickpopup == "Merge" ||
    clickpopup == "Partiallysm" ||
    clickpopup == "Rename" ||
    clickpopup == "Deletion" ||
    clickpopup == "Reshuffle"
  ) {
    var fstids = $('select[name="statenew[]"] option:selected')
      .map(function () {
        if (this.value != "") {
          return this.value;
        }
      })
      .get();

    var fdtids = $('select[name="districtnew[]"] option:selected')
      .map(function () {
        if (this.value != "") {
          return this.value;
        }
      })
      .get();

    var fsdids = $('select[name="sddistrictnew[]"] option:selected')
      .map(function () {
        if (this.value != "") {
          return this.value;
        }
      })
      .get();

    var fvtids = $("#fvtids").val();

    var tstids = $("#tstids").val();
    var tdtids = $("#tdtids").val();
    var tsdids = $("#tsdids").val();

    if ($("#sddistrictnew" + i + "").val() != "") {
      $.ajax({
        type: "POST",
        url: "insert_data.php",
        data:
          "formname=getdataofpopupsubvillagenew_to&comefrom=" +
          seleted +
          "&clickpopup=" +
          clickpopup +
          "&fstids=" +
          fstids +
          "&fdtids=" +
          fdtids +
          "&fsdids=" +
          fsdids +
          "&tstids=" +
          tstids +
          "&tdtids=" +
          tdtids +
          "&tsdids=" +
          tsdids +
          "&fvtids=" +
          fvtids,
      }).done(function (result) {
        var finalresult = result.split("|");

        if (clickpopup == "Rename") {
          $("#named2021").children().remove();

          $("#named2021").append(
            $("<option>", {
              value: "",
              text: "Select " + $("#comefromcheck").val() + "",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("#named2021").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });

          $("#named2021").val("").trigger("change");
        } else {
          //         var fromdata = $('select[name="namefrom[]"] option:selected').map(function () {
          //     return this.value;

          // }).get();

          var fromdata = new Array();

          var resac = new Array();

          $('select[name="sddistrictget[]"] option:selected').map(function () {
            resac.push($(this).parent().attr("id").substring(14));
          });

          for (var i = 0; i < resac.length; i++) {
            if (resac[i] == 1) {
              $('select[name="namefrom[]"] option:selected').map(function () {
                // return this.value;
                fromdata.push(this.value);
              });
            } else {
              $(
                'select[name="namefrom' + resac[i] + '[]"] option:selected'
              ).map(function () {
                // return this.value;
                fromdata.push(this.value);
              });
            }
          }

          //   console.log(fromdata);

          if (fromdata.length > 0 && $("#flagof").val() == "false") {
            //    alert('innn');
            $("select[name*='newnamem[]']").children().remove();

            $("select[name*='newnamem[]']").append(
              $("<option>", {
                value: "",
                text: "Select " + $("#comefromcheck").val() + "",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("select[name*='newnamem[]']").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("select[name*='newnamem[]']").val("").trigger("change");

            for (var i = 0; i < fromdata.length; i++) {
              $(
                "select[name*='newnamem[]'] option[value=" + fromdata[i] + "]"
              ).remove();
            }
          } else {
            //  console.log(finalresult[0]);
            $("select[name*='newnamem[]']").children().remove();

            $("select[name*='newnamem[]']").append(
              $("<option>", {
                value: "",
                text: "Select " + $("#comefromcheck").val() + "",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("select[name*='newnamem[]']").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("select[name*='newnamem[]']").val("").trigger("change");
          }
        }
      });
    }

    return false;
  } else {
    if (clickpopup == "Addition") {
      $("#vStatus2021_" + i + "")
        .val("VILLAGE")
        .trigger("change");
    } else {
      $("#vStatus2021_" + i + "")
        .val("")
        .trigger("change");
    }
  }
}

function getvtlist_more(data, j) {
  var seleted = $("#applyon").val();
  var clickpopup = $("#clickpopup").val();
  if (
    clickpopup == "Merge" ||
    clickpopup == "Partiallysm" ||
    clickpopup == "Rename"
  ) {
    var fstids = $("#statenew" + j + "").val();

    var fdtids = $("#districtnew" + j + "").val();

    var fsdids = $("#sddistrictnew" + j + "").val();

    var fvtids = $("#fvtids").val();

    var tstids = $("#tstids").val();
    var tdtids = $("#tdtids").val();
    var tsdids = $("#tsdids").val();

    if ($("#sddistrictnew" + j + "").val() != "") {
      $.ajax({
        type: "POST",
        url: "insert_data.php",
        data:
          "formname=getdataofpopupsubvillagenew_to_more&comefrom=" +
          seleted +
          "&clickpopup=" +
          clickpopup +
          "&fstids=" +
          fstids +
          "&fdtids=" +
          fdtids +
          "&fsdids=" +
          fsdids +
          "&tstids=" +
          tstids +
          "&tdtids=" +
          tdtids +
          "&tsdids=" +
          tsdids +
          "&fvtids=" +
          fvtids,
      }).done(function (result) {
        var finalresult = result.split("|");

        if (clickpopup == "Rename") {
          var fromdata = $('select[name="newnamem[]"] option:selected')
            .map(function () {
              return this.value;
            })
            .get();
          var fromdata1 = fromdata.filter(function (el) {
            return el != null && el != "";
          });

          $("#named2021" + j + "")
            .children()
            .remove();

          $("#named2021" + j + "").append(
            $("<option>", {
              value: "",
              text: "Select " + $("#comefromcheck").val() + "",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("#named2021" + j + "").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });

          $("#named2021" + j + "")
            .val("")
            .trigger("change");

          for (var i = 0; i < fromdata1.length; i++) {
            $(
              "#named2021" + j + " option[value=" + fromdata1[i] + "]"
            ).remove();
          }
        } else {
          var fromdata = $('select[name="namefrom[]"] option:selected')
            .map(function () {
              return this.value;
            })
            .get();

          if (fromdata != "") {
            //    alert('innn');
            $("select[name*='newnamem[]']").children().remove();

            $("select[name*='newnamem[]']").append(
              $("<option>", {
                value: "",
                text: "Select " + $("#comefromcheck").val() + "",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("select[name*='newnamem[]']").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("select[name*='newnamem[]']").val("").trigger("change");
          }

          for (var i = 0; i < fromdata.length; i++) {
            $(
              "select[name*='newnamem[]'] option[value=" + fromdata[i] + "]"
            ).remove();
          }
        }
      });
    }

    return false;
  }
}

function get_sub_district_popup(data, clickpopup) {
  if (clickpopup == "Merge") {
    var seleted = $("#applyon").val();
    var dids = $("#didsmrg").val();
    var districtget = $("#districtgetmrg").val();
  } else if (clickpopup == "submerge") {
    var seleted = $("#applyon").val();
    var dids = $("#stids").val();
    var districtget = $("#districtgetsub").val();
  } else {
    var seleted = $("#applyon").val();
    var dids = $('select[name="fromstate[]"] option:selected')
      .map(function () {
        return this.value;
      })
      .get();
    var districtget = $("#districtget").val();
    //  var valueof =
  }

  if (seleted == "Village / Town") {
    if (data.value != "") {
      $("#addbtu,#adddataof,#let").css("display", "block");
      $("#addbtumrg,#adddataofmrg,#letmrg").css("display", "block");
    } else {
      $("#addbtu,#adddataof,#let").css("display", "none");
      $("#addbtumrg,#adddataofmrg,#letmrg").css("display", "none");
    }

    // $('#subdistrictstatus').css("display", "none");
    // $("#subdistrictget").prop('required',false);

    $("#villagestatus").css("display", "none");
    $("#villagestatus").prop("required", false);
  } else {
    $("#addbtu,#adddataof,#let").css("display", "none");
  }

  $.ajax({
    type: "POST",
    url: "insert_data.php",
    data:
      "formname=getdataofpopupsubvillage&comefrom=" +
      seleted +
      "&DTID=" +
      districtget +
      "&STID=" +
      dids +
      "&SDID=" +
      data.value +
      "&clickpopup=" +
      clickpopup,
  }).done(function (result) {
    var finalresult = result.split("|");
    //  console.log(finalresult);

    if (finalresult[2] == "State") {
      $("#statestatus").css("display", "block");
      $("#statestatus1").css("display", "block");
      $("#vstatestatus").css("display", "none");
      $("#vstatestatus1").css("display", "none");
      $("#vStatus2021").prop("required", false);
    } else if (finalresult[2] == "Village / Town") {
      $("#statestatus").css("display", "none");
      $("#statestatus1").css("display", "none");
      $("#vstatestatus").css("display", "block");
      if (clickpopup == "Merge") {
        $("#vstatestatus1").css("display", "none");
        $("#vStatus2021").prop("required", false);
      } else {
        $("#vstatestatus1").css("display", "block");
        $("#vStatus2021").prop("required", true);
      }
    } else {
      $("#statestatus").css("display", "none");
      $("#statestatus1").css("display", "none");
      $("#vstatestatus").css("display", "none");
      $("#vstatestatus1").css("display", "none");
      $("#vStatus2021").prop("required", false);
    }

    // $("#maintitle").html("Create New "+finalresult[2]+"");
    // $("#addlable").html("Select "+finalresult[2]+"");
    // $("#addlable1").html("Select "+finalresult[2]+"");
    // $("#name2021").attr("placeholder", ""+finalresult[2]+" Name");

    if (seleted == "State") {
      $("#maintitle").html("Create New - " + finalresult[2] + " / UT");
      $("#comespan").html("[Create New - " + finalresult[2] + "  / UT]");
      $("#addlable").html("Enter " + finalresult[2] + " / UT");
      $("#addlable1").html("Select " + finalresult[2] + " / UT");
      $("#name2021").attr("placeholder", "" + finalresult[2] + " / UT Name");
    } else {
      $("#maintitle").html("Create New - " + finalresult[2] + "");
      $("#comespan").html("[Create New - " + finalresult[2] + "]");
      $("#addlable").html("Enter " + finalresult[2] + "");
      $("#addlable1").html("Select " + finalresult[2] + "");
      $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
    }

    if (finalresult[2] == "Village / Town") {
      if (clickpopup == "Create") {
        $("#selected_come").children().remove();

        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );

        $(JSON.parse(finalresult[0])).each(function () {
          $("#selected_come").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });

        $("#selected_come").val("").trigger("change");

        $("#action1,#actiona2").children().remove();
        $("#action1,#actiona2").append(
          $("<option>", {
            value: "",
            text: "Select Action",
          })
        );
        $(JSON.parse(finalresult[1])).each(function () {
          $("#action1,#actiona2").append(
            $("<option>", {
              value: this.forreaddetails,
              text: this.forreaddetails,
            })
          );
        });

        $("#action1,#actiona2").val("").trigger("change");
      } else if (clickpopup == "submerge") {
        $("#comefromdata123").html("");
        $("#comefromdata123").html(finalresult[3]);
        $(".haveapartially").prop("disabled", true);
        $("#selected_comesub").multiSelect({
          selectableHeader:
            "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          selectionHeader:
            "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          afterInit: function (t) {
            var e = this,
              n = e.$selectableUl.prev(),
              a = e.$selectionUl.prev(),
              i =
                "#" +
                e.$container.attr("id") +
                " .ms-elem-selectable:not(.ms-selected)",
              s =
                "#" +
                e.$container.attr("id") +
                " .ms-elem-selection.ms-selected";
            (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
              if (40 === t.which) return e.$selectableUl.focus(), !1;
            })),
              (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                if (40 == t.which) return e.$selectionUl.focus(), !1;
              }));
          },
          afterSelect: function (values) {
            var check = this.$container.attr("id");
            var checkdata = check.split("_");
            this.qs1.cache(), this.qs2.cache();
            if (this.qs2.matchedResultsCount != 0) {
              $(".haveapartially").prop("disabled", false);
            } else {
              $(".haveapartially").prop("disabled", true);
            }
          },
          afterDeselect: function () {
            this.qs1.cache(), this.qs2.cache();
            if (this.qs2.matchedResultsCount != 0) {
              $(".haveapartially").prop("disabled", false);
            } else {
              $(".haveapartially").prop("disabled", true);
            }
          },
        });
      } else {
        $("#selected_comemrg").children().remove();

        $("#selected_comemrg").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );

        $(JSON.parse(finalresult[0])).each(function () {
          $("#selected_comemrg").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });
        $("#fromdata").val(finalresult[0]);
        $("#newnamemrg").val("").trigger("change");

        $("#newnamemrg").children().remove();

        $("#newnamemrg").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );

        $(JSON.parse(finalresult[0])).each(function () {
          $("#newnamemrg").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });

        $("#newnamemrg").val("").trigger("change");

        $("#actionmrg1,#actiona2").children().remove();
        $("#actionmrg1,#actiona2").append(
          $("<option>", {
            value: "",
            text: "Select Action",
          })
        );
        $(JSON.parse(finalresult[1])).each(function () {
          $("#actionmrg1,#actiona2").append(
            $("<option>", {
              value: this.forreaddetails,
              text: this.forreaddetails,
            })
          );
        });

        $("#actionmrg1,#actiona2").val("").trigger("change");
      }
    } else {
      $("#villagestatus").css("display", "block");
      $("#villagestatus").prop("required", true);
      $("#villageget").children().remove();
      $("#villageget").append(
        $("<option>", {
          value: "",
          text: "Select Village / Town",
        })
      );
      // $("#action1,#actiona2").children().remove();

      $(JSON.parse(finalresult[0])).each(function () {
        $("#villageget").append(
          $("<option>", {
            value: this.id,
            text: this.Name,
          })
        );
      });
      $("#villageget").val("").trigger("change");
      $("#addbtu,#adddataof,#let").css("display", "none");
    }
  });

  return false;
}

function get_village_popup(data) {
  var seleted = $("#applyon").val();
  var dids = $("#dids").val();
  var districtget = $("#districtget").val();
  var subdistrictget = $("#subdistrictget").val();

  if (data.value != "") {
    $("#addbtu,#adddataof,#let").css("display", "block");
  } else {
    $("#addbtu,#adddataof,#let").css("display", "none");
  }

  $.ajax({
    type: "POST",
    url: "insert_data.php",
    data:
      "formname=getdataofpopupsubward&comefrom=" +
      seleted +
      "&DTID=" +
      districtget +
      "&STID=" +
      dids +
      "&SDID=" +
      subdistrictget +
      "&VTID=" +
      data.value,
  }).done(function (result) {
    var finalresult = result.split("|");

    if (finalresult[2] == "State") {
      $("#statestatus").css("display", "block");
      $("#statestatus1").css("display", "block");
    } else {
      $("#statestatus").css("display", "none");
      $("#statestatus1").css("display", "none");
    }

    // $("#maintitle").html("Create New "+finalresult[2]+"");
    // $("#addlable").html("Select "+finalresult[2]+"");
    // $("#addlable1").html("Select "+finalresult[2]+"");
    // $("#name2021").attr("placeholder", ""+finalresult[2]+" Name");
    if (seleted == "State") {
      $("#maintitle").html("Create New - " + finalresult[2] + " / UT");
      $("#comespan").html("[Create New - " + finalresult[2] + "  / UT]");
      $("#addlable").html("Enter " + finalresult[2] + " / UT");
      $("#addlable1").html("Select " + finalresult[2] + " / UT");
      $("#name2021").attr("placeholder", "" + finalresult[2] + " / UT Name");
    } else {
      $("#maintitle").html("Create New - " + finalresult[2] + "");
      $("#comespan").html("[Create New - " + finalresult[2] + "]");
      $("#addlable").html("Enter " + finalresult[2] + "");
      $("#addlable1").html("Select " + finalresult[2] + "");
      $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
    }

    $("#selected_come").children().remove();

    $("#selected_come").append(
      $("<option>", {
        value: "",
        text: "Select " + finalresult[2] + "",
      })
    );

    $(JSON.parse(finalresult[0])).each(function () {
      $("#selected_come").append(
        $("<option>", {
          value: this.id,
          text: this.Name,
        })
      );
    });

    $("#selected_come").val("").trigger("change");

    $("#action1,#actiona2").children().remove();
    $("#action1,#actiona2").append(
      $("<option>", {
        value: "",
        text: "Select Action",
      })
    );
    $(JSON.parse(finalresult[1])).each(function () {
      $("#action1,#actiona2").append(
        $("<option>", {
          value: this.forreaddetails,
          text: this.forreaddetails,
        })
      );
    });

    $("#action1,#actiona2").val("").trigger("change");
  });

  return false;
}
function get_district_popup_distdata_add(data, clickpopup, no) {

  var seleted = $("#applyon").val();
  if (
    (clickpopup == "Create" ||
      clickpopup == "Merge" ||
      clickpopup == "Reshuffle") &&
    data.value != ""
  ) {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopup_add&comefrom=" +
        seleted +
        "&selectstid=" +
        data.value +
        "&clickpopup=" +
        clickpopup +
        "&no=" +
        no,
    }).done(function (result) {
      var finalresult = result.split("|");
      $("#statenew1").val("").trigger("change");
      //    console.log(finalresult);
      if (
        finalresult[1] == "Sub-District" ||
        finalresult[1] == "Village / Town"
      ) {
        $("#districtget_" + finalresult[3] + "")
          .children()
          .remove();
        $("#districtget_" + finalresult[3] + "").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );

        // var arr = $('select[name="districtget[]"] option:selected').map(function () {
        //                             return this.value;  // $(this).val()
        //                             }).get();

        //                             var filtered = arr.filter(function (el) {
        //                             return el != null && el != "";
        //                             });

        $(JSON.parse(finalresult[0])).each(function () {
          // if($.inArray(this.id, filtered) == -1 && finalresult[1]=='Sub-District')
          //                                                 {
          $("#districtget_" + finalresult[3] + "").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );

          //  }
        });
        $("#districtget_" + finalresult[3] + "")
          .val("")
          .trigger("change");
        if (finalresult[1] == "Sub-District") {
          $("#did2021" + finalresult[3] + "").html("");
          $("#did2021" + finalresult[3] + "").html(
            '<select class="form-select selected_come" required name = "namefrom[]" id="id2021' +
              finalresult[3] +
              '" onchange="return get_fromvalue1(this.value,' +
              finalresult[3] +
              ')" ><option value="">Select Sub-District</option></select>'
          );
          $("select").select2();
          $(".ACNN" + finalresult[3] + "").css({ "margin-left": "" });
        } else {
          $("#did2021" + finalresult[3] + "").html("");
          $("#did2021" + finalresult[3] + "").html(
            '<select class="form-select selected_come" required name = "namefrom[]" id="id2021' +
              finalresult[3] +
              '" onchange="return get_fromvalue1(this.value,' +
              finalresult[3] +
              ')" ><option value="">Select Village / Town</option></select>'
          );
          $("select").select2();
          $(".ACNN" + finalresult[3] + "").css({ "margin-left": "" });
        }
      } else {
        $("#id2021" + finalresult[3] + "")
          .children()
          .remove();
        $("#id2021" + finalresult[3] + "").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );
        var arr = $('select[name="namefrom[]"] option:selected')
          .map(function () {
            return this.value; // $(this).val()
          })
          .get();

        var filtered = arr.filter(function (el) {
          return el != null && el != "";
        });

        $(JSON.parse(finalresult[0])).each(function () {
          if (
            $.inArray(this.id, filtered) == -1 &&
            finalresult[1] == "District"
          ) {
            $("#id2021" + finalresult[3] + "").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          }
          //                             else
          //                             {
          //                                  $("#id2021"+finalresult[3]+"").append($('<option>', {
          // value: this.id,
          // text: this.Name,
          // }));
          //                             }
        });
        $("#id2021" + finalresult[3] + "")
          .val("")
          .trigger("change");
      }
    });
  }
  // JC_104 Modified by Arul for district refresh in M/PM
   else if(clickpopup == "Merge" && data.value === "" && seleted == "District"){
    $("#id2021" + no + "")
          .children()
          .remove();
        $("#id2021" + no + "").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );
        $("#id2021" + no + "")
        .val("")
        .trigger("change");
        $("#action" + no + "")
        .val("")
        .trigger("change");
   }
}

function get_district_popupto_ii(data, clickpopup, i) {
  var seleted = $("#applyon").val();
  if (
    (clickpopup == "Create" ||
      clickpopup == "Addition" ||
      clickpopup == "Rename") &&
    data.value != ""
  ) {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopup_to&comefrom=" +
        seleted +
        "&selectstid=" +
        data.value +
        "&clickpopup=" +
        clickpopup,
    }).done(function (result) {
      var finalresult = result.split("|");
      //    console.log(finalresult);

      if (finalresult[1] == "Sub-District") {
        $("#districtnew" + i + "")
          .children()
          .remove();
        $("#districtnew" + i + "").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );

        var arr = $('select[name="districtnew[]"] option:selected')
          .map(function () {
            return this.value; // $(this).val()
          })
          .get();

        var filtered = arr.filter(function (el) {
          return el != null && el != "";
        });

        $(JSON.parse(finalresult[0])).each(function () {
          // if($.inArray(this.id, filtered) == -1)
          //                                   {
          $("#districtnew" + i + "").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
          // }
        });
        $("#districtnew" + i + "")
          .val("")
          .trigger("change");
      } else if (finalresult[1] == "Village / Town") {
        //  alert('innnnnnnnnnnn');
        $("#districtnew" + i + "")
          .children()
          .remove();
        $("#districtnew" + i + "").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );

        $(JSON.parse(finalresult[0])).each(function () {
          $("#districtnew" + i + "").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });

        $("#districtnew" + i + "")
          .val("")
          .trigger("change");
      } else {
        if (finalresult[1] != "District") {
          $("#selected_come").children().remove();
          $("#selected_come").append(
            $("<option>", {
              value: "",
              text: "Select District",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("#selected_come").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });
          $("#selected_come").val("").trigger("change");
        } else {
          if (clickpopup == "Rename") {
            var fromdata = $('select[name="newnamem[]"] option:selected')
              .map(function () {
                return this.value;
              })
              .get();
            var fromdata1 = fromdata.filter(function (el) {
              return el != null && el != "";
            });

            $("#named2021" + i + "")
              .children()
              .remove();

            $("#named2021" + i + "").append(
              $("<option>", {
                value: "",
                text: "Select " + $("#comefromcheck").val() + "",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("#named2021" + i + "").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("#named2021" + i + "")
              .val("")
              .trigger("change");

            for (var j = 0; j < fromdata1.length; j++) {
              $(
                "#named2021" + i + " option[value=" + fromdata1[j] + "]"
              ).remove();
            }
          } else {
            $("#named2021" + i + "")
              .children()
              .remove();

            $("#named2021" + i + "").append(
              $("<option>", {
                value: "",
                text: "Select " + $("#comefromcheck").val() + "",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("#named2021" + i + "").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("#named2021" + i + "")
              .val("")
              .trigger("change");
          }
        }
      }
    });
  } else {
    // $("#districtget").children().remove();
    // $("#districtget").append($('<option>', {
    // value: '',
    // text: 'Select District',
    // }));
    // $('#districtget').val('').trigger('change');
    // $("#selected_come").children().remove();
    // $("#selected_come").append($('<option>', {
    // value: '',
    // text: 'Select Sub-District',
    // }));
    // $('#selected_come').val('').trigger('change');
  }
}

function get_district_popupto(data, clickpopup, i) {
  var seleted = $("#applyon").val();
  var clickpopup = $("#clickpopup").val();
  if (
    (clickpopup == "Create" ||
      clickpopup == "Merge" ||
      clickpopup == "Partiallysm" ||
      clickpopup == "Addition" ||
      clickpopup == "Rename" ||
      clickpopup == "Deletion" ||
      clickpopup == "Reshuffle") &&
    data.value != ""
  ) {
    var fstids = $("#fstids").val();
    var fdtids = $("#fdtids").val();
    var fsdids = $("#fsdids").val();
    // console.log(fdtids);
    var tstids = $("#tstids").val();
    var tdtids = $("#tdtids").val();
    var tsdids = $("#tsdids").val();
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopup_to&comefrom=" +
        seleted +
        "&selectstid=" +
        data.value +
        "&clickpopup=" +
        clickpopup +
        "&fstids=" +
        fstids +
        "&fdtids=" +
        fdtids +
        "&fsdids=" +
        fsdids +
        "&tstids=" +
        tstids +
        "&tdtids=" +
        tdtids +
        "&tsdids=" +
        tsdids,
    }).done(function (result) {
      var finalresult = result.split("|");
      // console.log(finalresult);

      if (finalresult[1] == "Sub-District") {
        if (clickpopup == "Reshuffle") {
          var fromdata = $('select[name="districtget[]"] option:selected')
            .map(function () {
              return this.value;
            })
            .get();

          if (fromdata != "") {
            //    alert('innn');
            $("#districtnew1").children().remove();

            $("#districtnew1").append(
              $("<option>", {
                value: "",
                text: "Select District",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("#districtnew1").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("#districtnew1").val("").trigger("change");
          }

          for (var i = 0; i < fromdata.length; i++) {
            $("#districtnew1 option[value=" + fromdata[i] + "]").remove();
          }
        } else {
          $("#districtnew1").children().remove();
          $("#districtnew1").append(
            $("<option>", {
              value: "",
              text: "Select District",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("#districtnew1").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });

          if ($("#flagof").val() == "true") {
            $("#districtnew1").val(tdtids).trigger("change");
          } else {
            $("#districtnew1").val("").trigger("change");
          }
        }
      } else if (finalresult[1] == "Village / Town") {
        //  alert('innnnnnnnnnnn');
        $("#districtnew1").children().remove();
        $("#districtnew1").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );

        $(JSON.parse(finalresult[0])).each(function () {
          $("#districtnew1").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });

        if ($("#flagof").val() == "true") {
          $("#districtnew1").val(tdtids).trigger("change");
        } else {
          $("#districtnew1").val("").trigger("change");
        }
        //  $("#districtnew1").val('').trigger('change');
      } else {
        if (finalresult[1] != "District") {
          $("#selected_come").children().remove();
          $("#selected_come").append(
            $("<option>", {
              value: "",
              text: "Select District",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("#selected_come").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });
          $("#selected_come").val("").trigger("change");
        } else {
          if (clickpopup == "Rename") {
            $("select[name*='newnamem[]']").children().remove();

            $("select[name*='newnamem[]']").append(
              $("<option>", {
                value: "",
                text: "Select " + $("#comefromcheck").val() + "",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("select[name*='newnamem[]']").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("select[name*='newnamem[]']").val("").trigger("change");
          } else {
            var fromdata = $('select[name="namefrom[]"] option:selected')
              .map(function () {
                return this.value;
              })
              .get();

            $("select[name*='newnamem[]']").children().remove();

            $("select[name*='newnamem[]']").append(
              $("<option>", {
                value: "",
                text: "Select " + $("#comefromcheck").val() + "",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("select[name*='newnamem[]']").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("select[name*='newnamem[]']").val("").trigger("change");

            for (var i = 0; i < fromdata.length; i++) {
              $(
                "select[name*='newnamem[]'] option[value=" + fromdata[i] + "]"
              ).remove();
            }
          }
        }
      }
    });
  } else {
    $("#districtnew1").children().remove();
    $("#districtnew1").append(
      $("<option>", {
        value: "",
        text: "Select District",
      })
    );

    $("#districtnew1").val("").trigger("change");

    
    
    // JC_104 Modified by Arul for district refresh in M/PM
    if(clickpopup === "Merge" && data.value === "" && seleted === "District"){
    $("select[name*='newnamem[]']").children().remove();
    
    $("select[name*='newnamem[]']").append(
      $("<option>", {
        value: "",
        text: "Select " + $("#comefromcheck").val() + "",
      })
      );
      $("select[name*='newnamem[]']").val("").trigger("change");
    }
      // Ends...
  }
  // JC_11 Modified by Arul for M/pm Add Button
  if($('#action1').val() != ''){

    $(".add_button").prop("disabled", false);
  }
  if(clickpopup === "Merge" && data.value !== "" &&
  (seleted === "District" || seleted === "Village / Town" || seleted === "Sub-District"))
{

    $(".add_button").prop("disabled", true);
}
  // Ends...
}

function get_sddistrict_popupto_ii(data, clickpopup, i) {
  var seleted = $("#applyon").val();
  if (
    (clickpopup == "Create" ||
      clickpopup == "Addition" ||
      clickpopup == "Rename" ||
      clickpopup == "Deletion") &&
    data.value != ""
  ) {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopup_to_sd&comefrom=" +
        seleted +
        "&selectdtid=" +
        data.value +
        "&clickpopup=" +
        clickpopup,
    }).done(function (result) {
      var finalresult = result.split("|");
      // console.log(finalresult);
      // return false;
      if (finalresult[1] == "Village / Town") {
        //

        $("#sddistrictnew" + i + "")
          .children()
          .remove();
        $("#sddistrictnew" + i + "").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District",
          })
        );

        $(JSON.parse(finalresult[0])).each(function () {
          $("#sddistrictnew" + i + "").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });

        //  $('#sddistrictnew'+finalresult[3]+'').val('').trigger('change');
      } else if (finalresult[1] == "Sub-District") {
        if (clickpopup == "Rename") {
          var fromdata = $('select[name="newnamem[]"] option:selected')
            .map(function () {
              return this.value;
            })
            .get();

          var fromdata1 = fromdata.filter(function (el) {
            return el != null && el != "";
          });

          $("#named2021" + i + "")
            .children()
            .remove();

          $("#named2021" + i + "").append(
            $("<option>", {
              value: "",
              text: "Select " + $("#comefromcheck").val() + "",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("#named2021" + i + "").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });

          $("#named2021" + i + "")
            .val("")
            .trigger("change");

          for (var j = 0; j < fromdata1.length; j++) {
            $(
              "#named2021" + i + " option[value=" + fromdata1[j] + "]"
            ).remove();
          }

          //   $("select[name*='newnamem[]']").val('').trigger('change');
        } else {
          $("#named2021" + i + "")
            .children()
            .remove();

          $("#named2021" + i + "").append(
            $("<option>", {
              value: "",
              text: "Select " + $("#comefromcheck").val() + "",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("#named2021" + i + "").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });

          $("#named2021" + i + "")
            .val("")
            .trigger("change");
        }
        // $("#sddistrictnew1").children().remove();
        // $("#sddistrictnew1").append($('<option>', {
        // value: '',
        // text: 'Select Sub-District',
        // }));

        // $(JSON.parse(finalresult[0])).each(function () {
        // $("#sddistrictnew1").append($('<option>', {
        // value: this.id,
        // text: this.Name,
        // }));
        // });
        //  $('#sddistrictnew'+finalresult[3]+'').val('').trigger('change');
      } else {
        $("#selected_come").children().remove();
        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District",
          })
        );

        $(JSON.parse(finalresult[0])).each(function () {
          $("#selected_come").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });
        //  alert('innnn');
        $("#selected_come").val("").trigger("change");
      }
    });
  } else {
    $("#sddistrictnew" + i + "")
      .children()
      .remove();
    $("#sddistrictnew" + i + "").append(
      $("<option>", {
        value: "",
        text: "Select Sub-District",
      })
    );

    $("#sddistrictnew" + i + "")
      .val("")
      .trigger("change");

    // $("#selected_come").children().remove();
    // $("#selected_come").append($('<option>', {
    // value: '',
    // text: 'Select Sub-District',
    // }));

    // $('#selected_come').val('').trigger('change');
  }
}

function get_sddistrict_popupto(data, clickpopup) {
  var seleted = $("#applyon").val();
  var clickpopup = $("#clickpopup").val();
  if (
    (clickpopup == "Create" ||
      clickpopup == "Merge" ||
      clickpopup == "Partiallysm" ||
      clickpopup == "Addition" ||
      clickpopup == "Rename" ||
      clickpopup == "Deletion" ||
      clickpopup == "Reshuffle") &&
    data.value != ""
  ) {
    var fstids = $("#fstids").val();
    var fdtids = $("#fdtids").val();
    var fsdids = $("#fsdids").val();

    var tstids = $("#tstids").val();
    var tdtids = $("#tdtids").val();
    var tsdids = $("#tsdids").val();

    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopup_to_sd&comefrom=" +
        seleted +
        "&selectdtid=" +
        data.value +
        "&clickpopup=" +
        clickpopup +
        "&fstids=" +
        fstids +
        "&fdtids=" +
        fdtids +
        "&fsdids=" +
        fsdids +
        "&tstids=" +
        tstids +
        "&tdtids=" +
        tdtids +
        "&tsdids=" +
        tsdids,
    }).done(function (result) {
      var finalresult = result.split("|");
      // console.log(finalresult);
      // return false;
      if (finalresult[1] == "Village / Town") {
        //   alert('innnnnnnn');
        if (clickpopup == "Reshuffle") {
          var fromdata = $('select[name="sddistrictget[]"] option:selected')
            .map(function () {
              return this.value;
            })
            .get();

          if (fromdata != "") {
            $("#sddistrictnew1").children().remove();

            $("#sddistrictnew1").append(
              $("<option>", {
                value: "",
                text: "Select Sub-District",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("#sddistrictnew1").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("#sddistrictnew1").val("").trigger("change");

            //$("#sddistrictnew1").val('').trigger('change');
          }

          for (var i = 0; i < fromdata.length; i++) {
            $("#sddistrictnew1 option[value=" + fromdata[i] + "]").remove();
          }
        } else {
          //alert('inn');
          $("#sddistrictnew1").children().remove();
          $("#sddistrictnew1").append(
            $("<option>", {
              value: "",
              text: "Select Sub-District",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("#sddistrictnew1").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });

          // JC_38

          if ($("#flagof").val() == "true") {
            $("#sddistrictnew1").val(tsdids).trigger("change");
          } else {
            $("#sddistrictnew1").val("").trigger("change");
          }

          elseif($("#flagof").val() == "true");
          {
            //  alert(tsdids);
            $("#sddistrictnew1").val(tsdids).trigger("change");
          }
          //code changed by srikanth drop down reset
          $("#sddistrictnew1").val("").trigger("change");
        }

        //  $('#sddistrictnew'+finalresult[3]+'').val('').trigger('change');
      } else if (finalresult[1] == "Sub-District") {
        if (clickpopup == "Rename") {
          $("select[name*='newnamem[]']").children().remove();

          $("select[name*='newnamem[]']").append(
            $("<option>", {
              value: "",
              text: "Select " + $("#comefromcheck").val() + "",
            })
          );

          $(JSON.parse(finalresult[0])).each(function () {
            $("select[name*='newnamem[]']").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });

          $("select[name*='newnamem[]']").val("").trigger("change");
        } else {
          if ($("#flagof").val() == "true") {
            $("select[name*='newnamem[]']").children().remove();

            $("select[name*='newnamem[]']").append(
              $("<option>", {
                value: "",
                text: "Select " + $("#comefromcheck").val() + "",
              })
            );

            $(JSON.parse(finalresult[0])).each(function () {
              $("select[name*='newnamem[]']").append(
                $("<option>", {
                  value: this.id,
                  text: this.Name,
                })
              );
            });

            $("select[name*='newnamem[]']").val("").trigger("change");
          } else {
            var fromdata = $('select[name="namefrom[]"] option:selected')
              .map(function () {
                return this.value;
              })
              .get();

            if (fromdata != "") {
              //    alert('innn');
              $("select[name*='newnamem[]']").children().remove();

              $("select[name*='newnamem[]']").append(
                $("<option>", {
                  value: "",
                  text: "Select " + $("#comefromcheck").val() + "",
                })
              );

              $(JSON.parse(finalresult[0])).each(function () {
                $("select[name*='newnamem[]']").append(
                  $("<option>", {
                    value: this.id,
                    text: this.Name,
                  })
                );
              });

              $("select[name*='newnamem[]']").val("").trigger("change");
            }

            for (var i = 0; i < fromdata.length; i++) {
              $(
                "select[name*='newnamem[]'] option[value=" + fromdata[i] + "]"
              ).remove();
            }
          }
        }

        // $("#sddistrictnew1").children().remove();
        // $("#sddistrictnew1").append($('<option>', {
        // value: '',
        // text: 'Select Sub-District',
        // }));

        // $(JSON.parse(finalresult[0])).each(function () {
        // $("#sddistrictnew1").append($('<option>', {
        // value: this.id,
        // text: this.Name,
        // }));
        // });
        //  $('#sddistrictnew'+finalresult[3]+'').val('').trigger('change');
      } else {
        $("#selected_come").children().remove();
        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District",
          })
        );

        $(JSON.parse(finalresult[0])).each(function () {
          $("#selected_come").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });
        $("#selected_come").val("").trigger("change");
      }
    });
  } else {
    $("#sddistrictnew1").children().remove();
    $("#sddistrictnew1").append(
      $("<option>", {
        value: "",
        text: "Select Sub-District",
      })
    );

    $("#sddistrictnew1").val("").trigger("change");

    // $("#selected_come").children().remove();
    // $("#selected_come").append($('<option>', {
    // value: '',
    // text: 'Select Sub-District',
    // }));

    // $('#selected_come').val('').trigger('change');
  }
}

function get_district_popup_distdata(data, clickpopup) {
  var seleted = $("#applyon").val();
  // alert(data.value);

  var clickpopup = $("#clickpopup").val();
  // && data.value!=''
  if (
    clickpopup == "Create" ||
    clickpopup == "Merge" ||
    clickpopup == "Partiallysm" ||
    clickpopup == "Reshuffle"
  ) {
    // alert('innnn');
    var fstids = $("#fstids").val();
    var fdtids = $("#fdtids").val();
    var fsdids = $("#fsdids").val();

    var tstids = $("#tstids").val();
    var tdtids = $("#tdtids").val();
    var tsdids = $("#tsdids").val();

    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=getdataofpopup1&comefrom=" +
        seleted +
        "&selectstid=" +
        data.value +
        "&clickpopup=" +
        clickpopup +
        "&fstids=" +
        fstids +
        "&fdtids=" +
        fdtids +
        "&fsdids=" +
        fsdids +
        "&tstids=" +
        tstids +
        "&tdtids=" +
        tdtids +
        "&tsdids=" +
        tsdids,
    }).done(function (result) {
      var finalresult = result.split("|");
      //console.log(finalresult);
      // alert(finalresult[1]);
      if (finalresult[1] == "Sub-District") {
        $("#districtget").children().remove();
        $("#districtget").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );
        if (data.value != "") {
          $(JSON.parse(finalresult[0])).each(function () {
            $("#districtget").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });
        }

        if ($("#flagof").val() == "true") {
          $("#districtget").val(fdtids).trigger("change");
        } else {
          $("#districtget").val("").trigger("change");
        }

        $("#selected_come").children().remove();
        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District",
          })
        );

        $("#selected_come").val("").trigger("change");
        // modified by srikanth to trigger 2021 dco login
        if ($("#partiallyids1").val() == "") {
          $("#statenew1").val("").trigger("change");
        }
        $("#statenew1").val("").trigger("change");
      } else if (finalresult[1] == "Village / Town") {
        $("#districtget").children().remove();
        $("#districtget").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );

        if (data.value != "") {
          $(JSON.parse(finalresult[0])).each(function () {
            $("#districtget").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });
        }

        if ($("#flagof").val() == "true") {
          $("#districtget").val(fdtids).trigger("change");
        } else {
          $("#districtget").val("").trigger("change");
        }

        $("#sddistrictget_1").children().remove();
        $("#sddistrictget_1").append(
          $("<option>", {
            value: "",
            text: "Select Sub-District",
          })
        );

        $("#sddistrictget_1").val("").trigger("change");

        $("#selected_come").children().remove();
        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select " + seleted + "",
          })
        );

        $("#selected_come").val("").trigger("change");
        // JIGARGO

        // var req = '';
        // if((clickpopup=='Rename' ||  clickpopup=='Addition'))
        // {
        // req = '';
        // }
        // else
        // {
        // req = 'required';
        // }

        $("#comefromdata").html("");
        $("#comefromdata").html(
          '<select class="form-select  mainvaldata"  name = "namefrom[]" id="selected_come" onchange="return get_fromvalue1(this.value,1)" ><option value="">Select Village / Town</option></select>'
        );
        $("select").select2();
        $(".AC").css({ "margin-left": "" });

        $("#statenew1").val("").trigger("change");
      } else {
        $("#selected_come").children().remove();
        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select District",
          })
        );
        if (data.value != "") {
          $(JSON.parse(finalresult[0])).each(function () {
            $("#selected_come").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });
        }

        if ($("#flagof").val() == "true") {
          $("#selected_come").val(fdtids).trigger("change");
        } else {
          $("#selected_come").val("").trigger("change");
        }
        // modified by srikanth to trigger 2021 dco login
        if ($("#partiallyids1").val() == "") {
          $("#statenew1").val("").trigger("change");
        }
      }
    });
  } else {
    //  alert(seleted);
    $("#districtget").children().remove();
    $("#districtget").append(
      $("<option>", {
        value: "",
        text: "Select District",
      })
    );

    $("#districtget").val("").trigger("change");

    $("#sddistrictget_1").children().remove();
    $("#sddistrictget_1").append(
      $("<option>", {
        value: "",
        text: "Select Sub-District",
      })
    );

    $("#sddistrictget_1").val("").trigger("change");

    if (seleted == "Village / Town") {
      // alert('innnn');
      $("#comefromdata").html("");
      // JIGARGO

      var req = "";
      if (
        clickpopup == "Rename" ||
        clickpopup == "Addition" ||
        clickpopup == "Deletion"
      ) {
        req = "";
      } else {
        req = "required";
      }

      $("#comefromdata").html(
        '<select class="form-select  mainvaldata" ' +
          req +
          ' name = "namefrom[]" id="selected_come" onchange="return get_fromvalue1(this.value,1)" ><option value="">Select Village / Town</option></select>'
      );
      $("select").select2();
      $(".AC").css({ "margin-left": "" });
    } else {
      $("#selected_come").children().remove();
      $("#selected_come").append(
        $("<option>", {
          value: "",
          text: "Select " + seleted + "",
        })
      );

      $("#selected_come").val("").trigger("change");
    }
  }
}

function createnew(createfrom) {
  var seleted = $("#applyon").val();
  var flagof = $("#flagof").val();
  $(".add_button_name").attr("disabled", true);

  if (createfrom == "Create" || createfrom == "Addition") {
    $(".newname").css("display", "block");
    $(".newname").prop("required", true);
    $(".newnamem").css("display", "none");
    $(".newnamem").prop("required", false);
    $("#addlable").css("display", "block");
    $(".OR").css("display", "block");
    $(".ORR").css("display", "none");
    $(".ORRN").css("display", "none");
    $(".newnamecheck").prop("required", false);
  } else {
    //    if(createfrom=='Rename')
    //    {
    // $('.ORR').css("display", "none");
    // $('.ORRN').css("display", "block");
    // $('.newnamecheck').prop('required',true);
    // $('#addlable').css("display", "block");
    //  $('.OR').css("display", "none");
    //    $('.newname').css("display", "none");
    //    $(".newname").prop('required',false);
    //    $('.newnamem').css("display", "block");
    //    $(".newnamem").prop('required',true);

    //    }
    //    else
    if (createfrom == "Reshuffle") {
      $(".ORR").css("display", "none");
      $(".ORRN").css("display", "none");
      $(".newnamecheck").prop("required", false);
      $(".OR").css("display", "none");
      $("#addlable").css("display", "none");
      $(".newname").css("display", "none");
      $(".newname").prop("required", false);
      $(".newnamem").css("display", "none");
      $(".newnamem").prop("required", false);
    } else {
      $(".ORR").css("display", "block");
      $(".ORRN").css("display", "none");
      $(".newnamecheck").prop("required", false);
      $("#addlable").css("display", "block");
      $(".OR").css("display", "none");
      $(".newname").css("display", "none");
      $(".newname").prop("required", false);
      $(".newnamem").css("display", "block");
      $(".newnamem").prop("required", true);
    }
  }

  if (seleted == "District") {
    $(".ST,.DT,.SD,.AC,.OR").removeClass("col-md-2");
    $(".ST,.DT,.SD,.AC,.OR").addClass("col-md-3");

    if (createfrom == "Rename" || createfrom == "Deletion") {
      $(".ORR").css("display", "none");
      $(".ORRN").css("display", "block");
      $(".fromstate").prop("required", false);
      $(".districtstatus").prop("required", false);
      $(".sddistrictstatus").prop("required", false);
      $(".mainvaldata").prop("required", false);
      $(".actiondata").prop("required", false);
      $("#districtget").prop("required", false);
      $("#subdistrictget").prop("required", false);
      $("#villageget").prop("required", false);
      $(".newnamecheck").prop("required", true);
    } else {
      //  $('.ORR').css("display", "none");

      $(".mainvaldata").prop("required", true);
      $(".actiondata").prop("required", true);

      $(".fromstate").css("display", "block");
      $(".fromstate").prop("required", true);

      $(".districtstatus").css("display", "none");
      $(".districtstatus").prop("required", false);

      $(".sddistrictstatus").css("display", "none");
      $(".sddistrictstatus").prop("required", false);
    }

    $(".stnew").css("display", "block");
    $(".stnew").prop("required", true);

    $(".dtnew").css("display", "none");
    $(".dtnew").prop("required", false);

    $(".sdnew").css("display", "none");
    $(".sdnew").prop("required", false);

    $(".statestatus1").css("display", "none");
    $(".Statusyear").prop("required", false);

    $(".vstatestatus1").css("display", "none");
    $(".vstatestatus1").prop("required", false);

    $(".FAC").css("display", "none");
    $(".FAC").prop("required", false);

    $(".VAC").css("display", "none");
    $(".VAC1").prop("required", false);

    $("#districtget").prop("required", false);
    $("#subdistrictget").prop("required", false);
    $("#villageget").prop("required", false);
  } else if (seleted == "Sub-District") {
    $(".ST,.DT,.SD,.AC,.OR").removeClass("col-md-3");
    $(".ST,.DT,.SD,.AC,.OR").addClass("col-md-2");

    if (createfrom == "Rename" || createfrom == "Deletion") {
      //alert('innnnnnnn');
      $(".ORR").css("display", "none");
      $(".ORRN").css("display", "block");

      $(".fromstate").prop("required", false);
      $(".districtstatus").prop("required", false);
      $(".sddistrictstatus").prop("required", false);
      $(".mainvaldata").prop("required", false);
      $(".actiondata").prop("required", false);
      $("#districtget").prop("required", false);
      $("#subdistrictget").prop("required", false);
      $("#villageget").prop("required", false);
      $(".newnamecheck").prop("required", true);
      // alert('innnnnnnn2111');
    } else {
      $(".mainvaldata").prop("required", true);
      $(".actiondata").prop("required", true);

      $(".fromstate").css("display", "block");
      $(".fromstate").prop("required", true);

      $(".districtstatus").css("display", "block");
      $(".districtstatus").prop("required", true);

      $(".sddistrictstatus").css("display", "none");
      $(".sddistrictstatus").prop("required", false);
    }

    $(".stnew").css("display", "block");
    $(".stnew").prop("required", true);

    $(".dtnew").css("display", "block");
    $(".dtnew").prop("required", true);

    $(".sdnew").css("display", "none");
    $(".sdnew").prop("required", false);

    $(".statestatus1").css("display", "none");
    $(".Statusyear").prop("required", false);

    $(".vstatestatus1").css("display", "none");
    $(".vstatestatus1").prop("required", false);

    //$("#districtget").prop('required',false);
    $(".FAC").css("display", "none");
    $(".FAC").prop("required", false);

    $(".VAC").css("display", "none");
    $(".VAC1").prop("required", false);

    $("#subdistrictget").prop("required", false);
    $("#villageget").prop("required", false);
  } else if (seleted == "Village / Town") {
    $(".ST,.DT,.SD,.SD1,.VAC,.AC,.OR").removeClass("col-md-3");
    $(".ST,.DT,.SD,.SD1,.VAC,.AC,.OR").addClass("col-md-2");

    if (
      createfrom == "Addition" ||
      createfrom == "Rename" ||
      createfrom == "Deletion"
    ) {
      $(".fromstate").prop("required", false);
      $(".districtstatus").prop("required", false);
      $(".sddistrictstatus").prop("required", false);
      $(".mainvaldata").prop("required", false);
      $(".actiondata").prop("required", false);
      $("#districtget").prop("required", false);
      $("#subdistrictget").prop("required", false);
      $("#villageget").prop("required", false);

      //Deletion Code to remove with new name field modified by Rithisha
      if (createfrom != "Rename") {
        $(".ORR").css("display", "none");
      }
    } else {
      $(".mainvaldata").prop("required", true);
      $(".actiondata").prop("required", true);

      $(".fromstate").css("display", "block");
      $(".fromstate").prop("required", true);

      $(".districtstatus").css("display", "block");
      $(".districtstatus").prop("required", true);

      $(".sddistrictstatus").css("display", "block");
      $(".sddistrictstatus").prop("required", true);
    }

    $(".stnew").css("display", "block");
    $(".stnew").prop("required", true);

    $(".dtnew").css("display", "block");
    $(".dtnew").prop("required", true);

    $(".sdnew").css("display", "block");
    $(".sdnew").prop("required", true);

    $(".statestatus1").css("display", "none");
    $(".Statusyear").prop("required", false);
    if (createfrom == "Reshuffle" || createfrom == "Deletion") {
      $(".vstatestatus1").css("display", "none");
      $(".vstatestatus1").prop("required", false);
      $(".VAC").css("display", "none");
      $(".VAC1").prop("required", false);
    } else if (createfrom == "Addition") {
      $(".vstatestatus1").css("display", "block");
      $(".vstatestatus1").prop("required", true);
      $(".VAC").css("display", "block");
      $(".VAC1").prop("required", true);
    } else {
      $(".vstatestatus1").css("display", "block");
      $(".vstatestatus1").prop("required", true);
      $(".VAC").css("display", "block");
      $(".VAC1").prop("required", true);
    }

    $(".FAC").css("display", "none");
    $(".FAC").prop("required", false);
    $("#villageget").prop("required", false);
  } else {
    if (createfrom == "Rename" || createfrom == "Deletion") {
      // $(".fromstate").prop('required',false);
      // $(".districtstatus").prop('required',false);
      // $(".sddistrictstatus").prop('required',false);
      $(".mainvaldata").prop("required", false);
      $(".actiondata").prop("required", false);
      $("#districtget").prop("required", false);
      $("#subdistrictget").prop("required", false);
      $("#villageget").prop("required", false);

      $(".fromstate").css("display", "none");
      $(".fromstate").prop("required", false);

      $(".districtstatus").css("display", "none");
      $(".districtstatus").prop("required", false);

      $(".sddistrictstatus").css("display", "none");
      $(".sddistrictstatus").prop("required", false);

      $(".stnew").css("display", "none");
      $(".stnew").prop("required", false);

      $(".dtnew").css("display", "none");
      $(".dtnew").prop("required", false);

      $(".sdnew").css("display", "none");
      $(".sdnew").prop("required", false);
    } else {
      $(".fromstate").css("display", "none");
      $(".fromstate").prop("required", false);

      $(".districtstatus").css("display", "none");
      $(".districtstatus").prop("required", false);

      $(".sddistrictstatus").css("display", "none");
      $(".sddistrictstatus").prop("required", false);

      $(".stnew").css("display", "none");
      $(".stnew").prop("required", false);

      $(".dtnew").css("display", "none");
      $(".dtnew").prop("required", false);

      $(".sdnew").css("display", "none");
      $(".sdnew").prop("required", false);
    }

    if (
      createfrom == "Create" ||
      createfrom == "Merge" ||
      createfrom == "Rename"
    ) {
      $(".statestatus1").css("display", "block");
      $(".Statusyear").prop("required", true);
      if (createfrom == "Rename") {
        $(".FAC").css("display", "none");
        $(".FAC").prop("required", false);
      } else {
        $(".FAC").css("display", "block");
        $(".FAC").prop("required", true);
      }

      $(".vstatestatus1").css("display", "none");
      $(".vstatestatus1").prop("required", false);
    } else {
      $(".FAC").css("display", "none");
      $(".FAC").prop("required", false);

      $(".statestatus1").css("display", "none");
      $(".Statusyear").prop("required", false);

      $(".vstatestatus1").css("display", "none");
      $(".vstatestatus1").prop("required", false);
    }
    $(".VAC").css("display", "none");
    $(".VAC1").prop("required", false);

    $(".ST,.DT,.SD,.AC,.OR").removeClass("col-md-2");
    $(".ST,.DT,.SD,.AC,.OR").addClass("col-md-3");

    $("#districtget").prop("required", false);
    $("#subdistrictget").prop("required", false);
    $("#villageget").prop("required", false);
  }

  // var seleted = $('#applyon').val();
  // var selectstid = $('#selectstid').val();
  // var dtstname = encodeURIComponent($('#dtstname').val());

  // var dtselected = $('#dtselected').val();
  // var selectstidupdated = $('#selectstidupdated').val();
  // var sdidsselected = $('#sdidsselected').val();

  var fstids = $("#fstids").val();
  var fdtids = $("#fdtids").val();
  var fsdids = $("#fsdids").val();

  var tstids = $("#tstids").val();
  var tdtids = $("#tdtids").val();
  var tsdids = $("#tsdids").val();

  $.ajax({
    type: "POST",
    url: "insert_data.php",
    data:
      "formname=getdataofpopup&comefrom=" +
      seleted +
      "&fstids=" +
      fstids +
      "&fdtids=" +
      fdtids +
      "&fsdids=" +
      fsdids +
      "&tstids=" +
      tstids +
      "&tdtids=" +
      tdtids +
      "&tsdids=" +
      tsdids +
      "&createfrom=" +
      createfrom +
      "&clickpopup=" +
      createfrom,
  }).done(function (result) {
    var finalresult = result.split("|");

    $("#addnewdocument").modal("show");
    $("#comefromcheck").val(finalresult[2]);
    $("#clickpopup").val(createfrom);

    if (finalresult[2] == "State") {
      $("#view1").css("display", "none");
      $("#view2").css("display", "none");
    } else if (finalresult[2] == "Village / Town") {
      $("#view1").css("display", "block");
      $("#view2").css("display", "block");
      $("#view2").html(finalresult[3]);
      $("#flagof1").val(flagof);
      $("#partiallyids1").val($("#partiallyids").val());

      $("#fstids").val(fstids);
      $("#fdtids").val(fdtids);
      $("#fsdids").val(fsdids);

      $("#tstids").val(tstids);
      $("#tdtids").val(tdtids);
      $("#tsdids").val(tsdids);

      if (createfrom == "Addition") {
        $("select[name*='vStateStatus[]'] option[value='TOWN']").remove();
        $("select[name*='vStateStatus[]']").val("VILLAGE").trigger("change");
      } else {
        $("select[name*='vStateStatus[]'] option[value='TOWN']").remove();
        $("select[name*='vStateStatus[]']").append(`<option value="TOWN">
                                      Town
                                  </option>`);
      }
    } else {
      $("#view1").css("display", "block");
      $("#view2").css("display", "block");
      $("#view2").html(finalresult[3]);

      $("#fstids").val(fstids);
      $("#fdtids").val(fdtids);
      $("#fsdids").val(fsdids);

      $("#tstids").val(tstids);
      $("#tdtids").val(tdtids);
      $("#tsdids").val(tsdids);
    }

    if (createfrom == "Create" || createfrom == "Addition") {
      // $("#maintitle").html("Create New "+finalresult[2]+"");
      // $("#comespan").html("[Create New "+finalresult[2]+"]");
      // $("#addlable").html("Enter "+finalresult[2]+"");
      // $("#addlable1").html("Select "+finalresult[2]+"");
      // $("#name2021").attr("placeholder", ""+finalresult[2]+" Name");
      if (seleted == "State") {
        $("#maintitle").html("Create New - " + finalresult[2] + " / UT");
        $("#comespan").html("[Create New - " + finalresult[2] + "  / UT]");
        $("#addlable").html("Enter " + finalresult[2] + " / UT");
        $("#addlable1").html("Select " + finalresult[2] + " / UT");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " / UT Name");
      } else {
        if (createfrom == "Addition") {
          $("#maintitle").html("Add New Village(s)");
          $("#comespan").html("[Add New Village(s)]");
          $("#addlable").html("Enter Village");
          $("#addlable1").html("Select " + finalresult[2] + "");
          $("#name2021").attr("placeholder", "New Village Name");
        } else {
          $("#maintitle").html("Create New - " + finalresult[2] + "");
          $("#comespan").html("[Create New - " + finalresult[2] + "]");
          $("#addlable").html("Enter " + finalresult[2] + "");
          $("#addlable1").html("Select " + finalresult[2] + "");
          $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
        }
      }
    } else if (createfrom == "Partiallysm") {
      $("#maintitle").html("Partially Split & Merge " + finalresult[2] + "");

      $("#comespan").html("[Partially Split & Merge " + finalresult[2] + "]");
      $("#addlable").html("Select " + finalresult[2] + "");
      $("#addlable1").html("Select " + finalresult[2] + "");
      $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
    } else if (createfrom == "Rename") {
      if (seleted == "State") {
        $("#maintitle").html(
          "Rename/Status Change " + finalresult[2] + " / UT"
        );
        $("#comespan").html(
          "[Rename/Status Change " + finalresult[2] + " / UT]"
        );
        $("#addlable").html("Select " + finalresult[2] + " / UT");
        $("#addlable1").html("Select " + finalresult[2] + " / UT");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " / UT Name");
      } else if (seleted == "Village / Town") {
        $("#maintitle").html("Rename/Status Change " + finalresult[2] + "");
        $("#comespan").html("[Rename/Status Change " + finalresult[2] + "]");
        $("#addlable").html("Select " + finalresult[2] + "");
        $("#addlable1").html("Select " + finalresult[2] + "");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
      } else {
        $("#maintitle").html("Rename " + finalresult[2] + "");

        $("#comespan").html("[Rename " + finalresult[2] + "]");
        $("#addlable").html("Select " + finalresult[2] + "");
        $("#addlable1").html("Select " + finalresult[2] + "");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
      }
    }
    //deletion code added
    else if (createfrom == "Deletion") {
      if (seleted == "Village / Town") {
        $("#maintitle").html("Delete " + finalresult[2] + "");
        $("#comespan").html("[Delete" + finalresult[2] + "]");
        $("#addlable").html("Select " + finalresult[2] + "");
        $("#addlable1").html("Select " + finalresult[2] + "");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
      } else {
        $("#maintitle").html("Delete " + finalresult[2] + "");

        $("#comespan").html("[Delete " + finalresult[2] + "]");
        $("#addlable").html("Select " + finalresult[2] + "");
        $("#addlable1").html("Select " + finalresult[2] + "");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
      }
    } else if (createfrom == "Reshuffle") {
      $("#maintitle").html("Move / Reshuffle " + finalresult[2] + "");

      $("#comespan").html("[Move / Reshuffle " + finalresult[2] + "]");
      $("#addlable").html("Select " + finalresult[2] + "");
      $("#addlable1").html("Select " + finalresult[2] + "");
      $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
    } else {
      if (seleted == "State") {
        $("#maintitle").html(
          "Merge / Partially Merge - " + finalresult[2] + " / UT"
        );

        $("#comespan").html(
          "[Merge / Partially Merge - " + finalresult[2] + " / UT]"
        );
        $("#addlable").html("Select " + finalresult[2] + " / UT");
        $("#addlable1").html("Select " + finalresult[2] + " / UT");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " / UT Name");
      } else {
        $("#maintitle").html(
          "Merge / Partially Merge - " + finalresult[2] + ""
        );

        $("#comespan").html(
          "[Merge / Partially Merge - " + finalresult[2] + "]"
        );
        $("#addlable").html("Select " + finalresult[2] + "");
        $("#addlable1").html("Select " + finalresult[2] + "");
        $("#name2021").attr("placeholder", "" + finalresult[2] + " Name");
      }
    }

    if (flagof == "true") {
      $("#addbtu,#addbtut").css("display", "none");
      $("#let,#adddataof").css("display", "block");
    } else {
      //Deletion code to remove the Action on 2011 UI modified by Rithisha
      if (
        createfrom == "Create" ||
        createfrom == "Addition" ||
        createfrom == "Deletion"
      ) {
        // if(createfrom=='Create' || createfrom=='Addition')
        // if(createfrom=='Addition')
        if (createfrom == "Addition" || createfrom == "Deletion") {
          $("#addbtu,#adddataof,#let").css("display", "none");
        } else {
          $("#addbtu,#adddataof,#let").css("display", "block");
        }
        // $('#addbtut').css("display","block");

        //Deletion code to remove the Action on 2011 UI modified by Rithisha
        if (createfrom == "Deletion") {
          $("#addbtut").css("display", "none");
        } else {
          $("#addbtut").css("display", "block");
        }
      } else {
        if (createfrom == "Rename") {
          $("#addbtu,#adddataof,#let").css("display", "none");
          $("#addbtut").css("display", "block");
        } else {
          $("#addbtu,#adddataof,#let").css("display", "block");
          $("#addbtut").css("display", "none");
        }
      }
    }

    if (finalresult[2] == "District" || finalresult[2] == "State") {
      // $('.sdnew').css("display", "none");
      //   $('#sdnew').css("display", "none");
      if (finalresult[2] == "District") {
        // return false;

        $(".stnew").css("display", "block");
        $("#stnew").css("display", "block");
        $("#stnewdrop").css("display", "block");
        $(".dtnew").css("display", "none");
        $("#dtnew").css("display", "none");
        $("#dtnewdrop").css("display", "none");

        if (finalresult[8] != "") {
          $("#statenew1").children().remove();

          $("#statenew1").append(
            $("<option>", {
              value: "",
              text: "Select State / UT",
            })
          );

          $(JSON.parse(finalresult[8])).each(function () {
            $("#statenew1").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });
          //  JC_38

          if (flagof == "true") {
            $("#statenew1").val(tstids).trigger("change");
          } else {
            $("#statenew1").val(finalresult[9]).trigger("change");
          }

          // modified by srikanth to trigger 2021 dco login

          if (createfrom == "Rename") {
            $("#statenew1").val(finalresult[9]).trigger("change");
          }
          //code changed by bheema
          else {
            $('select[name="namefrom[]"]').change(function () {
              var i = 1;
              var finalresult = [];
              if ($(this).val() != "") {
                $("#action" + i)
                  .val("Partially Split & Merge")
                  .trigger("change");
              } else {
                $("#action" + i)
                  .val("")
                  .trigger("change");
              }
            });
            //code changed by bheema
          }
        }
        if (finalresult[7] != "") {
          $("#fromstate1").children().remove();

          $("#fromstate1").append(
            $("<option>", {
              value: "",
              text: "Select State / UT",
            })
          );

          $(JSON.parse(finalresult[7])).each(function () {
            $("#fromstate1").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });
          if (flagof == "true") {
            $("#fromstate1").val(fstids).trigger("change");
          } else {
            $("#fromstate1").val(finalresult[9]).trigger("change");
          }
        }
      } else {
        $(".stnew").css("display", "none");
        $("#stnew").css("display", "none");
        $("#stnewdrop").css("display", "none");
        $(".dtnew").css("display", "none");
        $(".sdnew").css("display", "none");
        $("#dtnew").css("display", "none");
        $("#dtnewdrop").css("display", "none");
      }

      $("#subdistrictstatus").css("display", "none");
      $("#subdistrictget").prop("required", false);

      $("#villagestatus").css("display", "none");
      $("#villagestatus").prop("required", false);

      //   $('#addbtu,#adddataof,#let').css("display", "block");

      $("#districtstatus").css("display", "none");
      $("#districtstatusdrop").css("display", "none");
      $("#districtstatus").prop("required", false);

      // $('#sddistrictstatus').css("display", "none");
      // $('#sddistrictstatusdrop').css("display", "none");
      //  $("#sddistrictget_1").prop('required',false);

      $("#districtget").children().remove();

      $("#selected_come").children().remove();
      // Bheema
      $('select[name="namefrom[]"]').change(function () {
        var i = 1;

        if ($(this).val() != "") {
          $("#action" + i)
            .val("Select Action")
            .trigger("change");
          $("#fstatus" + i)
            .val("Select Status")
            .trigger("change");
        } else {
          $("#action" + i)
            .val("")
            .trigger("change");
          $("#fstatus" + i)
            .val("")
            .trigger("change");
        }
      });

      if (finalresult[2] == "State") {
        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + " / UT",
          })
        );
      } else {
        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );
      }

      $(JSON.parse(finalresult[0])).each(function () {
        $("#selected_come").append(
          $("<option>", {
            value: this.id,
            text: this.Name,
          })
        );
      });
      if ($("#flagof").val() == "true") {
        $("#selected_come").val(fstids).trigger("change");
      } else {
        $("#selected_come").val("").trigger("change");
      }

      if (createfrom != "Create") {
        $("#named2021").children().remove();

        if (finalresult[2] == "State") {
          $("#named2021").append(
            $("<option>", {
              value: "",
              text: "Select " + finalresult[2] + " / UT",
            })
          );
        } else {
          $("#named2021").append(
            $("<option>", {
              value: "",
              text: "Select " + finalresult[2] + "",
            })
          );
        }

        if (createfrom != "Create" && finalresult[2] != "District") {
          $(JSON.parse(finalresult[8])).each(function () {
            $("#named2021").append(
              $("<option>", {
                value: this.id,
                text: this.Name,
              })
            );
          });
        }

        $("#named2021").val("").trigger("change");
        if (createfrom != "Create" && finalresult[2] != "District") {
          $("#fromdata").val(finalresult[8]);
        }
      }

      $("#action1,#actiona2").children().remove();
      $("#action1,#actiona2").append(
        $("<option>", {
          value: "",
          text: "Select Action",
        })
      );
      $(JSON.parse(finalresult[1])).each(function () {
        $("#action1,#actiona2").append(
          $("<option>", {
            value: this.forreaddetails,
            text: this.forreaddetails,
          })
        );
      });

      if (createfrom == "Create") {
        $("#action1,#actiona2").val("Split").trigger("change");
        $(".add_button").attr("disabled", true);
      } else {
        $("#action1,#actiona2").val("").trigger("change");
      }

      if (createfrom == "Rename" && finalresult[2] == "State") {
        $("#assignbtn").attr("disabled", true);
      } else {
        $("#assignbtn").attr("disabled", false);
      }

      if (createfrom == "Rename") {
        $(".add_button_name").attr("disabled", true);
      } else {
        // if(finalresult[2]=='State')
        // {
        //     $('.add_button_name').attr('disabled', true);
        // }
      }
    } else {
      //  console.log(finalresult);

      $(".stnew").css("display", "block");
      $("#stnew").css("display", "block");
      $("#stnewdrop").css("display", "block");
      $(".dtnew").css("display", "block");
      $("#dtnew").css("display", "block");
      $("#dtnewdrop").css("display", "block");

      $("#view2").css("display", "block");
      $("#view2").html(finalresult[3]);

      $(".districtstatus").css("display", "block");
      $("#districtstatus").css("display", "block");
      $("#districtstatusdrop").css("display", "block");
      var jig = "";
      //  alert(createfrom);
      if (
        createfrom == "Addition" ||
        createfrom == "Rename" ||
        createfrom == "Deletion"
      ) {
        jig = "";
        $("#districtget").prop("required", false);
      } else {
        jig = "required";
        $("#districtget").prop("required", true);
      }

      $("#districtget").children().remove();
      $("#districtget").append(
        $("<option>", {
          value: "",
          text: "Select District",
        })
      );

      $("#districtget").val("").trigger("change");

      if (finalresult[2] == "Village / Town") {
        $("#comefromdata").html("");

        $("#comefromdata").html(
          '<select class="form-select  mainvaldata " ' +
            jig +
            ' name = "namefrom[]" id="selected_come" onchange="return get_fromvalue1(this.value,1)" ></select>'
        );
        $("select").select2();
        $(".AC").css({ "margin-left": "" });
      } else {
        $("#selected_come").children().remove();

        $("#selected_come").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );
      }

      $("#named2021").children().remove();

      $("#named2021").append(
        $("<option>", {
          value: "",
          text: "Select " + finalresult[2] + "",
        })
      );
      $("#named2021").val("").trigger("change");

      if (finalresult[8] != "") {
        $("#statenew1").children().remove();

        $("#statenew1").append(
          $("<option>", {
            value: "",
            text: "Select State / UT",
          })
        );

        $(JSON.parse(finalresult[8])).each(function () {
          $("#statenew1").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });
        if (createfrom != "Reshuffle") {
          if (finalresult[9] == "") {
            if ($("#flagof").val() == "true") {
              $("#statenew1").val(tstids).trigger("change");
            } else {
              $("#statenew1").val("").trigger("change");
            }
          } else {
            $("#statenew1").val(finalresult[9]).trigger("change");
          }
        } else {
          $("#statenew1").val("").trigger("change");
        }

        $("#fromstate1").children().remove();

        $("#fromstate1").append(
          $("<option>", {
            value: "",
            text: "Select State / UT",
          })
        );

        $(JSON.parse(finalresult[7])).each(function () {
          $("#fromstate1").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });

        if ($("#flagof").val() == "true") {
          $("#fromstate1").val(fstids).trigger("change");
        } else {
          if (finalresult[9] != "") {
            $("#fromstate1").val(finalresult[9]).trigger("change");
          } else {
            $("#fromstate1").val("").trigger("change");
          }
        }
      }

      $("#action1,#actiona2").children().remove();
      $("#action1,#actiona2").append(
        $("<option>", {
          value: "",
          text: "Select Action",
        })
      );

      $("#action1,#actiona2").val("").trigger("change");

      $("#sdidsup").val(finalresult[6]);

      $("#subdistrictstatus").css("display", "none");
      $("#subdistrictget").prop("required", false);

      $("#villagestatus").css("display", "none");
      $("#villagestatus").prop("required", false);
      //$('.add_button_name').attr('disabled', true);

      if (
        createfrom == "Rename" &&
        (finalresult[2] == "State" || finalresult[2] == "Village / Town")
      ) {
        $("#assignbtn").attr("disabled", true);
      } else {
        $("#assignbtn").attr("disabled", false);
      }
    }
  });

  return false;
}

function psmergenew(createfrom) {
  var seleted = $("#applyon").val();

  var selectstid = $("#selectstid").val();

  var dtstname = encodeURIComponent($("#dtstname").val());
  var dtselected = $("#dtselected").val();
  var selectstidupdated = $("#selectstidupdated").val();
  var sdidsselected = $("#sdidsselected").val();

  // var createfrom = createfrom;
  // alert(createfrom);

  $.ajax({
    type: "POST",
    url: "insert_data.php",
    data:
      "formname=getdataofpopup&comefrom=" +
      seleted +
      "&selectstid=" +
      selectstid +
      "&dtstname=" +
      dtstname +
      "&dtselected=" +
      dtselected +
      "&selectstidupdated=" +
      selectstidupdated +
      "&createfrom=" +
      createfrom +
      "&sdidsselected=" +
      sdidsselected,
  }).done(function (result) {
    var finalresult = result.split("|");

    $("#mergenewdocumentp").modal("show");
    $("#comefromcheckmrgp").val(finalresult[2]);

    if (finalresult[2] == "State") {
      $("#statestatusmrgp").css("display", "block");
      $("#statestatusmrgp1").css("display", "block");
      $("#viewmrgp1").css("display", "none");
      $("#viewmrgp2").css("display", "none");
      $("#didsmrgp").val(selectstid);
      $("#didsmrgnamep").val(finalresult[3]);
      $("#didsupmrgp").val(selectstidupdated);
    } else {
      $("#statestatusmrgp").css("display", "none");
      $("#statestatusmrgp1").css("display", "none");
      $("#viewmrgp1").css("display", "block");
      $("#viewmrgp2").css("display", "block");
      $("#viewmrgp2").html(finalresult[3]);
      $("#didsmrgp").val(selectstid);
      $("#didsmrgnamep").val(finalresult[3]);
      $("#didsupmrgp").val(selectstidupdated);
    }
    $("#clickbutton").val(finalresult[5]);

    $("#maintitlemrgp").html("Partially Split & Merge " + finalresult[2] + "");
    $("#addlablemrgp").html("" + finalresult[2] + " Name");
    $("#addlablemrgp1").html("" + finalresult[2] + " Name");
    //    $("#name2021").attr("placeholder", "Enter "+finalresult[2]+" Name");

    if (finalresult[2] == "District" || finalresult[2] == "State") {
      $("#subdistrictstatusmrgp").css("display", "none");
      $("#subdistrictgetmrgp").prop("required", false);

      $("#villagestatusmrgp").css("display", "none");
      $("#villagestatusmrgp").prop("required", false);

      $("#addbtumrgp,#adddataofmrgp,#letmrgp").css("display", "block");
      $("#districtstatusmrgp").css("display", "none");
      $("#districtstatusmrgp").prop("required", false);
      $("#districtgetmrgp").children().remove();

      $("#newnamemrgp").children().remove();

      var come = "";
      var dataof = "";

      if (finalresult[2] == "State") {
        come = selectstid;
        dataof = finalresult[0];
      } else {
        come = sdidsselected;
        dataof = finalresult[4];
      }
      if (finalresult[2] == "State") {
        $("#newnamemrgp").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + " / UT",
          })
        );
      } else {
        $("#newnamemrgp").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );
      }

      $(JSON.parse(dataof)).each(function () {
        $("#newnamemrgp").append(
          $("<option>", {
            value: this.id,
            text: this.Name,
          })
        );
      });

      $("#newnamemrgp").val(come).trigger("change");
      $("#newnamemrgp").attr("readonly", true);

      $("#selected_comemrgp").children().remove();
      if (finalresult[2] == "State") {
        $("#selected_comemrgp").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + " / UT",
          })
        );
      } else {
        $("#selected_comemrgp").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );
      }

      $(JSON.parse(finalresult[0])).each(function () {
        $("#selected_comemrgp").append(
          $("<option>", {
            value: this.id,
            text: this.Name,
          })
        );
      });

      $("#selected_comemrgp").val("").trigger("change");
      //  console.log(finalresult[1]);

      $("#actionmrgp1,#actionamrgp2").children().remove();

      $("#actionmrgp1,#actionamrgp2").append(
        $("<option>", {
          value: "",
          text: "Select Action",
        })
      );
      $(JSON.parse(finalresult[1])).each(function () {
        $("#actionmrgp1,#actionamrgp2").append(
          $("<option>", {
            value: this.forreaddetails,
            text: this.forreaddetails,
          })
        );
      });

      if (createfrom == "Merge") {
        $("#actionmrgp1,#actionamrgp2").val("Merge").trigger("change");
      } else {
        $("#actionmrgp1,#actionamrgp2")
          .val("Partially Split & Merge")
          .trigger("change");
      }

      // if(finalresult[2]=='State')
      // {
      //  $('.add_button_namemrg').attr('disabled', true);
      // }
    } else {
      $("#districtstatusmrgp").css("display", "block");
      $("#districtstatusmrgp").prop("required", true);
      $("#districtgetmrgp").children().remove();
      $("#districtgetmrgp").append(
        $("<option>", {
          value: "",
          text: "Select District",
        })
      );

      $(JSON.parse(finalresult[0])).each(function () {
        $("#districtgetmrgp").append(
          $("<option>", {
            value: this.id,
            text: this.Name,
          })
        );
      });

      $("#selected_comemrgp").children().remove();

      if (finalresult[2] == "State") {
        $("#selected_comemrgp").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + " / UT",
          })
        );
      } else {
        $("#selected_comemrgp").append(
          $("<option>", {
            value: "",
            text: "Select " + finalresult[2] + "",
          })
        );
      }

      if (JSON.parse(finalresult[4]).length > 0) {
        $(JSON.parse(finalresult[4])).each(function () {
          $("#selected_comemrgp").append(
            $("<option>", {
              value: this.id,
              text: this.Name,
            })
          );
        });
      }

      $("#selected_comemrgp").val("").trigger("change");

      $("#districtgetmrgp").val("").trigger("change");

      $("#subdistselectedp").val(finalresult[6]);

      $("#addbtumrgp,#adddataofmrgp,#letmrgp").css("display", "none");

      $("#subdistrictstatusmrgp").css("display", "none");
      $("#subdistrictgetmrgp").prop("required", false);

      $("#villagestatusmrgp").css("display", "none");
      $("#villagestatusmrgp").prop("required", false);
    }
  });

  return false;
}

function submerge(createfrom) {
  var seleted = $("#applyon").val();
  $.ajax({
    type: "POST",
    url: "insert_data.php",
    data: "formname=getdataofpopupsubmerge&comefrom=" + seleted,
  }).done(function (result) {
    var finalresult = result.split("|");

    $("#submergedocument").modal("show");
    $("#comefromchecksub").val(finalresult[2]);
    $("#submergedata #clickpopup").val(createfrom);

    if (finalresult[2] == "State") {
      $("#viewsub1").css("display", "none");
      $("#viewsub2").css("display", "none");
    } else {
      $("#viewsub1").css("display", "block");
      $("#viewsub2").css("display", "block");
      $("#viewsub2").html(finalresult[3]);
    }
    // $('#clickbutton').val('');

    if (finalresult[2] == "State") {
      $("#maintitlesub").html("Submerge " + finalresult[2] + " / UT");

      $("#comespansub").html("[Submerge " + finalresult[2] + " / UT]");
      $("#addlablesub").html("" + finalresult[2] + " / UT Name");
      $("#addlablesub1").html("" + finalresult[2] + " / UT Name");
    } else {
      $("#maintitlesub").html("Submerge " + finalresult[2] + "");

      $("#comespansub").html("[Submerge " + finalresult[2] + "]");
      $("#addlablesub").html("" + finalresult[2] + " Name");
      $("#addlablesub1").html("" + finalresult[2] + " Name");
    }

    if (finalresult[2] == "State") {
      $("#addbtu,#adddataof,#let").css("display", "block");

      $("#ststatussub").css("display", "none");
      $("#stategetsub").prop("required", false);

      $("#districtstatussub").css("display", "none");
      $("#districtgetsub").prop("required", false);

      $("#subdistrictstatussub").css("display", "none");
      $("#districtstatussub").prop("required", false);

      $("#villagestatus").css("display", "none");
      $("#villagestatus").prop("required", false);

      $("#comefromdata123").html("");
      $("#comefromdata123").html(finalresult[7]);
      $("#selected_comesub").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });

      // if(finalresult[2]=='State')
      // {
      //    $('.add_button_namesub').attr('disabled', true);
      // }
    } else {
      $("#addbtu,#adddataof,#let").css("display", "none");

      $("#viewsub2").css("display", "block");
      $("#viewsub2").html(finalresult[3]);

      $("#ststatussub").css("display", "block");
      $("#stategetsub").prop("required", true);

      $("#districtstatussub").css("display", "none");
      $("#districtgetsub").prop("required", false);

      $("#subdistrictstatussub").css("display", "none");
      $("#districtstatussub").prop("required", false);

      $("#stategetsub").children().remove();
      $("#stategetsub").append(
        $("<option>", {
          value: "",
          text: "Select State / UT",
        })
      );

      $(JSON.parse(finalresult[0])).each(function () {
        $("#stategetsub").append(
          $("<option>", {
            value: this.id,
            text: this.Name,
          })
        );
      });

      $("#stategetsub").val("").trigger("change");
    }
  });

  return false;
}

function get_dist_select_data_year_report(data) {
  $("#DTID").val("").trigger("change");
  $("#DTID").children().remove();
  if (data != "") {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data: "formname=getdistlistyearreport&STID=" + data,
    }).done(function (result1) {
      var dataof = result1.split("|");

      $("#DTID").append(
        $("<option>", {
          value: "",
          text: "Select District Name",
        })
      );
      $(JSON.parse(dataof[0])).each(function (k, v) {
        $("#DTID").append(
          $("<option>", {
            value: $(this)[0]["DTID"].trim(),
            text: $(this)[0]["DTName"].trim(),
          })
        );
      });

      // $("#exportdataid1").removeClass("disablemanual");
      // $("#exportdataid").attr("href", "exportcsvvillage.php?stids=" + dataof[1] + "");
      // $(".exportdataid1").attr("href", "exportcsvvillage.php?stids=" + dataof[1] + "");
    });

    return false;
  } else {
    location.reload();
  }
}

function get_document_subdist_select_data(data) {
  $("#lSDID2021").val("").trigger("change");
  $("#lSDID2021").children().remove();
  $.ajax({
    type: "POST",

    url: "insert_data.php",
    data: "formname=getsubdistlistdocument&DTID2021=" + data.value,
  }).done(function (result) {
    // alert(resultdata);
    var dataof = result.split("|");
    //   alert(data[1]);

    $("#lSDID2021").append(
      $("<option>", {
        value: "",
        text: "Select Sub Districts Name",
      })
    );

    $(JSON.parse(dataof[0])).each(function () {
      $("#lSDID2021").append(
        $("<option>", {
          value: this.SDID2021,
          text: this.SDName2021,
        })
      );
    });

    if (data.value != "") {
      $(".listcomefrom").html("Sub-Districts List 2011-2021");
      $(".listcomefrom1").html("Sub-Districts List 2021");
      $("#LKSTIDS").hide();
      $("#LKDTIDS").hide();
      $("#LKSDIDS").show();

      $("#LKSDIDS").html(dataof[1]);
      $("#linksSDID2021").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });
    } else {
      $(".listcomefrom").html("Districts List 2011-2021");
      $(".listcomefrom1").html("Districts List 2021");

      $("#LKDTIDS").show();
      $("#LKSDIDS").html("");
      $("#LKVTIDS").html("");

      $("#linkDTID2021 option:selected").each(function () {
        $(this).prop("selected", false);
      });

      $("#linkDTID2021").multiSelect("refresh");
      $("#linkDTID2021").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });
    }
    // $('#LKSTIDS').hide();
  });
  return false;
}

function get_document_village_select_data(data) {
  $.ajax({
    type: "POST",

    url: "insert_data.php",
    data: "formname=getvillagelistdocument&SDID2021=" + data.value,
  }).done(function (result) {
    if (data.value != "") {
      $(".listcomefrom").html("Village List 2011-2021");
      $(".listcomefrom1").html("Village List 2021");
      $("#LKSTIDS").hide();
      $("#LKDTIDS").hide();
      $("#LKSDIDS").hide();
      $("#LKVTIDS").show();

      $("#LKVTIDS").html(result);
      $("#linksVTID2021").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });
    } else {
      $(".listcomefrom").html("Sub-District List 2011-2021");
      $(".listcomefrom1").html("Sub-District List 2021");

      $("#LKSDIDS").show();
      $("#LKVTIDS").html("");

      $("#linkSDID2021 option:selected").each(function () {
        $(this).prop("selected", false);
      });

      $("#linkSDID2021").multiSelect("refresh");
      $("#linkSDID2021").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });
    }
    // $('#LKSTIDS').hide();
  });
  return false;
}

function get_dist_select_data(data, DTIDS) {
  //   console.log($(data).siblings('ul.parsley-errors-list').length);
  if (
    data.value != "" &&
    $(data).siblings("ul.parsley-errors-list").length > 0
  ) {
    $(data).siblings("ul.parsley-errors-list").children("li").hide();
  } else {
    $(data).siblings("ul.parsley-errors-list").children("li").show();
  }
  //  $(data).siblings('ul.parsley-errors-list').children().remove();
  //  $("#addDTID2021").children().remove();
  $("#addDTID2021").val("").trigger("change");
  $("#addDTID2021").children().remove();
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "insert_data.php",
    data: "formname=getdistlist&STID2021=" + data.value + "&DTID2021=" + DTIDS,
  }).done(function (result) {
    $("#addDTID2021").append(
      $("<option>", {
        value: "",
        text: "Select Districts Name",
      })
    );
    $(result).each(function () {
      $("#addDTID2021").append(
        $("<option>", {
          value: this.DTID2021,
          text: this.DTName2021,
        })
      );
    });
  });
  return false;
}

function getselecteddocumentredirect(dataval, comefromdoc, doctype) {
  if (comefromdoc != "") {
    window.location.href =
      "adddocument?idsdoc=" +
      dataval +
      "&come=" +
      comefromdoc +
      "&doctype=" +
      doctype;
  }
}

// modified by sahana to differentiate between document and link document
function redirectcompleted(dataval, comefromdoc, doctype) {
  if (dataval !== "") {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data:
        "formname=olddocselect&id=" +
        dataval +
        "&flag=drop&comefromdoc=" +
        comefromdoc,
    }).done(function (result) {
      var res = result.split("|");
      if (res[0] === "adddata") {
        $("#alreadydocument").modal("hide");
        if (comefromdoc === "comefromdocadd") {
          $("#addSTID2021").val(res[4]).trigger("change");
          $(".sdoc").css("display", "block");
          $(".sdoc").prop("required", true);
          $("#adddoctype").val(doctype).trigger("change");
          if (doctype === "Resolution") {
            $('#adddoctype option[value="Resolution"]').text(
              "Resolution (Link Document)"
            );
            $('#adddoctype option[value="Resolution"]').val(
              "Resolution (Link Document)"
            );
          } else if (doctype === "Clarification") {
            $('#adddoctype option[value="Clarification"]').text(
              "Clarification (Link Document)"
            );
            $('#adddoctype option[value="Clarification"]').val(
              "Clarification (Link Document)"
            );
          } else if (doctype === "Collector Letter") {
            $('#adddoctype option[value="Collector Letter"]').text(
              "Collector Letter (Link Document)"
            );
            $('#adddoctype option[value="Collector Letter"]').val(
              "Collector Letter (Link Document)"
            );
          } else if (doctype === "Others") {
            $('#adddoctype option[value="Others"]').text(
              "Others (Link Document)"
            );
            $('#adddoctype option[value="Others"]').val(
              "Others (Link Document)"
            );
            //modified by sahana to prop the text box for others
            $(".otherrmk").css("display", "block");
            $(".otherrmk").prop("required", true);
          }
          $("#selectdocumnent_releted").val(res[1]).trigger("change");
        } else {
          $("#progressbarwizard1").bootstrapWizard("next");
          $("#docids").val(res[1]);
          $("#docidssub").val(res[1]);
          $("#dtstname").val(res[3]);
          $("#selectstid").val(res[4]);
          $("#viewerlast").css("display", "block");
          $("#pdf").css("display", "block");
          if (res[5] !== "") {
            $("#backbtnnew").css("visibility", "visible");
          }
          $("#viewerlast").attr("src", res[2]);
          $("#uploadeddocument").val(res[2]);
          $("#docidsmrg").val(res[1]);
          $("#dtstnamemrg").val(res[3]);
          $("#selectstidmrg").val(res[4]);
          $("#uploadeddocumentmrg").val(res[2]);
        }
        return false;
      }
    });
  }
  return false;
}

function getselecteddocument(dataval, comefromdoc) {
  if (dataval != "") {
    $.ajax({
      type: "POST",
      url: "insert_data.php",
      data: "formname=olddocselect&id=" + dataval + "&flag=drop",
    }).done(function (result) {
      var res = result.split("|");
      // console.log(res);
      if (res[0] == "adddata") {
        $("#alreadydocument").modal("hide");

        $("#progressbarwizard1").bootstrapWizard("next");

        $("#docids").val(res[1]);
        $("#docidssub").val(res[1]);
        $("#dtstname").val(res[3]);
        $("#selectstid").val(res[4]);
        $("#viewerlast").css("display", "block");
        $("#pdf").css("display", "block");

        if (res[5] != "") {
          $("#backbtnnew").css("visibility", "visible");
        }

        $("#viewerlast").attr("src", res[2]);
        $("#uploadeddocument").val(res[2]);

        $("#docidsmrg").val(res[1]);
        $("#dtstnamemrg").val(res[3]);
        $("#selectstidmrg").val(res[4]);
        $("#uploadeddocumentmrg").val(res[2]);

        return false;
      }
    });
  }

  return false;
}

function get_subdist_select_data(data) {
  if (
    data.value != "" &&
    $(data).siblings("ul.parsley-errors-list").length > 0
  ) {
    $(data).siblings("ul.parsley-errors-list").children("li").hide();
  } else {
    $(data).siblings("ul.parsley-errors-list").children("li").show();
  }

  //  $("#addDTID2021").children().remove();
  $("#addSDID2021").val("").trigger("change");
  $("#addSDID2021").children().remove();
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "insert_data.php",
    data: "formname=getsubdistlist&DTID2021=" + data.value,
  }).done(function (result) {
    $("#addSDID2021").append(
      $("<option>", {
        value: "",
        text: "Select Sub Districts Name",
      })
    );
    $(result).each(function () {
      $("#addSDID2021").append(
        $("<option>", {
          value: this.SDID2021,
          text: this.SDName2021,
        })
      );
    });
  });
  return false;
}

function get_subdist_select_datavals(data) {
  if (
    data.value != "" &&
    $(data).siblings("ul.parsley-errors-list").length > 0
  ) {
    $(data).siblings("ul.parsley-errors-list").children("li").hide();
  } else {
    $(data).siblings("ul.parsley-errors-list").children("li").show();
  }

  $("#addVTID2021").val("").trigger("change");
  $("#addVTID2021").children().remove();
  $.ajax({
    type: "POST",
    dataType: "json",
    url: "insert_data.php",
    data: "formname=getvtlist&SDID2021=" + data.value,
  }).done(function (result) {
    $("#addVTID2021").append(
      $("<option>", {
        value: "",
        text: "Select Village / Town",
      })
    );
    $(result).each(function () {
      $("#addVTID2021").append(
        $("<option>", {
          value: this.VTID2021,
          text: this.VTName2021,
        })
      );
    });
  });
  return false;
}

function get_subdist_select_datavt(data) {
  if (
    data.value != "" &&
    $(data).siblings("ul.parsley-errors-list").length > 0
  ) {
    $(data).siblings("ul.parsley-errors-list").children("li").hide();
  } else {
    $(data).siblings("ul.parsley-errors-list").children("li").show();
  }
  return false;
}

function get_status_data(data) {
  $("#addStatus2021").val("").trigger("change");
  $("#addStatus2021").children().remove();
  if (data.value == "VILLAGE") {
    if (
      data.value != "" &&
      $(data).siblings("ul.parsley-errors-list").length > 0
    ) {
      $(data).siblings("ul.parsley-errors-list").children("li").hide();
    } else {
      $(data).siblings("ul.parsley-errors-list").children("li").show();
    }

    $("#addStatus2021").prop("disabled", true);
    $("#addStatus2021").prop("required", false);
  } else if (data.value == "TOWN") {
    if (
      data.value != "" &&
      $(data).siblings("ul.parsley-errors-list").length > 0
    ) {
      $(data).siblings("ul.parsley-errors-list").children("li").hide();
    } else {
      $(data).siblings("ul.parsley-errors-list").children("li").show();
    }
    $("#addStatus2021").prop("disabled", false);

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "insert_data.php",
      data: "formname=getstatus&Level2021=" + data.value,
    }).done(function (result) {
      $("#addStatus2021").append(
        $("<option>", {
          value: "",
          text: "Select Status",
        })
      );
      $(result).each(function () {
        $("#addStatus2021").append(
          $("<option>", {
            value: this.Status2021,
            text: this.Status2021,
          })
        );
      });
    });
    $("#addStatus2021").prop("required", true);
  } else if (data.value == "WARD") {
    if (
      data.value != "" &&
      $(data).siblings("ul.parsley-errors-list").length > 0
    ) {
      $(data).siblings("ul.parsley-errors-list").children("li").hide();
    } else {
      $(data).siblings("ul.parsley-errors-list").children("li").show();
    }

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "insert_data.php",
      data: "formname=getstatuswd&Level2021=" + data.value,
    }).done(function (result) {
      $("#addStatus2021").append(
        $("<option>", {
          value: "",
          text: "Select Status",
        })
      );
      $(result).each(function () {
        $("#addStatus2021").append(
          $("<option>", {
            value: this.Status2021,
            text: this.Status2021,
          })
        );
      });
    });
  } else {
    if (
      data.value != "" &&
      $(data).siblings("ul.parsley-errors-list").length > 0
    ) {
      $(data).siblings("ul.parsley-errors-list").children("li").hide();
    } else {
      $(data).siblings("ul.parsley-errors-list").children("li").show();
    }
  }
  return false;
}

function get_status_data_update(data) {
  $("#Status2021").val("").trigger("change");
  $("#Status2021").children().remove();
  if (data.value == "VILLAGE") {
    if (
      data.value != "" &&
      $(data).siblings("ul.parsley-errors-list").length > 0
    ) {
      $(data).siblings("ul.parsley-errors-list").children("li").hide();
    } else {
      $(data).siblings("ul.parsley-errors-list").children("li").show();
    }

    $("#Status2021").prop("disabled", true);
    $("#Status2021").prop("required", false);
  } else if (data.value == "TOWN") {
    if (
      data.value != "" &&
      $(data).siblings("ul.parsley-errors-list").length > 0
    ) {
      $(data).siblings("ul.parsley-errors-list").children("li").hide();
    } else {
      $(data).siblings("ul.parsley-errors-list").children("li").show();
    }
    $("#Status2021").prop("disabled", false);

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "insert_data.php",
      data: "formname=getstatus&Level2021=" + data.value,
    }).done(function (result) {
      $("#Status2021").append(
        $("<option>", {
          value: "",
          text: "Select Status",
        })
      );
      $(result).each(function () {
        $("#Status2021").append(
          $("<option>", {
            value: this.Status2021.trim(),
            text: this.Status2021.trim(),
          })
        );
      });
      $("#Status2021").select2().select2("val", data.Status2021.trim());
    });
    $("#Status2021").prop("required", true);
  } else if (data.value == "WARD") {
    if (
      data.value != "" &&
      $(data).siblings("ul.parsley-errors-list").length > 0
    ) {
      $(data).siblings("ul.parsley-errors-list").children("li").hide();
    } else {
      $(data).siblings("ul.parsley-errors-list").children("li").show();
    }

    $.ajax({
      type: "POST",
      dataType: "json",
      url: "insert_data.php",
      data: "formname=getstatuswd&Level2021=" + data.value,
    }).done(function (result) {
      $("#addStatus2021").append(
        $("<option>", {
          value: "",
          text: "Select Status",
        })
      );
      $(result).each(function () {
        $("#addStatus2021").append(
          $("<option>", {
            value: this.Status2021,
            text: this.Status2021,
          })
        );
      });
    });
  } else {
    if (
      data.value != "" &&
      $(data).siblings("ul.parsley-errors-list").length > 0
    ) {
      $(data).siblings("ul.parsley-errors-list").children("li").hide();
    } else {
      $(data).siblings("ul.parsley-errors-list").children("li").show();
    }
  }
  return false;
}
$(".newnamecheck").keyup(function () {
  var value = $(this).val();
  var come = $("#comefromcheck").val();
  var clickpopup = $("#clickpopup").val();

  if (clickpopup == "Rename") {
    var fromaction = $('input[name="newnamecheck[]"]')
      .map(function () {
        if (this.value != "") {
          return this.value;
        }
      })
      .get();

    if (value != "" && value.length > 0 && fromaction != "") {
      // $('.add_button').attr('disabled', true);
      $(".add_button_name").attr("disabled", false);
    } else {
      // $('.add_button').attr('disabled', false);
      $(".add_button_name").attr("disabled", true);
    }
  }
});

$("#name2021").keyup(function () {
  var value = $(this).val();
  var come = $("#comefromcheck").val();
  if (
    come == "District" ||
    come == "Sub-District" ||
    come == "Village / Town"
  ) {
    // var fromaction = document.getElementsByName('namefrom[]');
    var fromaction = $('select[name="namefrom[]"] option:selected')
      .map(function () {
        if (this.value != "") {
          return this.value;
        }
      })
      .get();

    var action = $('select[name="action[]"] option:selected')
      .map(function () {
        return this.value;
      })
      .get();

    var fromaction1 = $('select[name="action[]"]')
      .map(function () {
        if (this.value == "Full Merge") {
          return this.value;
        }
      })
      .get();

    //  alert(fromaction.length);

    if (value != "" && value.length > 0 && fromaction.length > 1) {
      if (fromaction1.length >= 1) {
        $(".add_button").attr("disabled", false);
        $(".add_button_name").attr("disabled", true);
      } else {
        if (come == "District") {
          $(".add_button").attr("disabled", false);
          $(".add_button_name").attr("disabled", true);
        } else {
          $("#row_1")
            .find("input, textarea, button, select")
            .attr("disabled", "disabled");
          $("#ms-selected_come [class*=ms-elem-selectable]").addClass(
            "disabled"
          );
          $("#ms-selected_come [class*=ms-elem-selection]").addClass(
            "disabled"
          );
          $(".add_button").attr("disabled", false);
          $(".add_button_name").attr("disabled", true);
        }
      }
    } else {
      if (value != "" && fromaction.length == 1 && fromaction1.length == 0) {
        if (action.length == 1) {
          $(".add_button").attr("disabled", true);
          $(".add_button_name").attr("disabled", false);
          $("#row_1")
            .find("input, textarea, button, select")
            .attr("disabled", "disabled");
          $("#ms-selected_come [class*=ms-elem-selectable]").addClass(
            "disabled"
          );
          $("#ms-selected_come [class*=ms-elem-selection]").addClass(
            "disabled"
          );
        } else {
          //  $('.add_button').attr('disabled', false);
          $(".add_button_name").attr("disabled", true);
        }
      } else {
        if (come == "Village / Town" && $("#clickpopup").val() == "Addition") {
          $(".add_button").attr("disabled", true);
          $(".add_button_name").attr("disabled", false);
        } else {
          $("#row_1")
            .find("input, textarea, button, select")
            .removeAttr("disabled", "disabled");
          $(".add_button").attr("disabled", false);
          $(".add_button_name").attr("disabled", true);
          $("#ms-selected_come [class*=ms-elem-selectable]").removeClass(
            "disabled"
          );
          $("#ms-selected_come [class*=ms-elem-selection]").removeClass(
            "disabled"
          );
        }
      }
    }
  }
});

function checkdataoftext(val, r) {
  var value = val;
  var come = $("#comefromcheck").val();
  if (
    come == "District" ||
    come == "Sub-District" ||
    come == "Village / Town"
  ) {
    // var fromaction = document.getElementsByName('namefrom[]');
    var fromaction = $('select[name="namefrom[]"] option:selected')
      .map(function () {
        if (this.value != "") {
          return this.value;
        }
      })
      .get();

    var fromaction1 = $('select[name="action[]"]')
      .map(function () {
        if (this.value == "Full Merge") {
          return this.value;
        }
      })
      .get();

    //  alert(fromaction.length);

    if (value != "" && value.length > 0 && fromaction.length > 1) {
      if (fromaction1.length >= 1) {
        $(".add_button").attr("disabled", false);
        $(".add_button_name").attr("disabled", true);
      } else {
        if (come == "District") {
          $(".add_button").attr("disabled", false);
          $(".add_button_name").attr("disabled", true);
        } else {
          $(".add_button").attr("disabled", false);
          $(".add_button_name").attr("disabled", true);
        }
      }
    } else {
      if (value != "" && fromaction.length == 1 && fromaction1.length == 0) {
        $(".add_button").attr("disabled", true);
        $(".add_button_name").attr("disabled", false);
        $("#ms-selected_come [class*=ms-elem-selectable]").addClass("disabled");
        $("#ms-selected_come [class*=ms-elem-selection]").addClass("disabled");
      } else {
        if (come == "Village / Town" && $("#clickpopup").val() == "Addition") {
          $(".add_button").attr("disabled", true);
          $(".add_button_name").attr("disabled", false);
        } else {
          $(".add_button").attr("disabled", false);
          $(".add_button_name").attr("disabled", true);
          $("#ms-selected_come [class*=ms-elem-selectable]").removeClass(
            "disabled"
          );
          $("#ms-selected_come [class*=ms-elem-selection]").removeClass(
            "disabled"
          );
        }
      }
    }
  }
}

// function undata(data,ids)
// {
//    console.log(data.value);
//    console.log(ids);
// }

$(".actiondata").change(function () {
  var value = $(this).val();

  var fromaction1 = $('select[name="action[]"]')
    .map(function () {
      if (this.value == "Full Merge") {
        return this.value;
      }
    })
    .get();
  if (fromaction1.length >= 1) {
    $(".add_button").attr("disabled", false);

    $(".add_button_name").attr("disabled", true);
    $(".field_wrapper_name").html("");
  }

  var toaction = document.getElementsByName("newname[]");

  if (value != "" && toaction.length == 1) {
    $(".add_button").attr("disabled", false);

    $(".add_button_name").attr("disabled", true);
  } else {
    $(".add_button").attr("disabled", true);
    $(".add_button_name").attr("disabled", false);
  }
  return false;
});

$(".Statusyear").change(function () {
  var value = $(this).val();
  var idindex = this.id;
  var i = idindex.split("_");
  
  var fromaction = document.getElementsByName("namefrom[]");
  if (value != "" && $('#fromstate1').val() !="" && $('#applyon').val() == "State" && $('#clickpopup').val() == "Create") { // Modified by Arul for JC_11
    $(".add_button").attr("disabled", true);
    
    $(".add_button_name").attr("disabled", false);
  } else {
    //$('#oremove1').attr('disabled', true);
    //    $('.field_wrapper').empty();
    $(".add_button").attr("disabled", false);
    $(".add_button_name").attr("disabled", true);
  }
  // var fromaction = $('select[name="namefrom[]"] option:selected').map(function () {
  //                  if(this.value!='')
  //                  {
  //                      return this.value;
  //                  }

  //          }).get();
  // alert($('#toStatus_'+i[1]+'').val());
  // alert(value);

  if ($("#clickpopup").val() == "Rename") {
    if (
      $("#toStatus_" + i[1] + "").val() != "" &&
      $("#toStatus_" + i[1] + "").val() != value
    ) {
      $("#assignbtn").attr("disabled", false);
      $(".add_button_name").attr("disabled", false);
    } else {
      // JIGARGOHEL
      if (i[1] == 1) {
        var status = $("#oremovenew").is(":checked");
      } else {
        var status = $("#oremovenew" + i[1] + "").is(":checked");
      }

      if (status == true) {
        $("#assignbtn").attr("disabled", false);
        $(".add_button_name").attr("disabled", false);
      } else {
        $("#assignbtn").attr("disabled", true);
        $(".add_button_name").attr("disabled", true);
      }
    }
  }
  //  alert(fromaction.length);

  return false;
});

$("#vStatus2021").change(function () {
  var value = $(this).val();
  var fromaction = document.getElementsByName("namefrom[]");

  if (value != "" && fromaction.length == 1) {
    $(".add_button").attr("disabled", true);
    $(".add_button_name").attr("disabled", false);
  } else {
    //$('#oremove1').attr('disabled', true);
    //    $('.field_wrapper').empty();
    $(".add_button").attr("disabled", false);
    $(".add_button_name").attr("disabled", true);
  }
  return false;
});

function getdata_action(valu, i) {
  if (valu.value != "") {
    var fla = "";
    var fla1 = "";
    if ($("#ostate" + i + "").val() == "ST") {
      fla = "UT";
      fla1 = "Union Territory";
    } else {
      fla = "ST";
      fla1 = "State";
    }

    //     if($('#comefromcheck').val()=='State' && $('#clickpopup').val()=='Merge' && valu.value=='Merge')
    //     {
    //        // fstatus1

    //        $("#fstatus"+i+"").val($('#ostate'+i+'').val()).trigger('change');
    //         $('#fstatus'+i+'').find("option[value='"+fla+"']").prop('disabled',false); // modified by sahana to remove freezed in status of merge
    //       //  $("#fstatus"+i+"").attr('disabled', true);
    //          $("#fstatus"+i+"").prop('required', false);
    //     }
    //     else
    //     {

    //        if($('#comefromcheck').val()=='State' && $('#clickpopup').val()=='Merge')
    //        {

    //         $('#fstatus'+i+'').find("option[value='"+fla+"']").prop('disabled',false);

    //        }

    //     }
    //    }
    //    else
    //    {
    //      $('.add_button_name').attr('disabled', true);
    //    }

    // }

    //modifiied by srikanth to hide new status 2021//
    if (
      $("#comefromcheck").val() == "State" &&
      $("#clickpopup").val() == "Merge" &&
      valu.value == "Merge"
    ) {
      $("#fstatus" + i + "").attr("disabled", true);
      $("#fstatus" + i + "").prop("required", false);
      $("#fstatus" + i + "")
        .val($("#ostate" + i + "").val())
        .trigger("change");
      $("#fstatus" + i + "")
        .find("option[value='" + fla + "']")
        .prop("disabled", false);
    } else if (
      $("#comefromcheck").val() == "State" &&
      $("#clickpopup").val() == "Merge"
    ) {
      $("#fstatus" + i + "").attr("disabled", false);
      $("#fstatus" + i + "")
        .find("option[value='" + fla + "']")
        .prop("disabled", false);
    } else {
      $(".add_button_name").attr("disabled", true);
    }
  }
}
//ends here

function handleClick(ck, i, popup) {
  var comefrom = $("#applyon").val();

  if (popup == "submerge") {
    var valueof = $('select[name="selected_comesub[]"] option:selected')
      .map(function () {
        return this.value;
      })
      .get();

    var valueoftext = $('select[name="selected_comesub[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();
  } else {
    var valueof = $('select[name="addlinksDTID' + i + '[]"] option:selected')
      .map(function () {
        return this.value;
      })
      .get();

    var valueoftext = $(
      'select[name="addlinksDTID' + i + '[]"] option:selected'
    )
      .map(function () {
        return this.text;
      })
      .get();
  }

  if (ck.checked == true) {
    var formData = new FormData();
    formData.append("formname", "selectedlistdata");
    formData.append("valueof", valueof);
    formData.append("valueoftext", valueoftext);
    formData.append("comefrom", comefrom);
    formData.append("variablename", i);
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        var res = data.split("|");

        if (popup == "submerge") {
          $("#ms-selected_comesub [class*=ms-elem-selectable]").addClass(
            "disabled"
          );
          $("#ms-selected_comesub [class*=ms-elem-selection]").addClass(
            "disabled"
          );
        } else {
          $(
            "#ms-addlinksDTID_" + res[1] + " [class*=ms-elem-selectable]"
          ).addClass("disabled");
          $(
            "#ms-addlinksDTID_" + res[1] + " [class*=ms-elem-selection]"
          ).addClass("disabled");
        }

        $("select").select2();
        $("#selectedlist" + res[1] + "").html(res[0]);
        $("#partiallylevel" + res[1] + "").prop("required", true);
        $("#partiallylevel" + res[1] + "").multiSelect({
          selectableHeader:
            "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          selectionHeader:
            "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          afterInit: function (t) {
            var e = this,
              n = e.$selectableUl.prev(),
              a = e.$selectionUl.prev(),
              i =
                "#" +
                e.$container.attr("id") +
                " .ms-elem-selectable:not(.ms-selected)",
              s =
                "#" +
                e.$container.attr("id") +
                " .ms-elem-selection.ms-selected";
            (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
              if (40 === t.which) return e.$selectableUl.focus(), !1;
            })),
              (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                if (40 == t.which) return e.$selectionUl.focus(), !1;
              }));
          },

          afterSelect: function (values) {
            var $el = $("#ms-partiallylevel" + i + "");
            $("#totaldefultselectedpar_" + i + "").html(
              $el.find('[class*="ms-elem-selection ms-selected"]').length
            );

            this.qs1.cache(), this.qs2.cache();
            if (this.qs2.matchedResultsCount != 0) {
              $(ck).prop("disabled", true);
            } else {
              $(ck).prop("disabled", false);
            }
          },

          afterDeselect: function (values) {
            var $el = $("#ms-partiallylevel" + i + "");
            $("#totaldefultselectedpar_" + i + "").html(
              $el.find('[class*="ms-elem-selection ms-selected"]').length
            );
            this.qs1.cache(), this.qs2.cache();

            if (this.qs2.matchedResultsCount != 0) {
              $(ck).prop("disabled", true);
            } else {
              $(ck).prop("disabled", false);
            }
          },
        });
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });

    return false;
  } else {
    if (popup == "submerge") {
      $("#selected_comesub").attr("disabled", false);

      $("#ms-selected_comesub [class*=ms-elem-selectable]").removeClass(
        "disabled"
      );
      $("#ms-selected_comesub [class*=ms-elem-selection]").removeClass(
        "disabled"
      );
    } else {
      $("#addlinksDTID_" + i + "").attr("disabled", false);

      $("#ms-addlinksDTID_" + i + " [class*=ms-elem-selectable]").removeClass(
        "disabled"
      );
      $("#ms-addlinksDTID_" + i + " [class*=ms-elem-selection]").removeClass(
        "disabled"
      );
      var valueofcheck = $("input:checkbox.haveapartially").each(function () {
        return $(this).val();
      });

      var ji = 0;
      for (var m = 0; m < valueofcheck.length; m++) {
        //  var get = $('#ms-addlinksDTID_'+checkdata[1]+' [class*=ms-elem-selection]').attr('id');

        //  var ids = get.split('-');
        if (i != m) {
          var data = [];
          var $el = $("#ms-addlinksDTID_" + i + "");
          $el
            .find('[class*="ms-elem-selection ms-selected"]')
            .each(function () {
              data.push($(this).text());
            });

          $("#ms-addlinksDTID_" + m + "")
            .find('[class*="ms-elem-selectable"]')
            .each(function () {
              if ($.inArray($(this).text(), data) != -1) {
                $(this).addClass("disabled");
              }
              //  data.push($(this).text() );
            });

          // $('#ms-addlinksDTID_'+m+'').find('[class*="ms-elem-selectable"]').addClass("disabled");
          //  $("#ms-addlinksDTID_"+m+" [class*=ms-elem-selectable]").addClass("disabled");
        } else {
          if (i == 0) {
            ji = ji + 1;
          } else {
            ji = m - 1;
          }

          var data = [];
          var $el = $("#ms-addlinksDTID_" + ji + "");
          $el
            .find('[class*="ms-elem-selection ms-selected"]')
            .each(function () {
              data.push($(this).text());
            });

          console.log(data);

          $("#ms-addlinksDTID_" + i + "")
            .find('[class*="ms-elem-selectable"]')
            .each(function () {
              if ($.inArray($(this).text(), data) != -1) {
                $(this).addClass("disabled");
              }
              //  data.push($(this).text() );
            });
        }
      }
    }

    $("#selectedlist" + i + "").html("");
    $("#partiallylevel" + i + "").prop("required", false);
    return false;
  }
}

// function addnewdist(values,i)
// {
//     var appenddata='';
//         appenddata = '<div class="col-md-5 mt-3"><select id="actiondata'+values+'" onchange="getactiondata(this.value,'+i+','+values+')" name="actiondata'+i+'[]"><option value="">Action</option><option value="Split">Split</option><option value="Merge">Merge</option></select></div><div class="col-md-5 mt-2 pl-0" id="actionevent'+values+'" ></div>';

//      $('#pardist'+i+'').append('<div id='+values+' class="row" >'+appenddata+'</div>');
//  $('select').select2();
//    //  return false;
// }

// function removenewdist(values,i)
// {
//     return false;
// }

function handleClickdataof(ck, i) {
  var comefrom = $("#applyon").val();

  var valueof = $('select[name="partiallylevel' + i + '[]"] option:selected')
    .map(function () {
      return this.value;
    })
    .get();

  var valueoftext = $(
    'select[name="partiallylevel' + i + '[]"] option:selected'
  )
    .map(function () {
      return this.text;
    })
    .get();

  if (ck.checked == true) {
    var formData = new FormData();
    formData.append("formname", "selectedlistdatalist");
    formData.append("valueof", valueof);
    formData.append("valueoftext", valueoftext);
    formData.append("comefrom", comefrom);
    formData.append("variablename", i);
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        var res = data.split("|");

        $("#selectedlistoflist" + res[1] + "").html(res[0]);
        $("#partiallylevelsd" + res[1] + "").multiSelect({
          selectableHeader:
            "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          selectionHeader:
            "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
          afterInit: function (t) {
            var e = this,
              n = e.$selectableUl.prev(),
              a = e.$selectionUl.prev(),
              i =
                "#" +
                e.$container.attr("id") +
                " .ms-elem-selectable:not(.ms-selected)",
              s =
                "#" +
                e.$container.attr("id") +
                " .ms-elem-selection.ms-selected";
            (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
              if (40 === t.which) return e.$selectableUl.focus(), !1;
            })),
              (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                if (40 == t.which) return e.$selectionUl.focus(), !1;
              }));
          },
          afterSelect: function (values) {
            this.qs1.cache(), this.qs2.cache();
          },
          afterDeselect: function () {
            this.qs1.cache(), this.qs2.cache();
          },
        });
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });

    return false;
  } else {
    $("#selectedlistoflist" + i + "").html("");
    return false;
  }
}

function getactiondata(thisdata, i, dist) {
  if (thisdata != "") {
    if (thisdata == "Split") {
      $("#actionevent" + dist + "").html(
        '<input type="text" id="newdist' +
          dist +
          '" name="newdist[]" class="form-control">'
      );
    } else {
    }
  } else {
    $("#actionevent" + dist + "").html("");
  }
  return false;
}

function actionoremove(valueof, x) {
  if (valueof != "") {
    var fla = "";
    var fla11 = "";
    var fla1 = "";
    if ($("#ostate" + x + "").val() == "ST") {
      fla = "UT";
      fla1 = "Union Territory";
      fla11 = "UT";
    } else {
      fla = "ST";
      fla1 = "State";
      fla11 = "ST";
    }

    if (
      $("#comefromcheck").val() == "State" &&
      $("#clickpopup").val() == "Merge" &&
      valueof == "Merge"
    ) {
      // fstatus1

      $("#fstatus" + x + "")
        .val($("#ostate" + x + "").val())
        .trigger("change");
      $("#fstatus" + x + "")
        .find("option")
        .prop("disabled", false);
      $("#fstatus" + x + "")
        .find("option[value='" + fla11 + "']")
        .prop("disabled", false); //modified by sahana to remove freezed status in merge
      //  $("#fstatus"+x+"").attr('disabled', true);
      $("#fstatus" + x + "").prop("required", false);
    } else {
      if (
        $("#comefromcheck").val() == "State" &&
        $("#clickpopup").val() == "Merge"
      ) {
        $("#fstatus" + x + "")
          .find("option[value='" + fla11 + "']")
          .prop("disabled", false); //modified by sahana in merge
      }
    }
  }

  if (valueof != "") {
    $(".add_button").attr("disabled", false);

    $("#oremove" + x + "").attr("disabled", false);
  } else {
    $(".add_button").attr("disabled", true);
    $("#oremove" + x + "").attr("disabled", true);
  }
  return false;
}

$(function () {
  // var popup = $("#jigardata-datatable").DataTable({ "order": [],"scrollX":"100%","lengthMenu": [ [10, 25, 50,100, -1], [10, 25, 50,100, "All"] ]});

  $("#units-datatable tbody").on("click", "tr td.btnlink", function (event) {
    $("a.dropdown-toggle").dropdown();
    return false;
  });

  $("#districts-units-datatable tbody").on(
    "click",
    "tr td.btnlink",
    function (event) {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#subdistricts-units-datatable tbody").on(
    "click",
    "tr td.btnlink",
    function (event) {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#villages-units-datatable tbody").on(
    "click",
    "tr td.btnlink",
    function (event) {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#wards-units-datatable tbody").on(
    "click",
    "tr td.btnlink",
    function (event) {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#submergedocument .close,#submergedocument .closepop1").on(
    "click",
    function () {
      $("#submergedata").find("form").trigger("reset");
      $("#remarksubmerge").val("");

      //   $(this)[0].reset();

      //  $('#submerge').find('form').parsley().reset();

      // $('#submerge').find('form')[0].reset();
      // $('#submerge').find('form select').select2().trigger('change');
      //  $("#selected_comesub").multiselect('refresh');

      //  location.reload();
    }
  );

  $("#assigndatamergep .close,#assigndatamergep .closepop1").on(
    "click",
    function () {
      $("#mergenewdocumentp").find("form").parsley().reset();
      $("#mergenewdocumentp").find("form")[0].reset();
      $("#mergenewdocumentp").find("form select").select2().trigger("change");
      $(".field_wrapper").children("div").remove();
      $(".field_wrapper_name").children("div").remove();

      //  location.reload();
    }
  );

  $("#addnewdocument .close,#addnewdocument .closepop1").on(
    "click",
    function () {
      $("#addnewdocument")
        .find("input, textarea, button, select")
        .removeAttr("disabled", "disabled");
      $("#addnewdocument").find("form").parsley().reset();
      $("#addnewdocument").find("form")[0].reset();
      $("#addnewdocument").find("form select").select2().trigger("change");
      $(".field_wrapper").children("div").remove();
      $(".field_wrapper_name").children("div").remove();

      //  location.reload();
    }
  );

  $("#mergenewdocument .close,#mergenewdocument .closepop1").on(
    "click",
    function () {
      $("#mergenewdocument").find("form").parsley().reset();
      $("#mergenewdocument").find("form")[0].reset();
      $("#mergenewdocument").find("form select").select2().trigger("change");

      //  location.reload();
    }
  );

  $("#units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnlink",
    function (event) {
      // $('#con-close-modal-link').modal('show');
      $("#dataids").val("");
      var data = JSON.parse(event.target.dataset.todo);

      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
      } else {
        idsofst = $("#dataids").val();
      }

      var tablejig = $("#jigardata-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinklist";
            d.STID2021 = idsofst;
          },
        },
        columnDefs: [
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },

          { targets: 6, className: "wrap" },
          {
            targets: 7,
            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[2] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
        ],

        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#dataids").val(json.data[0][2]);
          }

          $("#con-close-modal-link").modal("show");
        },
      });

      return false;
    }
  );

  $("#districts-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnlink",
    function (event) {
      // $('#con-close-modal-link').modal('show');
      $("#dataids").val("");
      var data = JSON.parse(event.target.dataset.todo);

      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
        $("#datadtids").val(data.DTID2021);
      } else {
        idsofst = $("#dataids").val();
        $("#datadtids").val("");
      }

      var tablejig = $("#jigardata-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinklist";
            d.STID2021 = idsofst;
          },
        },
        columnDefs: [
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },

          { targets: 6, className: "wrap" },
          {
            targets: 7,
            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[2] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
        ],

        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#dataids").val(json.data[0][2]);
          }

          $("#con-close-modal-link").modal("show");
        },
      });

      return false;
    }
  );
  // JIGAR LINK OPEN POPUP
  $("#subdistricts-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnlink",
    function (event) {
      $("#dataids").val("");
      var data = JSON.parse(event.target.dataset.todo);

      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
        $("#datadtids").val(data.DTID2021);
        $("#datasdids").val(data.SDID2021);
      } else {
        idsofst = $("#dataids").val();
        $("#datadtids").val("");
        $("#datasdids").val("");
      }

      var tablejig = $("#jigardata-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinklist";
            d.STID2021 = idsofst;
          },
        },
        columnDefs: [
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },

          { targets: 6, className: "wrap" },
          {
            targets: 7,
            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[2] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
        ],

        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#dataids").val(json.data[0][2]);
          }

          $("#con-close-modal-link").modal("show");
        },
      });

      return false;
    }
  );

  // JIGAR LINK OPEN POPUP
  $("#villages-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnlink",
    function (event) {
      // $('#con-close-modal-link').modal('show');
      $("#dataids").val("");
      var data = JSON.parse(event.target.dataset.todo);

      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
        $("#datadtids").val(data.DTID2021);
        $("#datasdids").val(data.SDID2021);
        $("#datavtids").val(data.VTID2021);
      } else {
        idsofst = $("#dataids").val();
        $("#datadtids").val("");
        $("#datasdids").val("");
        $("#datavtids").val("");
      }

      var tablejig = $("#jigardata-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinklist";
            d.STID2021 = idsofst;
          },
        },
        columnDefs: [
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },

          { targets: 6, className: "wrap" },
          {
            targets: 7,
            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[2] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
        ],

        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#dataids").val(json.data[0][2]);
          }

          $("#con-close-modal-link").modal("show");
        },
      });

      return false;
    }
  );

  // JIGAR LINK OPEN POPUP
  $("#wards-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnlink",
    function (event) {
      // $('#con-close-modal-link').modal('show');
      $("#dataids").val("");
      var data = JSON.parse(event.target.dataset.todo);

      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
        $("#datadtids").val(data.DTID2021);
        $("#datasdids").val(data.SDID2021);
        $("#datavtids").val(data.VTID2021);
        $("#datawdids").val(data.WDID2021);
      } else {
        idsofst = $("#dataids").val();
        $("#datadtids").val("");
        $("#datasdids").val("");
        $("#datavtids").val("");
        $("#datawdids").val("");
      }

      var tablejig = $("#jigardata-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinklist";
            d.STID2021 = idsofst;
          },
        },
        columnDefs: [
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },

          { targets: 6, className: "wrap" },
          {
            targets: 7,
            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[2] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
        ],

        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#dataids").val(json.data[0][2]);
          }

          $("#con-close-modal-link").modal("show");
        },
      });

      return false;
    }
  );

  // LINKEDJIGAR
  $("#units-datatable tbody").on(
    "click",
    "tr td.btnlinked , tr td a.btnlinked",
    function (event) {
      // $('#con-close-modal-link').modal('show');

      var data = JSON.parse(event.target.dataset.todo);
      // console.log(data);
      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
      } else {
        idsofst = $("#dataids").val();
      }

      var tablejig1 = $("#linked-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinkedlist";
            d.STID2021 = idsofst;
            d.linkedcomefrom = $("#linkedcomefrom").val();
          },
        },
        columnDefs: [
          {
            targets: 7,

            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[1] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },
          { targets: 4, className: "wrap" },
          { targets: 5, className: "wrap" },
        ],
        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#linkeddataids").val(json.data[0][2]);
          }
          $("#con-close-modal-linked").modal("show");
        },
      });

      return false;
    }
  );
  // LINKEDJIGAR
  $("#districts-units-datatable tbody").on(
    "click",
    "tr td.btnlinked , tr td a.btnlinked",
    function (event) {
      // $('#con-close-modal-link').modal('show');

      var data = JSON.parse(event.target.dataset.todo);
      //console.log(data);
      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
        idsofdt = data.DTID2021;
        $("#linkeddtdataids").val(data.DTID2021);
      } else {
        idsofst = $("#linkeddataids").val();
        idsofdt = $("#linkeddtdataids").val();
      }

      var tablejig1 = $("#linked-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinkedlist";
            d.STID2021 = idsofst;
            d.DTID2021 = idsofdt;
            d.linkedcomefrom = $("#linkedcomefrom").val();
          },
        },
        columnDefs: [
          {
            targets: 7,

            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[1] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },
          { targets: 4, className: "wrap" },
          { targets: 5, className: "wrap" },
        ],
        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#linkeddataids").val(json.data[0][2]);
          }
          $("#con-close-modal-linked").modal("show");
        },
      });

      return false;
    }
  );
  // LINKEDJIGAR
  $("#subdistricts-units-datatable tbody").on(
    "click",
    "tr td.btnlinked , tr td a.btnlinked",
    function (event) {
      // $('#con-close-modal-link').modal('show');

      var data = JSON.parse(event.target.dataset.todo);
      //console.log(data);
      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
        idsofdt = data.DTID2021;
        idsofsd = data.SDID2021;
        $("#linkeddtdataids").val(data.DTID2021);
        $("#linkedsddataids").val(data.SDID2021);
      } else {
        idsofst = $("#linkeddataids").val();
        idsofdt = $("#linkeddtdataids").val();
        idsofsd = $("#linkedsddataids").val();
      }

      var tablejig1 = $("#linked-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinkedlist";
            d.STID2021 = idsofst;
            d.DTID2021 = idsofdt;
            d.SDID2021 = idsofsd;
            d.linkedcomefrom = $("#linkedcomefrom").val();
          },
        },
        columnDefs: [
          {
            targets: 7,

            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[1] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },
          { targets: 4, className: "wrap" },
          { targets: 5, className: "wrap" },
        ],
        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#linkeddataids").val(json.data[0][2]);
          }
          $("#con-close-modal-linked").modal("show");
        },
      });

      return false;
    }
  );

  // LINKEDJIGAR
  $("#villages-units-datatable tbody").on(
    "click",
    "tr td.btnlinked , tr td a.btnlinked",
    function (event) {
      // $('#con-close-modal-link').modal('show');

      var data = JSON.parse(event.target.dataset.todo);
      //console.log(data);
      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
        idsofdt = data.DTID2021;
        idsofsd = data.SDID2021;
        idsofvt = data.VTID2021;
        $("#linkeddtdataids").val(data.DTID2021);
        $("#linkedsddataids").val(data.SDID2021);
        $("#linkedvtdataids").val(data.VTID2021);
      } else {
        idsofst = $("#linkeddataids").val();
        idsofdt = $("#linkeddtdataids").val();
        idsofsd = $("#linkedsddataids").val();
        idsofvt = $("#linkedvtdataids").val();
      }

      var tablejig1 = $("#linked-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinkedlist";
            d.STID2021 = idsofst;
            d.DTID2021 = idsofdt;
            d.SDID2021 = idsofsd;
            d.VTID2021 = idsofvt;
            d.linkedcomefrom = $("#linkedcomefrom").val();
          },
        },
        columnDefs: [
          {
            targets: 7,

            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[1] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },
          { targets: 4, className: "wrap" },
          { targets: 5, className: "wrap" },
        ],
        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#linkeddataids").val(json.data[0][2]);
          }
          $("#con-close-modal-linked").modal("show");
        },
      });

      return false;
    }
  );

  // LINKEDJIGAR
  $("#wards-units-datatable tbody").on(
    "click",
    "tr td.btnlinked , tr td a.btnlinked",
    function (event) {
      // $('#con-close-modal-link').modal('show');

      var data = JSON.parse(event.target.dataset.todo);
      //console.log(data);
      var idsofst = "";
      if (data.STID2021) {
        idsofst = data.STID2021;
        idsofdt = data.DTID2021;
        idsofsd = data.SDID2021;
        idsofvt = data.VTID2021;
        idsofwd = data.WDID2021;
        $("#linkeddtdataids").val(data.DTID2021);
        $("#linkedsddataids").val(data.SDID2021);
        $("#linkedvtdataids").val(data.VTID2021);
        $("#linkedwddataids").val(data.WDID2021);
      } else {
        idsofst = $("#linkeddataids").val();
        idsofdt = $("#linkeddtdataids").val();
        idsofsd = $("#linkedsddataids").val();
        idsofvt = $("#linkedvtdataids").val();
        idsofvt = $("#linkedwddataids").val();
      }

      var tablejig1 = $("#linked-datatable").DataTable({
        lengthMenu: [
          [10, 25, 50, 100, -1],
          [10, 25, 50, 100, "All"],
        ],
        processing: true,
        serverSide: true,
        bServerSide: true,
        bDestroy: true,
        ajax: {
          url: "insert_data.php",
          type: "POST",
          data: function (d) {
            d.formname = "getlinkedlist";
            d.STID2021 = idsofst;
            d.DTID2021 = idsofdt;
            d.SDID2021 = idsofsd;
            d.VTID2021 = idsofvt;
            d.WDID2021 = idsofwd;
            d.linkedcomefrom = $("#linkedcomefrom").val();
          },
        },
        columnDefs: [
          {
            targets: 7,

            render: function (dataa, type, row, meta) {
              if (type === "display") {
                data =
                  '<a href="Alldocuments/' +
                  row[1] +
                  "/" +
                  encodeURIComponent(dataa) +
                  '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
              }
              return data;
            },
          },
          {
            targets: 0,
            checkboxes: {
              selectRow: true,
            },
          },
          { targets: 4, className: "wrap" },
          { targets: 5, className: "wrap" },
        ],
        select: {
          style: "multi",
        },
        order: [[1, "asc"]],
        initComplete: function (settings, json) {
          if (json.data.length > 0) {
            $("#linkeddataids").val(json.data[0][2]);
          }
          $("#con-close-modal-linked").modal("show");
        },
      });

      return false;
    }
  );

  $("#con-close-modal-add .close,#con-close-modal-add .closepop").on(
    "click",
    function () {
      $("#con-close-modal-add").find("form").parsley().reset();
      $("#con-close-modal-add").find("form")[0].reset();
      $("#con-close-modal-add").find("form select").select2().trigger("change");
    }
  );

  // $('#con-close-modal .close,#con-close-modal .closepop').on('click', function () {

  //     $('#con-close-modal').find('form').parsley().reset();
  //     $('#con-close-modal').find('form')[0].reset();
  //     $('#con-close-modal').find('form select').select2().trigger('change');
  // });

  $("#con-close-modal-linked .close,#con-close-modal-linked .closepop").on(
    "click",
    function () {
      $("#con-close-modal-linked").find("form")[0].reset();
      //  $('#con-close-modal-linked').find('form select').select2().trigger('change');
    }
  );

  $("#con-close-modal-linkdc .close,#con-close-modal-linkdc .closepop").on(
    "click",
    function () {
      $("#con-close-modal-linkdc").find("form")[0].reset();
      $("#con-close-modal-linkdc")
        .find("form select")
        .select2()
        .trigger("change");
    }
  );

  //   $(document).ready(function(){
  $("#fdiv").click(function () {
    $("#login").hide();
    $("#forgot_pass").parsley().reset();
    $("#forgot_pass")[0].reset();
    $("#forgot").show();
  });
  $("#ldiv").click(function () {
    $("#forgot").hide();
    $("#login_form").parsley().reset();
    $("#login_form")[0].reset();
    $("#login").show();
  });

  $("#login_form").submit(function (e) {
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "login") {
          //  Command: toastr["success"]("You have successfully logged in.")
          $("#success_alert_msg").text("You have successfully logged in.");
          $("#success_alert")
            .fadeTo(4000, 500)
            .slideUp(500, function () {
              $("#success_alert").slideUp(500);
            });

          setTimeout("window.location.href='index'", "2000");
          return false;
        } else if (data == "notactivated") {
          $("#danger_alert_msg").text(
            "Your account not activated. Contact to admin."
          );
          $("#danger_alert")
            .fadeTo(4000, 500)
            .slideUp(500, function () {
              $("#danger_alert").slideUp(500);
            });

          return getcpachanew();
        } else if (data == "inccodedata") {
          $("#danger_alert_msg").text("Incorrect Captcha Code");
          $("#danger_alert")
            .fadeTo(4000, 500)
            .slideUp(500, function () {
              $("#danger_alert").slideUp(500);
            });

          return getcpachanew();
        } else if (data == "loginfail") {
          // Command: toastr["error"]("Your email address or password is incorrect. Please try again.")
          $("#danger_alert_msg").text(
            "Your Login Id  or Password is incorrect."
          );
          $("#danger_alert")
            .fadeTo(4000, 500)
            .slideUp(500, function () {
              $("#danger_alert").slideUp(500);
            });

          return getcpachanew();
        } else if (data == "server_prob") {
          // Command: toastr["error"]("Your email address or password is incorrect. Please try again.")
          $("#danger_alert_msg").text(
            "Your email address or password is incorrect."
          );
          $("#danger_alert")
            .fadeTo(4000, 500)
            .slideUp(500, function () {
              $("#danger_alert").slideUp(500);
            });

          return getcpachanew();
        } else if (data == "notregistered") {
          $("#danger_alert_msg").text(
            "Your Login ID and Password is incorrect."
          );
          $("#danger_alert")
            .fadeTo(4000, 500)
            .slideUp(500, function () {
              $("#danger_alert").slideUp(500);
            });

          return getcpachanew();
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#forgot_pass").submit(function (e) {
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "email_send_of") {
          //  Command: toastr["success"]("Your Password has been sent to your email id.")
          //  setTimeout("back_login()",'3000');
          $("#success_alert_msg_for").text(
            "Your Password has been sent to your email."
          );
          $("#success_alert_for")
            .fadeTo(2000, 500)
            .slideUp(500, function () {
              $("#success_alert_for").slideUp(500);
            });

          setTimeout(
            '$("#forgot").hide();$("#login_form").parsley().reset();$("#login_form")[0].reset();$("#login").show();',
            "3000"
          );

          return false;
        } else if (data == "emailnotexits") {
          //  Command: toastr["error"]("Your email does not exist in records")
          $("#danger_alert_msg_for").text(
            "Your email does not exist in our records."
          );
          $("#danger_alert_for")
            .fadeTo(4000, 500)
            .slideUp(500, function () {
              $("#danger_alert_for").slideUp(500);
            });

          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#changepassword").submit(function (e) {
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "changepassword") {
          Command: toastr["success"](" Password  Changed Successfully.");
          $("#changepassword")[0].reset();
          return false;
        } else if (data == "passwordvarification") {
          Command: toastr["warning"](
            "Password should be at least 8 to 16 characters in length and should include at least one upper case letter, one lower case letter, one number, and one special character."
          );
          return false;
        } else if (data == "passwordnotmatch") {
          Command: toastr["warning"]("Current password does not match.");
          return false;
        } else if (data == "samepass") {
          Command: toastr["warning"](
            "New password is similar to the last 2 passwords.Kindly use unique one"
          );
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#profileupdate").submit(function (e) {
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "profileupdatedone") {
          Command: toastr["success"]("Profile Update Successfully.");
          $("#changepassword")[0].reset();
          return false;
        } else if (data == "usernotmatch") {
          Command: toastr["worning"]("User Not matched.");
          return false;
        } else if (data == "mobilealready") {
          Command: toastr["error"](
            "This Mobile Number already exists. Use another to process further."
          );
          return false;
        } else if (data == "emailalready") {
          toastr["error"]("This Email ID already exists.");
          return false;
        } else if (data == "bothemailmobilealready") {
          toastr["error"]("Both Email ID & Mobile Number already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#linkdata").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();
    var form = this;

    var rows_selected = $("#jigardata-datatable")
      .DataTable()
      .column(0)
      .checkboxes.selected();
    $.each(rows_selected, function (index, rowId) {
      // Create a hidden element
      $(form).append(
        $("<input>").attr("type", "hidden").attr("name", "id[]").val(rowId)
      );
    });

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "adddata") {
          //  Command: toastr["success"]("Successfully added state.");
          //  setTimeout(function () { location.reload() }, 3000);
          $("#con-close-modal-link .close").click();
          Swal.fire({
            title: "Successfully Linked Document.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });
          //       location.reload();

          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#linkeddataupdate").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();
    var form = this;

    var rows_selected = $("#linked-datatable")
      .DataTable()
      .column(0)
      .checkboxes.selected();
    if (rows_selected.length > 0) {
      $.each(rows_selected, function (index, rowId) {
        // Create a hidden element
        $(form).append(
          $("<input>").attr("type", "hidden").attr("name", "ids[]").val(rowId)
        );
      });

      $.ajax({
        url: "insert_data.php", // Url to which the request is send
        type: "POST",
        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function (
          data // A function to be called if request succeeds
        ) {
          if (data == "unlinkdata") {
            $("#con-close-modal-linked .close").click();
            Swal.fire({
              title: "Successfully unlink Document.",
              type: "success",
              confirmButtonColor: "#348cd4",
            }).then(function (t) {
              if (t.value) {
                location.reload();
              }
            });

            return false;
          } else if (data == "error") {
            Command: toastr["error"]("Server Problem try after sometime.");
            return false;
          }
        },
        error: function (jqXHR, exception) {
          if (jqXHR.status === 0) {
            Command: toastr["error"]("Not connect.n Verify Network.");
          } else if (jqXHR.status == 404) {
            Command: toastr["error"]("Requested page not found. [404]");
          } else if (jqXHR.status == 500) {
            Command: toastr["error"]("Internal Server Error [500].");
          } else if (exception === "timeout") {
            Command: toastr["error"]("Time out error.");
          } else if (exception === "abort") {
            Command: toastr["error"]("Ajax request aborted.");
          } else {
            Command: toastr["error"]("Uncaught Error.n");
          }
        },
      });
    } else {
      Command: toastr["warning"]("Select at least one record.");
      return false;
    }
  });

  $("#assigndata").submit(function (e) {
    $("#assigndata")
      .find("input, textarea, button, select")
      .removeAttr("disabled", "disabled");

    var dataform = new FormData(this);

    if (
      $("#comefromcheck").val() == "Village / Town" ||
      $("#clickpopup").val() == "Reshuffle"
    ) {
      var resac = new Array();

      $('select[name="action[]"] option:selected').map(function () {
        resac.push($(this).parent().attr("id").substring(6));
      });

      var namefromtext = new Array();
      for (var h = 0; h < resac.length; h++) {
        if (h == 0) {
          $('select[id="selected_come"] option:selected').each(function () {
            if ($(this).val() != "") {
              namefromtext.push(this.text);
            }
          });
        } else {
          $('select[id="id2021' + resac[h] + '"] option:selected').each(
            function () {
              if ($(this).val() != "") {
                namefromtext.push(this.text);
              }
            }
          );
        }
      }

      dataform.append("ind", resac);
    } else {
      var namefromtext = $('select[name="namefrom[]"] option:selected')
        .map(function () {
          return this.text;
        })
        .get();
    }

    if (
      $("#clickpopup").val() == "Reshuffle" &&
      $("#comefromcheck").val() == "Village / Town"
    ) {
      var namefrompre = $('select[name="sddistrictnew[]"] option:selected')
        .map(function () {
          return this.text;
        })
        .get();
    } else {
      var namefrompre = $('select[name="districtnew[]"] option:selected')
        .map(function () {
          return this.text;
        })
        .get();
    }

    var open = [];
    var ooremove = document.getElementsByName("oremove[]");
    for (var j = 0; j < ooremove.length; j++) {
      if (ooremove[j].checked == true) {
        open.push(1);
      } else {
        open.push(0);
      }
    }

    var statenew = $('select[name="statenew[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var districtnew = $('select[name="districtnew[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var sddistrictnew = $('select[name="sddistrictnew[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var statenewfrom = $('select[name="fromstate[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var districtnewfrom = $('select[name="districtget[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var sddistrictnewfrom = $('select[name="sddistrictget[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    $(".FAC").prop("disabled", false);
    dataform.append("namefromtext", namefromtext);
    dataform.append("namefrompre", namefrompre);
    dataform.append("origremove", open);

    dataform.append("statenewarray", statenew);
    dataform.append("districtnewarray", districtnew);
    dataform.append("sddistrictnewarray", sddistrictnew);

    dataform.append("statenewarrayfrom", statenewfrom);
    dataform.append("districtnewarrayfrom", districtnewfrom);
    dataform.append("sddistrictnewarrayfrom", sddistrictnewfrom);

    //   if($('#clickpopup').val()=='Merge' || $('#clickpopup').val()=='Partiallysm' || $('#clickpopup').val()=='Rename')
    //Delete Rithisha
    if (
      $("#clickpopup").val() == "Merge" ||
      $("#clickpopup").val() == "Partiallysm" ||
      $("#clickpopup").val() == "Rename" ||
      $("#clickpopup").val() == "Deletion"
    ) {
      var nametotext = $('select[name="newnamem[]"] option:selected')
        .map(function () {
          return this.text;
        })
        .get();

      var open1 = [];
      var ooremove1 = document.getElementsByName("oremovenew[]");
      for (var j = 0; j < ooremove1.length; j++) {
        if (ooremove1[j].checked == true) {
          open1.push(1);
        } else {
          open1.push(0);
        }
      }

      dataform.append("nametotext", nametotext);
      dataform.append("oremovenewarray", open1);
    }

    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: dataform, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        var res = data.split("|");

        if (res[0] == "adddata") {
          if (
            $("#clickpopup").val() == "Merge" ||
            $("#clickpopup").val() == "Partiallysm"
          ) {
            var dataarray = JSON.parse(res[1]);
            //    console.log(dataarray);

            var strnew = "";
            if ($("#clickpopup").val() == "Partiallysm") {
              strnew = "Partially Split & Merge";
            } else {
              strnew = "Partially Merge";
            }
            const indexes = dataarray["action"].reduce((r, n, i) => {
              n === strnew && r.push(i);

              return r;
            }, []);

            $("#addnewdocument .close").click();
            $(".disbut").attr("disabled", "disabled");
            $('input[name="startfrom"]').attr("disabled", "disabled");
            $("#clickbutton").val(dataarray["clickpopup"]);
            if (res[4] == 0) {
              $("#finaldata").val(res[1]);

              var totalcount = 0;
              var totalutcount = 0;
              var totalcount = 0;
              var stflag = "";
              var utflag = "";

              var stmsgname = "";
              var utmsgname = "";
              var fmsg = "";

              var fromnamenew = "";
              var mainaction = "";
              var fromdatacoccatename = "";
              var fromdatacoccatenamep = "";
              var fromnamedataut = "";
              var totalucount = "";

              //  console.log(dataarray);
              var fromnamedata = "";
              namefromtext = dataarray["namefromtext"].split(",");
              if (dataarray["comefromcheck"] == "State") {
                for (var k = 0; k < dataarray["namefrom"].length; k++) {
                  var flagstatus = "";
                  if (dataarray["ostate"][k] == "ST") {
                    totalcount = totalcount + 1;
                    flagstatus = "State";
                    flagstatusst = "State";

                    //    namefromtost =' <span class="trinstrong1">'+namefromtext[k]+'</span>';
                  } else {
                    totalucount = totalucount + 1;
                    flagstatus = "Union Territory";
                    flagstatusut = "Union Territory";

                    //  namefromtout =' <span class="trinstrong1">'+namefromtext[k]+'</span>';
                  }

                  var flagstatus1 = "";
                  var flagstatus_n = "";
                  if (dataarray["fstatus"][k] == "ST") {
                    flagstatus1 = "Now State";
                    flagstatus_n = "State";
                    //    namefromto =' <span class="trinstrong1">'+namefromtext[k]+'</span>';
                  } else {
                    flagstatus_n = "Union Territory";
                    flagstatus1 = "Now Union Territory";

                    // namefromto =' <span class="trinstrong1">'+namefromtext[k]+'</span>';
                  }
                  var finalflag = "";
                  if (flagstatus == flagstatus_n) {
                    finalflag = "";
                  } else {
                    finalflag = "<span>(" + flagstatus1 + ")</span>";
                  }

                  if (dataarray["ostate"][k] == "ST") {
                    namefromtost =
                      '<span class="trinstrong1">' +
                      namefromtext[k] +
                      "</span>" +
                      finalflag +
                      "";
                    fromnamedata += "<strong>" + namefromtost + "</strong>, ";
                  } else {
                    namefromtout =
                      ' <span class="trinstrong1">' +
                      namefromtext[k] +
                      "</span>" +
                      finalflag +
                      "";
                    fromnamedataut += "<strong>" + namefromtout + "</strong>, ";
                  }
                }

                fromnamedata = fromnamedata.slice(0, -2);
                fromnamedataut = fromnamedataut.slice(0, -2);
                var sssflag_n = "";

                if (dataarray["StateStatus"][0] == "ST") {
                  sssflag_n = "State";
                  sssflag1 = "Now State";
                } else {
                  sssflag_n = "Union Territory";
                  sssflag1 = "Now Union Territory";
                }

                if (dataarray["toStatus"][0] == "ST") {
                  sssflagto = "State";
                } else {
                  sssflagto = "Union Territory";
                }
                var newflagof = "";
                if (sssflag_n == sssflagto) {
                  newflagof = "";
                } else {
                  newflagof = "<span>(" + sssflag1 + ")</span>";
                }

                //modified by sahana state status in merge flow 1509
                if (totalcount != 0 && totalucount == 0) {
                  fmsg =
                    "(Total - " +
                    totalcount +
                    " ) - <strong>" +
                    flagstatusst +
                    "(s) : </strong>" +
                    fromnamedata +
                    "  <br> " +
                    $("#clickpopup").val() +
                    'd into <br><span class="trinspam"><strong>' +
                    sssflagto +
                    ' : </strong></span> <strong class="trinstrong">' +
                    dataarray["nametotext"] +
                    "</strong><strong>" +
                    newflagof +
                    "</strong>";
                } else if (totalcount == 0 && totalucount != 0) {
                  fmsg =
                    "(Total - " +
                    totalucount +
                    " ) - <strong>" +
                    flagstatusut +
                    "(s) : </strong>" +
                    fromnamedataut +
                    "  <br> " +
                    $("#clickpopup").val() +
                    'd into <br><span class="trinspam"><strong>' +
                    sssflagto +
                    ' : </strong></span> <strong class="trinstrong">' +
                    dataarray["nametotext"] +
                    "</strong><strong>" +
                    newflagof +
                    "</strong>";
                } else {
                  fmsg =
                    "(Total - " +
                    totalcount +
                    " ) - <strong>" +
                    flagstatusst +
                    "(s) : </strong>" +
                    fromnamedata +
                    "  <br> AND <br> (Total - " +
                    totalucount +
                    " ) - <strong>" +
                    flagstatusut +
                    "(s) : </strong>" +
                    fromnamedataut +
                    "  <br> " +
                    $("#clickpopup").val() +
                    'd into <br><strong><span class="trinspam">' +
                    sssflagto +
                    ' : </span></strong> <strong class="trinstrong">' +
                    dataarray["nametotext"] +
                    "</strong><strong>" +
                    newflagof +
                    "</strong>";
                }

                //  fmsg = '(Total - '+totalcount+' ) - '+flagstatus+'(s) : '+fromnamedata+'  <br> '+$('#clickpopup').val()+'d into <br><span class="trinspam">'+sssflagto+' : </span> <strong class="trinstrong">'+dataarray['nametotext']+'</strong><strong>'+newflagof+'</strong>';
              } else {
                for (var k = 0; k < dataarray["namefrom"].length; k++) {
                  var flagstatus = "" + dataarray["comefromcheck"] + "";

                  totalcount = totalcount + 1;
                  namefromto =
                    ' <span class="trinstrong1">' + namefromtext[k] + "</span>";

                  fromnamedata += "<strong>" + namefromto + "</strong>, ";
                }

                fromnamedata = fromnamedata.slice(0, -2);

                fmsg =
                  "(Total - " +
                  totalcount +
                  " ) - <strong>" +
                  flagstatus +
                  "(s)</strong> : " +
                  fromnamedata +
                  "  <br> " +
                  $("#clickpopup").val() +
                  "d into <br> <strong>" +
                  flagstatus +
                  ' : </strong><strong class="trinstrong">' +
                  dataarray["nametotext"] +
                  "</strong>";
              }

              if (dataarray["oremovenew"] == 1) {
                //    var maintitaldata = '<strong>'+capitalizeFirstLetter(dataarray['namefromtext'])+'</strong> '+dataarray['comefromcheck']+' '+dataarray['action'][0]+'d into <strong>'+capitalizeFirstLetter(dataarray['nametotext'])+'</strong> '+dataarray['comefromcheck']+' And '+dataarray['comefromcheck']+' <strong>'+dataarray['nametotext']+'</strong> name changed to <strong>'+capitalizeFirstLetter(dataarray['newnamecheck'][0])+'</strong>' ;
                var aa = dataarray["newnamecheck"][0];

                if (dataarray["toStatus"][0] == "ST") {
                  $sahana = "State: ";
                } else {
                  $sahana = "Union Territory: ";
                }

                //modified by sahana status merge district 1609
                if (dataarray["comefromcheck"] == "State") {
                  //modified by sahana state status in merge flow 1509
                  fmsg =
                    fmsg +
                    " <br>AND<br> <strong>" +
                    $sahana +
                    '</strong><strong class="trinstrong">' +
                    dataarray["nametotext"] +
                    '</strong> name changed to <strong class="trinstrong">' +
                    aa +
                    "</strong><strong>(" +
                    sssflag_n +
                    ")</strong>"; //modiifed by sahana JC_41
                } else {
                  //modified by sahana state status in merge flow 1509
                  fmsg =
                    fmsg +
                    " <br>AND<br> <strong>" +
                    dataarray["comefromcheck"] +
                    ': </strong><strong class="trinstrong">' +
                    dataarray["nametotext"] +
                    '</strong> name changed to <strong class="trinstrong">' +
                    aa +
                    ' <span class="trinspam">(' +
                    dataarray["comefromcheck"] +
                    ")</span></strong>"; //modiifed by sahana JC_41
                }
              }

              $("#maintitledata").html(fmsg);
              $("#mainaction").html("");

              $("#viewerlast").css("display", "block");
              $("#pdf").css("display", "block");
              var filename = $("#viewerlast")
                .contents()
                .get(0)
                .location.href.replace(/^.*[\\\/]/, "");

              $("#docname").text(decodeURIComponent(filename));
              $("#viewerlaststep").attr(
                "src",
                $("#viewerlast").contents().get(0).location.href
              );

              $("#nextstep3").css("visibility", "visible");
              $("#progressbarwizard1").bootstrapWizard("next");
              $("#backbtnnew").css("visibility", "hidden");
              return false;
            } else {
              var idscount = res[4] - 1;

              var tes = "";
              for (var j = 0; j <= indexes.length; j++) {
                tes += "#addlinksDTID_" + indexes[j] + ",";
              }
              var n = tes.replace(/,\s*$/, "");

              $("#daynamor").html("");
              $("#daynamor").html(res[3]);
              $(".haveapartially").prop("disabled", true);
              $("" + n + "").multiSelect({
                selectableHeader:
                  "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                selectionHeader:
                  "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                afterInit: function (t) {
                  var e = this,
                    n = e.$selectableUl.prev(),
                    a = e.$selectionUl.prev(),
                    i =
                      "#" +
                      e.$container.attr("id") +
                      " .ms-elem-selectable:not(.ms-selected)",
                    s =
                      "#" +
                      e.$container.attr("id") +
                      " .ms-elem-selection.ms-selected";
                  (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
                    if (40 === t.which) return e.$selectableUl.focus(), !1;
                  })),
                    (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                      if (40 == t.which) return e.$selectionUl.focus(), !1;
                    }));
                },
                afterSelect: function (values) {
                  var check = this.$container.attr("id");
                  var checkdata = check.split("_");

                  this.qs1.cache(), this.qs2.cache();
                  var data = [];
                  var data1 = [];
                  var $el = $("#ms-addlinksDTID_" + checkdata[1] + "");
                  $("#totaldefultselected_" + checkdata[1] + "").html(
                    $el.find('[class*="ms-elem-selection ms-selected"]').length
                  );
                  $el
                    .find('[class*="ms-elem-selection ms-selected"]')
                    .each(function () {
                      data.push($(this).text());
                      var ii = this.id;
                      var idd = ii.split("-");
                      //  var idddata = idd[0].join("-selectable")
                      data1.push(idd[0]);
                    });

                  // && $.inArray( $(this).text(), data1 )!= -1

                  for (var m = 0; m <= idscount; m++) {
                    if (checkdata[1] != m) {
                      $("#ms-addlinksDTID_" + m + "")
                        .find('[class*="ms-elem-selectable"]')
                        .each(function () {
                          var j = this.id.split("-");
                          if (
                            $.inArray($(this).text(), data) != -1 &&
                            $.inArray(j[0], data1) != -1
                          ) {
                            $(this).addClass("disabled");
                          }
                        });
                    }
                  }

                  if (this.qs2.matchedResultsCount != 0) {
                    $("#" + checkdata[1] + "").prop("disabled", false);
                  } else {
                    $("#" + checkdata[1] + "").prop("disabled", true);
                  }
                },
                afterDeselect: function () {
                  var check = this.$container.attr("id");
                  var checkdata = check.split("_");

                  var data = [];
                  var $el = $("#ms-addlinksDTID_" + checkdata[1] + "");
                  $("#totaldefultselected_" + checkdata[1] + "").html(
                    $el.find('[class*="ms-elem-selection ms-selected"]').length
                  );
                  $el
                    .find('[class*="ms-elem-selection ms-selected"]')
                    .each(function () {
                      data.push($(this).text());
                    });

                  for (var m = 0; m <= idscount; m++) {
                    if (checkdata[1] != m) {
                      $("#ms-addlinksDTID_" + m + "")
                        .find('[class*="ms-elem-selectable"]')
                        .each(function () {
                          if ($.inArray($(this).text(), data) == -1) {
                            $(this).removeClass("disabled");
                          }
                        });
                    }
                  }

                  this.qs1.cache(), this.qs2.cache();
                  if (this.qs2.matchedResultsCount != 0) {
                    $("#" + checkdata[1] + "").prop("disabled", false);
                  } else {
                    $("#" + checkdata[1] + "").prop("disabled", true);
                  }
                },
              });
              $("#returndata").val(res[1]);
              $("#nextstep2").css("visibility", "visible");
              $("#clickbutton").val(res[5]);
              $("#backbtnnew").css("visibility", "hidden");
            }
          } else if ($("#clickpopup").val() == "Rename") {
            var dataarray = JSON.parse(res[1]);
            //   console.log(res);
            //   console.log(res[1]);
            //     console.log(dataarray);
            var fmsg = "";
            var totalvcount = 0;
            var totaltcount = 0;
            var vnames = "";
            var vnamess = "";
            var vflag = "";
            var tnames = "";
            var tflag = "";
            var names = "";
            var fromnamenew = "";

            $("#addnewdocument .close").click();

            $("#finaldata").val(res[1]);
            var mainaction = "";
            if (dataarray["applyon"] == "State") {
              mainaction +=
                '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead" colspan="2"><th> Existing (State / UT) </th><th>Rename </th><th>Status Change</th></tr></thead><tbody>';
            } else {
              var lableof = "";
              if (dataarray["applyon"] == "Village / Town") {
                lableof = "Village(s) / Town";
                mainaction +=
                  '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> Existing - ' +
                  lableof +
                  "(s)</th><th> Rename </th><th>Status Change</th></tr></thead><tbody>";
              } else {
                lableof = dataarray["applyon"];

                mainaction +=
                  '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> Existing - ' +
                  lableof +
                  "(s)</th><th> Rename </th></tr></thead><tbody>";
              }
            }

            var toname = dataarray["nametotext"].split(",");
            for (var k = 0; k < dataarray["newnamecheck"].length; k++) {
              var name = "";
              if (dataarray["applyon"] == "State") {
                if (dataarray["toStatus"][k] == "ST") {
                  if (dataarray["StateStatus"][k] == dataarray["toStatus"][k]) {
                    var nst = " - ";
                  } else {
                    var nst = "Union Territory";
                  }
                  totalvcount = totalvcount + 1;
                  name = nametotext[k];

                  vflag = "State(s)";

                  fromnamenew =
                    '<strong class="trinstrong">' +
                    dataarray["newnamecheck"][k] +
                    "</strong>";

                  if (dataarray["newnamecheck"][k] != "") {
                    var hhh =
                      '<strong class="trinstrong">' +
                      dataarray["newnamecheck"][k] +
                      "</strong>";
                  } else {
                    var hhh = '<strong class="trinstrong"> - </strong>';
                  }

                  // status change to changed
                  //             fmsg += " <ol>(Total - " + totalvcount +  " ) <strong> " + vflag +' - <span class="trinstrong1">' +toname[k]+"</span></strong>  Renamed as " +hh+  "<br> And status changed to  <b>"  +nst+" </b> </ol> ";
                  //         mainaction +='<tr><td><strong class="trinstrong1">'+toname[k]+' <span class="trinspam">(State)</span></strong></td><td>'+hh+'</td><td><strong class="trinstrong"><span class="trinspam">'+nst+'</span></strong></td></tr>';
                  //         }
                  //         else
                  //         {

                  //             if(dataarray['StateStatus'][k]==dataarray['toStatus'][k])
                  //             {
                  //                 var nst=' - ';
                  //             }
                  //             else
                  //             {
                  //                 var nst='State';
                  //             }

                  //               if(dataarray['newnamecheck'][k]!='')
                  //             {
                  //                     var hhh='<strong class="trinstrong">'+capitalizeFirstLetter(dataarray['newnamecheck'][k])+'</strong>';
                  //             }
                  //             else
                  //             {
                  //                     var hhh='<strong class="trinstrong"> - </strong>';
                  //             }
                  //             // status change to changed
                  //             fmsg += " <ol>(Total - " + totalvcount + " ) <strong> " + vflag +' - <span class="trinstrong1">' + toname[k]+ "</span></strong> <br> Renamed as " +hhh+  " <br> And status changed to  <b>"  +nst+" </b> </ol>";
                  //         mainaction +='<tr><td><strong class="trinstrong1">'+toname[k]+' <span class="trinspam">(Union Territory)</span></strong></td><td>'+hhh+'</td><td><strong class="trinstrong"><span class="trinspam">'+nst+'</span></strong></td></tr>';
                  //         }

                  // }

                  //modified by arun
                  // if(dataarray['newnamecheck'][k]!='' && (dataarray['StateStatus'][k] == dataarray['toStatus'][k]))
                  // {
                  //         //var hhh='<strong class="trinstrong">'+capitalizeFirstLetter(dataarray['newnamecheck'][k])+'</strong>';
                  // fmsg += " <ol>(Total - " + totalvcount + " ) <strong> " + vflag +' - <span class="trinstrong1">' + toname[k]+ "</span></strong> <br> Renamed as " +hhh;

                  // }else if(dataarray['StateStatus'][k] != dataarray['toStatus'][k] && dataarray['newnamecheck'][k] ==''){
                  // fmsg += " <ol>(Total - " + totalvcount + " ) <strong> " + vflag +' - <span class="trinstrong1">' + toname[k]+ "</span></strong> status changed to  <b>"  +nst;

                  // }else{
                  // fmsg += " <ol>(Total - " + totalvcount + " ) <strong> " + vflag +' - <span class="trinstrong1">' + toname[k]+ "</span></strong> <br> Renamed as " +hhh+  " <br> And status changed to  <b>"  +nst+" </b> </ol>";

                  // }
                  // status change to changed
                  // fmsg += " <ol>(Total - " + totalvcount +  " ) <strong> " + vflag +' - <span class="trinstrong1">' +toname[k]+"</span></strong>  Renamed as " +hh+  "<br> And status changed to  <b>"  +nst+" </b> </ol> ";
                  mainaction +=
                    '<tr><td><strong class="trinstrong1">' +
                    toname[k] +
                    ' <span class="trinspam">(State)</span></strong></td><td>' +
                    hhh +
                    '</td><td><strong class="trinstrong"><span class="trinspam">' +
                    nst +
                    "</span></strong></td></tr>";
                } else {
                  if (dataarray["StateStatus"][k] == dataarray["toStatus"][k]) {
                    var nst = " - ";
                  } else {
                    var nst = "State";
                  }
                  //modified by arun
                  totalvcount = totalvcount + 1;
                  name = nametotext[k];

                  if (dataarray["newnamecheck"][k] != "") {
                    var hhh =
                      '<strong class="trinstrong">' +
                      dataarray["newnamecheck"][k] +
                      "</strong>";
                  } else {
                    var hhh = '<strong class="trinstrong"> - </strong>';
                  }
                  //modified by arun
                  if (
                    dataarray["newnamecheck"][k] != "" &&
                    dataarray["StateStatus"][k] == dataarray["toStatus"][k]
                  ) {
                    //var hhh='<strong class="trinstrong">'+capitalizeFirstLetter(dataarray['newnamecheck'][k])+'</strong>';
                    // fmsg += " <ol>(Total - " + totalvcount + " ) <strong> " + vflag +' - <span class="trinstrong1">' + toname[k]+ "</span></strong> <br> Renamed as " +hhh;
                  } else if (
                    dataarray["StateStatus"][k] != dataarray["toStatus"][k] &&
                    dataarray["newnamecheck"][k] == ""
                  ) {
                    // fmsg += " <ol>(Total - " + totalvcount + " ) <strong> " + vflag +' - <span class="trinstrong1">' + toname[k]+ "</span></strong> status changed to  <b>"  +nst;
                  } else {
                    // fmsg += " <ol>(Total - " + totalvcount + " ) <strong> " + vflag +' - <span class="trinstrong1">' + toname[k]+ "</span></strong> <br> Renamed as " +hhh+  " <br> And status changed to  <b>"  +nst+" </b> </ol>";
                  }

                  // status change to changed
                  // fmsg += " <ol>(Total - " + totalvcount + " ) <strong> " + vflag +' - <span class="trinstrong1">' + toname[k]+ "</span></strong> <br> Renamed as " +hhh+  " <br> And status changed to  <b>"  +nst+" </b> </ol>";
                  mainaction +=
                    '<tr><td><strong class="trinstrong1">' +
                    toname[k] +
                    ' <span class="trinspam">(Union Territory)</span></strong></td><td>' +
                    hhh +
                    '</td><td><strong class="trinstrong"><span class="trinspam">' +
                    nst +
                    "</span></strong></td></tr>";
                }
              }

              // rename state validation ends here & starts for village
              else {
                if (dataarray["applyon"] == "Village / Town") {
                  // rename m:1 summary issue village level (commented the below)
                  // if(dataarray['vlevel'][k]=='VILLAGE')
                  // {
                  //     dataarray['ovstatus'][k]='RV';
                  // }

                  var fl = "";

                  if (dataarray["vlevel"][k] == dataarray["vStateStatus"][k]) {
                    if (dataarray["ovstatus"][k] == dataarray["vstatus"][k]) {
                      fl = " - ";
                    } else {
                      fl =
                        '<strong class="trinstrong">' +
                        dataarray["vStateStatus"][k] +
                        " - " +
                        dataarray["vstatus"][k] +
                        "</strong>";
                    }
                  } else {
                    if (dataarray["ovstatus"][k] == dataarray["vstatus"][k]) {
                      fl = " - ";
                    } else {
                      fl =
                        '<strong class="trinstrong">' +
                        dataarray["vStateStatus"][k] +
                        " - " +
                        dataarray["vstatus"][k] +
                        "</strong>";
                    }
                  }

                  if (dataarray["newnamecheck"][k] != "") {
                    //   <span class="trinspam">('+capitalizeFirstLetter(dataarray['vStateStatus'][k])+' - '+dataarray['vstatus'][k]+')</span>
                    var hh =
                      '<strong class="trinstrong">' +
                      dataarray["newnamecheck"][k] +
                      " </strong>";
                  } else {
                    var hh = '<strong class="trinstrong"> - </strong>';
                  }

                  totalvcount = totalvcount + 1;

                  name = nametotext[k];

                  vflag =
                    "" +
                    capitalizeFirstLetter(dataarray["vlevel"][k]) +
                    " - " +
                    dataarray["ovstatus"][k] +
                    "";

                  fromnamenew =
                    '<strong class="trinstrong">' +
                    dataarray["newnamecheck"][k] +
                    "</strong>";
                  // status change to changed one to one village
                  if (
                    dataarray["newnamecheck"][k] != "" &&
                    dataarray["vstatus"][k] == dataarray["ovstatus"][k]
                  ) {
                    //rename
                    //    fmsg +=" <ol>(Total - " + totalvcount + " ) <strong> " +  vflag + ' - <span class="trinstrong1">'   +toname[k]+ "</span></strong>  Renamed as "  +hh+ "</span></strong>";
                  } else if (
                    dataarray["vstatus"][k] != dataarray["ovstatus"][k] &&
                    dataarray["newnamecheck"][k] == ""
                  ) {
                    //status change
                    //    fmsg +=" <ol>(Total - " + totalvcount + " ) <strong> " +  vflag + ' - <span class="trinstrong1">'   +toname[k]+ "</span></strong> Status Changed To  " +fl+ " </span></strong>";
                  } else {
                    //rename n status change
                    //    fmsg +=" <ol>(Total - " + totalvcount + " ) <strong> " +  vflag + ' - <span class="trinstrong1">'   +toname[k]+ "</span></strong>  Renamed as "  +hh+ "</span></strong> <br>And  Status Changed To  <b>   " +fl+ " </b></ol> ";
                  }

                  mainaction +=
                    '<tr><td><strong class="trinstrong1">' +
                    toname[k] +
                    ' <span class="trinspam">(' +
                    capitalizeFirstLetter(dataarray["vlevel"][k]) +
                    " - " +
                    dataarray["ovstatus"][k] +
                    ")</span></strong></td><td>" +
                    hh +
                    '</td><td><strong class="trinstrong1">' +
                    fl +
                    "</strong></td></tr>";
                } else {
                  //district and subdistrict code rename
                  totalvcount = totalvcount + 1;
                  vflag = "(" + dataarray["applyon"] + ")";
                  fromnamenew =
                    '<strong class="trinstrong">' +
                    dataarray["newnamecheck"][k] +
                    "</strong>";
                  // fmsg +=  " <ol>(Total - " + totalvcount + " ) <strong> " + vflag + ' - <span class="trinstrong1">' +toname[k]+ "</span></strong>  Renamed as " +  fromnamenew + " </ol>";
                  mainaction +=
                    '<tr><td><strong class="trinstrong1">' +
                    toname[k] +
                    ' <span class="trinspam">(' +
                    dataarray["applyon"] +
                    ')</span></strong></td><td><strong class="trinstrong">' +
                    dataarray["newnamecheck"][k] +
                    ' <span class="trinspam">(' +
                    dataarray["applyon"] +
                    ")</span></strong></td></tr>";
                }
              }
            }

            mainaction += "</tbody></table>";

            $("#maintitledata").html(fmsg);

            $("#mainaction").html(mainaction);
            // $('#maintitledata').html(mainaction);

            $("#viewerlast").css("display", "block");
            $("#clickbutton").val(dataarray["clickpopup"]);
            $("#pdf").css("display", "block");
            var filename = $("#viewerlast")
              .contents()
              .get(0)
              .location.href.replace(/^.*[\\\/]/, "");
            // console.log(filename);
            $("#docname").text(decodeURIComponent(filename));
            $("#viewerlaststep").attr(
              "src",
              $("#viewerlast").contents().get(0).location.href
            );

            $("#nextstep3").css("visibility", "visible");
            $("#progressbarwizard1").bootstrapWizard("next");
            return false;
          } else if ($("#clickpopup").val() == "Deletion") {
            var dataarray = JSON.parse(res[1]);
            //   console.log(res);
            //   console.log(res[1]);
            //     console.log(dataarray);

            $("#addnewdocument .close").click();

            if (dataarray["applyon"] == "Village / Town") {
              lableof = "Village(s) / Town";
              mainaction +=
                '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> Existing - ' +
                lableof +
                "(s)</th><th> Delete </th><th>Status Change</th></tr></thead><tbody>";
            } else {
              lableof = dataarray["applyon"];

              mainaction +=
                '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> Existing - ' +
                lableof +
                "(s)</th><th> Delete </th></tr></thead><tbody>";
            }
          }
          //Reshuffle code for Sub District modified by Rithisha
          else if ($("#clickpopup").val() == "Reshuffle") {
            var dataarray = JSON.parse(res[1]);
            //   console.log(dataarray);
            var fmsg = "";
            var totalvcount = 0;
            var vnames = "";
            var vflag = "";

            $("#addnewdocument .close").click();

            $("#finaldata").val(res[1]);
            var mainaction = "";
            dataarray["applyon"] == "Sub District(s)";
            {
              mainaction +=
                '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> Existing -Sub District(s)</th><th> Moved / Reshuffled </th></tr></thead><tbody>';
            }

            namefromtext = dataarray["namefromtext"].split(",");

            for (var k = 0; k < dataarray["namefrom"].length; k++) {
              var name = "";

              totalvcount = totalvcount + 1;
              name = namefromtext[k];
              vnames += name + ", ";
              vflag = "Sub District(s)";
              //       createddata =dataarray['namefromtext']+'<span class="trinspam">('+capitalizeFirstLetter(dataarray['ostate'][0])+')</span>, ';
            }

            //modified by sahana status moved/reshuffled subdistrict
            fromnamenew =
              '<strong class="trinstrong"><strong><span class="trinspam">District: </span></strong>' +
              dataarray["namefrompre"] +
              "</strong>";
            vnames = vnames.slice(0, -2);

            fmsg =
              "(Total - " +
              totalvcount +
              " ) <strong> " +
              vflag +
              ' - <span class="trinstrong1">' +
              vnames +
              "</span></strong> <br> Moved / Reshuffled to <br>" +
              fromnamenew +
              "";
            $("#mainaction").html("");

            $("#maintitledata").html(fmsg);

            mainaction +=
              '<tr><td><strong><span class="trinspam">' +
              dataarray["applyon"] +
              ':</span></strong> <strong class="trinstrong1">' +
              vnames +
              ' </strong></td><td><strong class="trinstrong">' +
              fromnamenew +
              " </strong></td></tr>";

            mainaction += "</tbody></table>";

            $("#maintitledata").html(fmsg);

            $("#mainaction").html(mainaction);

            $("#viewerlast").css("display", "block");
            $("#clickbutton").val(dataarray["clickpopup"]);
            $("#pdf").css("display", "block");
            var filename = $("#viewerlast")
              .contents()
              .get(0)
              .location.href.replace(/^.*[\\\/]/, "");
            // console.log(filename);
            $("#docname").text(decodeURIComponent(filename));
            $("#viewerlaststep").attr(
              "src",
              $("#viewerlast").contents().get(0).location.href
            );

            $("#nextstep3").css("visibility", "visible");
            $("#progressbarwizard1").bootstrapWizard("next");
            return false;
          } else {
            // Command: toastr["success"]("Successfully added "+res[2]+".");

            $("#addnewdocument .close").click();
            if (res[6] != "true") {
              var idscount = res[4] - 1;

              var tes = "";
              for (var j = 0; j <= idscount; j++) {
                tes += "#addlinksDTID_" + j + ",";
              }
              var n = tes.replace(/,\s*$/, "");

              $("#daynamor").html("");
              $("#daynamor").html(res[3]);
              $(".haveapartially").prop("disabled", true);
              $("" + n + "").multiSelect({
                selectableHeader:
                  "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                selectionHeader:
                  "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
                afterInit: function (t) {
                  var e = this,
                    n = e.$selectableUl.prev(),
                    a = e.$selectionUl.prev(),
                    i =
                      "#" +
                      e.$container.attr("id") +
                      " .ms-elem-selectable:not(.ms-selected)",
                    s =
                      "#" +
                      e.$container.attr("id") +
                      " .ms-elem-selection.ms-selected";
                  (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
                    if (40 === t.which) return e.$selectableUl.focus(), !1;
                  })),
                    (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                      if (40 == t.which) return e.$selectionUl.focus(), !1;
                    }));
                },
                afterSelect: function (values) {
                  //  console.log(this);

                  var check = this.$container.attr("id");
                  var checkdata = check.split("_");

                  this.qs1.cache(), this.qs2.cache();
                  var data = [];
                  var data1 = [];
                  var $el = $("#ms-addlinksDTID_" + checkdata[1] + "");
                  $("#totaldefultselected_" + checkdata[1] + "").html(
                    $el.find('[class*="ms-elem-selection ms-selected"]').length
                  );
                  //  alert($el.find('[class*="ms-elem-selection"]').length);
                  $el
                    .find('[class*="ms-elem-selection ms-selected"]')
                    .each(function () {
                      data.push($(this).text());
                      var ii = this.id;
                      var idd = ii.split("-");
                      //  var idddata = idd[0].join("-selectable")
                      data1.push(idd[0]);
                    });

                  // && $.inArray( $(this).text(), data1 )!= -1

                  for (var m = 0; m <= idscount; m++) {
                    if (checkdata[1] != m) {
                      $("#ms-addlinksDTID_" + m + "")
                        .find('[class*="ms-elem-selectable"]')
                        .each(function () {
                          var j = this.id.split("-");
                          if (
                            $.inArray($(this).text(), data) != -1 &&
                            $.inArray(j[0], data1) != -1
                          ) {
                            $(this).addClass("disabled");
                          }
                        });
                    }
                  }

                  if (this.qs2.matchedResultsCount != 0) {
                    $("#" + checkdata[1] + "").prop("disabled", false);
                  } else {
                    $("#" + checkdata[1] + "").prop("disabled", true);
                  }
                },
                afterDeselect: function () {
                  var check = this.$container.attr("id");
                  var checkdata = check.split("_");

                  var data = [];
                  var $el = $("#ms-addlinksDTID_" + checkdata[1] + "");

                  $("#totaldefultselected_" + checkdata[1] + "").html(
                    $el.find('[class*="ms-elem-selection ms-selected"]').length
                  );

                  $el
                    .find('[class*="ms-elem-selection ms-selected"]')
                    .each(function () {
                      data.push($(this).text());
                    });

                  for (var m = 0; m <= idscount; m++) {
                    if (checkdata[1] != m) {
                      $("#ms-addlinksDTID_" + m + "")
                        .find('[class*="ms-elem-selectable"]')
                        .each(function () {
                          if ($.inArray($(this).text(), data) == -1) {
                            $(this).removeClass("disabled");
                          }
                        });
                    }
                  }

                  this.qs1.cache(), this.qs2.cache();
                  if (this.qs2.matchedResultsCount != 0) {
                    $("#" + checkdata[1] + "").prop("disabled", false);
                  } else {
                    $("#" + checkdata[1] + "").prop("disabled", true);
                  }
                },
              });

              $(".disbut").attr("disabled", "disabled");
              $('input[name="startfrom"]').attr("disabled", "disabled");

              if (res[2] != "State") {
                $('input[name="startfrom"]').prop("required", false);
              } else {
                $('input[name="startfrom"]').prop("required", true);
              }

              $("#returndata").val(res[1]);
              $("#clickbuttonmid").val(res[5]);
              $("#nextstep2").css("visibility", "visible");
              $("#backbtnnew").css("visibility", "hidden");
            } else {
              var returndata = JSON.parse(res[1]);
              // JIGAR
              var fromnamenew = "";
              if (returndata["flag"] == "newname") {
                fromnamenew =
                  '<strong class="trinstrong">' +
                  capitalizeFirstLetter(returndata["namefromtext"]) +
                  "</strong>";
                //modified by sahana  Full Merge summary message.
                fmsg =
                  "(Total - 1 ) <strong>New  " +
                  returndata["comefromcheck"] +
                  '(s) - <span class="trinstrong1">' +
                  returndata["newname"][0] +
                  '</span></strong>  <br> Created from <br><strong><span class="trinspam">' +
                  returndata["comefromcheck"] +
                  "(s) :</span></strong> " +
                  fromnamenew +
                  "&nbsp;Using Full Merge Action";

                var maintitaldata = fmsg;
                $("#maintitledata").html(maintitaldata);
              } else {
                namefromtext = returndata["namefromtext"].split(",");
                for (var k = 0; k < returndata["namefrom"].length; k++) {
                  fromnamenew +=
                    '<strong class="trinstrong">' +
                    namefromtext[k] +
                    ' </strong> - <strong><span class="trinspam">' +
                    returndata["action"][k] +
                    ", </span></strong> "; //modified by sahana JC_41
                }

                fromnamenew = fromnamenew.slice(0, -2);
                fmsg =
                  "(Total - 1 ) <strong>New  " +
                  returndata["comefromcheck"] +
                  '(s) - <span class="trinstrong1">' +
                  returndata["newname"][0] +
                  '</span></strong>  <br> Created from <br><strong><span class="trinspam">' +
                  returndata["comefromcheck"] +
                  "(s) :</span></strong> " +
                  fromnamenew +
                  "";

                // JIGARGOHEL

                var maintitaldata = fmsg;
                $("#maintitledata").html(maintitaldata);
                // JIGARGOHEL
              }
              // return false;

              $(".disbut").attr("disabled", "disabled");
              $("#finaldata").val(res[1]);
              $("#clickbutton").val(res[5]);

              $("#viewerlast").css("display", "block");
              $("#pdf").css("display", "block");
              var filename = $("#viewerlast")
                .contents()
                .get(0)
                .location.href.replace(/^.*[\\\/]/, "");
              // console.log(filename);
              $("#docname").text(decodeURIComponent(filename));
              $("#viewerlaststep").attr(
                "src",
                $("#viewerlast").contents().get(0).location.href
              );
              //  $('#uploadeddocumentmrg').val(dataarray['uploadeddocumentmrg']);
              $("#nextstep3").css("visibility", "visible");
              $("#progressbarwizard1").bootstrapWizard("next");
            }

            //////

            return false;
          }
        }

        //Defect_JC_58 modified by sahana
        else if (res[0] == "adddatavt") {
          if (
            $("#clickpopup").val() == "Merge" ||
            $("#clickpopup").val() == "Partiallysm"
          ) {
            $("#addnewdocument .close").click();

            var dataarray = JSON.parse(res[1]);
            var resArray = JSON.parse(res[7]);

            $(".disbut").attr("disabled", "disabled");
            $("#finaldata").val(res[1]);
            $("#clickbutton").val(dataarray["clickpopup"]);

            var totalvcount = 0;
            var totaltcount = 0;
            var vnames = "";
            var tnames = "";
            var vflag = "";
            var tflag = "";
            var flagofmerge = "";
            var createddata = "";
            var vs = "";
            var k = "";

            if (dataarray["flag"] == "newname") {
              for (k = 0; k < dataarray["namefrom"].length; k++) {
                dataarray["namefrom"] = dataarray["namefromtext"].split(",");

                var name = "";

                if (
                  dataarray["action"] == "Merge" ||
                  dataarray["action"] == "Partially Merge"
                ) {
                  if (resArray[0][k]["Level"] == "VILLAGE") {
                    //modified by sahana 0509
                    totalvcount = totalvcount + 1;
                    vnames +=
                      dataarray["namefrom"][k] +
                      '&nbsp<span class="trinspam">- ' +
                      dataarray["action"] +
                      "d&nbsp</span>";
                    vflag = "Village(s)";
                  } else {
                    totaltcount = totaltcount + 1;
                    name = dataarray["nametotext"];
                    tnames +=
                      dataarray["namefrom"][k] +
                      '&nbsp<span class="trinspam">- ' +
                      dataarray["action"] +
                      "d&nbsp</span>";
                    tflag = "Town(s)";
                  }
                }
                //modidied by sahana Partially Split & Merge Defect_JC_97
                else if (dataarray["action"] == "Partially Split & Merge") {
                  if (resArray[0][k]["Level"] == "VILLAGE") {
                    //modified by sahana 0509
                    totalvcount = totalvcount + 1;
                    vnames +=
                      dataarray["namefrom"][k] +
                      '&nbsp<span class="trinspam">- ' +
                      dataarray["action"] +
                      "d&nbsp</span>";
                    vflag = "Village(s)";
                  } else {
                    totaltcount = totaltcount + 1;
                    name = dataarray["nametotext"];
                    tnames +=
                      dataarray["namefrom"][k] +
                      '&nbsp<span class="trinspam">-' +
                      dataarray["action"] +
                      "d&nbsp</span>";
                    tflag = "Town(s)";
                  }
                } else {
                  if (resArray[0][k]["Level"] == "VILLAGE") {
                    //modified by sahana 0509
                    totalvcount = totalvcount + 1;
                    vnames +=
                      dataarray["namefrom"][k] +
                      '&nbsp<span class="trinspam">- ' +
                      dataarray["action"] +
                      "d&nbsp</span>";
                    vflag = "Village(s)";
                  } else {
                    totaltcount = totaltcount + 1;
                    name = dataarray["nametotext"];
                    tnames +=
                      dataarray["namefrom"][k] +
                      '&nbsp<span class="trinspam">-' +
                      dataarray["action"] +
                      "d&nbsp</span>";
                    tflag = "Town(s)";
                  }
                }

                createddata = dataarray["nametotext"] + ", ";

                //modidied by sahana Partially Split & Merge Defect_JC_97

                if (
                  dataarray["action"] == "Merge" ||
                  dataarray["action"] == "Partially Merge"
                ) {
                  if (
                    dataarray["vStateStatus"][0] == dataarray["vlevel"][0] &&
                    dataarray["ovstatus"][0] == dataarray["vstatus"][0]
                  ) {
                    //modified by sahana 0509
                    vs = dataarray["vStateStatus"][0];
                  } else {
                    vs = "Now " + dataarray["vStateStatus"][0];
                  }
                } else {
                  if (dataarray["vStateStatus"][0] == dataarray["vlevel"][0]) {
                    //modified by sahana 0509
                    vs = dataarray["vStateStatus"][0];
                  } else {
                    vs = "Now " + dataarray["vStateStatus"][0];
                  }
                }
              } // end of for
            } // end of if
            else {
              var namefromSets = JSON.parse(res[7]);
              for (
                var setIndex = 0;
                setIndex < namefromSets.length;
                setIndex++
              ) {
                var namefromSet = namefromSets[setIndex];
                var namefromaction = dataarray["action"][setIndex];

                for (
                  var elementIndex = 0;
                  elementIndex < namefromSet.length;
                  elementIndex++
                ) {
                  if (
                    namefromaction == "Merge" ||
                    namefromaction == "Partially Merge"
                  ) {
                    if (
                      resArray[setIndex][elementIndex]["Level"] == "VILLAGE"
                    ) {
                      totalvcount = totalvcount + 1;
                      vnames +=
                        (vnames ? ", " : "") +
                        resArray[setIndex][elementIndex]["VTName"] +
                        '&nbsp<span class="trinspam">-' +
                        namefromaction +
                        "d&nbsp</span>";
                      vflag = "Village(s)";
                    } else {
                      totaltcount = totaltcount + 1;
                      name = dataarray["nametotext"];
                      tnames +=
                        (tnames ? ", " : "") +
                        resArray[setIndex][elementIndex]["VTName"] +
                        '&nbsp<span class="trinspam">-' +
                        namefromaction +
                        "d&nbsp</span>";
                      tflag = "Town(s)";
                    }
                  } else {
                    if (
                      resArray[setIndex][elementIndex]["Level"] == "VILLAGE"
                    ) {
                      totalvcount = totalvcount + 1;
                      vnames +=
                        (vnames ? ", " : "") +
                        resArray[setIndex][elementIndex]["VTName"] +
                        '&nbsp<span class="trinspam">-' +
                        namefromaction +
                        "d&nbsp</span>";
                      vflag = "Village(s)";
                    } else {
                      totaltcount = totaltcount + 1;
                      name = dataarray["nametotext"];
                      tnames +=
                        (tnames ? ", " : "") +
                        resArray[setIndex][elementIndex]["VTName"] +
                        '&nbsp<span class="trinspam">-' +
                        namefromaction +
                        "d&nbsp</span>";
                      tflag = "Town(s)";
                    }
                  }

                  createddata = dataarray["nametotext"] + ", ";
                  for (var i = 0; i < dataarray["vStateStatus"].length; i++) {
                    if (
                      dataarray["vStateStatus"][i].trim() ===
                      dataarray["vlevel"][i].trim()
                    ) {
                      vs = dataarray["vStateStatus"];
                    } else {
                      vs = "Now " + dataarray["vStateStatus"];
                    }
                  }
                } //for 2nd
              } //for 1st
            } // else

            createddata = createddata.slice(0, -2);
            //modified by sahana status merge village
            if (dataarray["vlevel"] == "VILLAGE") {
              $sahana = "Village";
            } else {
              $sahana = "Town";
            }
            fromnamenew =
              '<strong><span class="trinspam">' +
              $sahana +
              ': </strong></span><strong class="trinstrong">' +
              createddata +
              '<span class="trinspam"> (' +
              vs +
              " - " +
              dataarray["vstatus"] +
              ")</span></strong>";

            vnames = vnames.slice(0, -2);
            tnames = tnames.slice(0, -2);

            //Partially Split & Merged issue code changes by Gokul,Sahana and Yogesh
            if (totalvcount != 0 && totaltcount == 0) {
              fmsg =
                "(Total - " +
                totalvcount +
                " ) <strong>" +
                vflag +
                ' - <span class="trinstrong1">' +
                vnames +
                "</span></strong> <br> into <br> " +
                fromnamenew +
                "";
            } else if (totalvcount == 0 && totaltcount != 0) {
              fmsg =
                "(Total - " +
                totaltcount +
                " ) <strong>" +
                tflag +
                ' - <span class="trinstrong1">' +
                tnames +
                "</span></strong>  <br> into <br> " +
                fromnamenew +
                "";
            } else {
              fmsg =
                "(Total - " +
                totalvcount +
                " ) <strong>" +
                vflag +
                ' - <span class="trinstrong1">' +
                vnames +
                "</span></strong><br> AND <br> (Total - " +
                totaltcount +
                " ) <strong>" +
                tflag +
                ' - <span class="trinstrong1">' +
                tnames +
                "</span></strong>  <br> into <br> " +
                fromnamenew +
                "";
            }

            //fmsg = '(Total - '+namefromtext.length+' ) <strong>Village(s) / Town(s) - <span class="trinstrong1">'+dataarray['namefromtext']+'</span></strong>  <br>Merged / Partially Merged into <br> '+fromnamenew+'';

            $("#mainaction").html("");
            if (dataarray["newnamecheck"][0] != "") {
              //modified by sahana status merge village
              fmsg =
                fmsg +
                ' <br> AND <br> <strong><span class="trinspam"></strong></span>' +
                fromnamenew +
                ' name changed to <strong class="trinstrong">' +
                dataarray["newnamecheck"][0] +
                '<span class="trinspam"> (' +
                vs +
                " - " +
                dataarray["vstatus"] +
                ")</span></strong>"; //modified by sahana JC_41
            }

            $("#maintitledata").html(fmsg);

            $("#viewerlast").css("display", "block");
            $("#pdf").css("display", "block");
            var filename = $("#viewerlast")
              .contents()
              .get(0)
              .location.href.replace(/^.*[\\\/]/, "");
            // console.log(filename);
            $("#docname").text(decodeURIComponent(filename));
            $("#viewerlaststep").attr(
              "src",
              $("#viewerlast").contents().get(0).location.href
            );
            //  $('#uploadeddocumentmrg').val(dataarray['uploadeddocumentmrg']);
            $("#nextstep3").css("visibility", "visible");
            $("#progressbarwizard1").bootstrapWizard("next");
            return false;
          } //end of if
          else if ($("#clickpopup").val() == "Rename") {
            var dataarray = JSON.parse(res[1]);
            //   console.log(res);
            //   console.log(res[1]);
            //   console.log(dataarray);
            $("#addnewdocument .close").click();
            $("#finaldata").val(res[1]);
            var toname = dataarray["nametotext"].split(",");
            var main = "";
            for (var k = 0; k < dataarray["newnamecheck"].length; k++) {
              main +=
                " <strong>" +
                toname[k] +
                "</strong> " +
                dataarray["comefromcheck"] +
                " Rename as <strong>" +
                dataarray["newnamecheck"][k] +
                "</strong> and";
            }
            var main1 = main.slice(0, -4);
            //  var maintitaldata = '<strong>'+capitalizeFirstLetter(dataarray['namefromtext'])+'</strong> '+dataarray['comefromcheck']+' '+dataarray['action'][0]+'d into <strong>'+capitalizeFirstLetter(dataarray['nametotext'])+'</strong> '+dataarray['comefromcheck'];

            $("#maintitledata").html(main1);

            $("#viewerlast").css("display", "block");
            $("#clickbutton").val(dataarray["clickpopup"]);
            $("#pdf").css("display", "block");
            var filename = $("#viewerlast")
              .contents()
              .get(0)
              .location.href.replace(/^.*[\\\/]/, "");
            // console.log(filename);
            $("#docname").text(decodeURIComponent(filename));
            $("#viewerlaststep").attr(
              "src",
              $("#viewerlast").contents().get(0).location.href
            );

            $("#nextstep3").css("visibility", "visible");
            $("#progressbarwizard1").bootstrapWizard("next");
            return false;
          } else {
            $("#addnewdocument .close").click();
            var totalvcount = 0;
            var totaltcount = 0;
            var vnames = "";
            var tnames = "";
            var vflag = "";
            var tflag = "";
            var createddata = "";
            var dataarray = JSON.parse(res[1]);
            //  console.log(dataarray);

            $("#finaldata").val(res[1]);
            $("#clickbutton").val(res[5]);

            if (res[5] == "Addition") {
              //   console.log(dataarray);

              for (var k = 0; k < dataarray["newname"].length; k++) {
                var name = "";
                if (dataarray["vStateStatus"][k] == "VILLAGE") {
                  totalvcount = totalvcount + 1;
                  name = dataarray["newname"][k];
                  vnames += name + "(" + dataarray["vstatus"][k] + "), ";
                  vflag = "Village(s)";
                  //       createddata =dataarray['namefromtext']+'<span class="trinspam">('+capitalizeFirstLetter(dataarray['ostate'][0])+')</span>, ';
                } else {
                  totaltcount = totaltcount + 1;
                  name = dataarray["newname"][k];
                  tnames += name + "(" + dataarray["vstatus"][k] + "), ";
                  tflag = "Town(s)";
                  //                     createddata =dataarray['namefromtext']+'<span class="trinspam">('+capitalizeFirstLetter(dataarray['ostate'][0])+')</span>, ';
                }
              }

              //  var j = dataarray['comefromcheck'].split(' / ');

              //  createddata = createddata.slice(0, -2);
              fromnamenew =
                '<strong class="trinstrong">' + createddata + "</strong>";
              vnames = vnames.slice(0, -2);
              tnames = tnames.slice(0, -2);

              if (totalvcount != 0 && totaltcount == 0) {
                fmsg =
                  "(Total - " +
                  totalvcount +
                  " ) <strong>New  " +
                  vflag +
                  ' - <span class="trinstrong1">' +
                  vnames +
                  "</span></strong> <br> Added.";
              } else if (totalvcount == 0 && totaltcount != 0) {
                fmsg =
                  "(Total - " +
                  totaltcount +
                  " ) <strong>New  " +
                  tflag +
                  ' - <span class="trinstrong1">' +
                  tnames +
                  "</span></strong>  <br> Added.";
              } else {
                fmsg =
                  "(Total - " +
                  totalvcount +
                  " ) <strong>New  " +
                  vflag +
                  ' - <span class="trinstrong1">' +
                  vnames +
                  "</span></strong><br> AND <br> (Total - " +
                  totaltcount +
                  " ) <strong>New  " +
                  tflag +
                  ' - <span class="trinstrong1">' +
                  tnames +
                  "</span></strong>  <br> Added.";
              }

              // var mainaction = 'Created from '+dataarray['comefromcheck']+' <strong>'+capitalizeFirstLetter(dataarray['namefromtext'])+'</strong>';
              $("#mainaction").html("");

              // var fmsg = '<strong>New '+j[0]+'(s) / '+j[1]+'(s) formed</strong> - <strong>'+capitalizeFirstLetter(dataarray['newname'].join(","));+'</strong>';
              //  $('#mainaction').html('');
            }

            //Modified by sahana for Level and status of villge or town.
            //Reshuffle code for village/town modified by Rithisha
            else if (res[5] == "Reshuffle") {
              var mainaction = "";

              mainaction +=
                '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> Existing - Village(s) / Town(s)</th><th> Moved / Reshuffled </th></tr></thead><tbody>';

              namefromtext = dataarray["namefromtext"].split(",");
              var namefromSets = JSON.parse(res[7]);
              if (namefromSets.length == 1) {
                for (var pinky = 0; pinky < namefromSets.length; pinky++) {
                  var namefromSet = namefromSets[pinky];
                  for (var sahana = 0; sahana < namefromSet.length; sahana++) {
                    var name = "";
                    if (namefromSet[sahana]["Level"] == "VILLAGE") {
                      totalvcount = totalvcount + 1;
                      name = namefromtext[sahana];
                      vnames += name + ", ";
                      vflag = "Village(s)";
                    } else {
                      totaltcount = totaltcount + 1;
                      name = namefromtext[sahana];
                      tnames += name + ", ";
                      tflag = "Town(s)";
                    }
                  }
                }
              } else {
                for (var pinky = 0; pinky < namefromSets.length; pinky++) {
                  var namefromSet = namefromSets[pinky];

                  for (var sahana = 0; sahana < namefromSet.length; sahana++) {
                    var okay = namefromSet[sahana];
                    var name = "";
                    if (okay["Level"] == "VILLAGE") {
                      totalvcount = totalvcount + 1;
                      name = okay["VTName"];
                      vnames += name + ", ";
                      vflag = "Village(s)";
                    } else {
                      totaltcount = totaltcount + 1;
                      name = okay["VTName"];
                      tnames += name + ", ";
                      tflag = "Town(s)";
                    }
                  }
                }
              }

              createddata = createddata.slice(0, -2);
              fromnamenew =
                '<strong class="trinstrong">' +
                dataarray["namefrompre"] +
                "</strong>";
              vnames = vnames.slice(0, -2);
              tnames = tnames.slice(0, -2);

              if (totalvcount != 0 && totaltcount == 0) {
                fmsg =
                  "(Total - " +
                  totalvcount +
                  " ) <strong> " +
                  vflag +
                  ' - <span class="trinstrong1">' +
                  vnames +
                  "</span></strong> <br> Move / Reshuffled to <br><strong>Sub-District: </strong>" +
                  fromnamenew +
                  "";
              } else if (totalvcount == 0 && totaltcount != 0) {
                fmsg =
                  "(Total - " +
                  totaltcount +
                  " ) <strong> " +
                  tflag +
                  ' - <span class="trinstrong1">' +
                  tnames +
                  "</span></strong>  <br> Move / Reshuffled to <br><strong>Sub-District: </strong>" +
                  fromnamenew +
                  "";
              } else {
                fmsg =
                  "(Total - " +
                  totalvcount +
                  " ) <strong> " +
                  vflag +
                  ' - <span class="trinstrong1">' +
                  vnames +
                  "</span></strong><br> AND <br> (Total - " +
                  totaltcount +
                  " ) <strong> " +
                  tflag +
                  ' - <span class="trinstrong1">' +
                  tnames +
                  "</span></strong>  <br> Move / Reshuffled to <br><strong>Sub-District: </strong>" +
                  fromnamenew +
                  "";
              }

              if (vnames && !tnames) {
                mainaction +=
                  '<tr><td><strong><span class="trinspam">Village(s): </span></strong><strong class="trinstrong1">' +
                  vnames +
                  " </strong></td><td><strong>Sub-District: </strong>" +
                  fromnamenew +
                  "</td></tr>";
              } else if (tnames && !vnames) {
                mainaction +=
                  '<tr><td><strong><span class="trinspam">Town(s): </span></strong><strong class="trinstrong1">' +
                  tnames +
                  " </strong></td><td><strong>Sub-District: </strong>" +
                  fromnamenew +
                  "</td></tr>";
              } else {
                mainaction +=
                  '<tr><td><strong><span class="trinspam">Village(s): </span></strong><strong class="trinstrong1">' +
                  vnames +
                  '</strong><br><strong><span class="trinspam">Town(s): </span></strong><strong class="trinstrong1">' +
                  tnames +
                  "</strong> </td><td><strong>Sub-District: </strong>" +
                  fromnamenew +
                  "</td></tr>";
              }

              $("#mainaction").html("");
              $("#mainaction").html(fmsg);
              mainaction += "</tbody></table>";
              $("#maintitledata").html(fmsg);
              $("#mainaction").html(mainaction);
            }

            //modified by sahana 0509 loop issue
            //Deletion code to display summary modified by Rithisha
            else if (res[5] == "Deletion") {
              //  else if($('#clickpopup').val()=='Deletion'){

              var dataarray = JSON.parse(res[1]);
              $("#addnewdocument .close").click();
              var name = "";
              if (dataarray["applyon"] == "Village / Town") {
                lableof = "Village / Town";
                name =
                  '<strong class="trinstrong">' +
                  dataarray["nametotext"] +
                  "</strong>";

                fmsg =
                  " <strong>" +
                  lableof +
                  ' - &nbsp<span class="trinstrong1">' +
                  name +
                  "</span></strong>  <br> Deleted  <br>";
              }
            } else {
              //modified by sahana 1 to many village creation
              if (
                dataarray["flag"] === "newname" &&
                dataarray["newname"] !== null &&
                Array.isArray(dataarray["newname"]) &&
                dataarray["newname"].length > 1 &&
                "namefrom" in dataarray &&
                dataarray["namefrom"].length === 1
              ) {
                var fromnamenew = "";
                var vflag = "";
                var createddata = "";

                for (var k = 0; k < dataarray["newname"].length; k++) {
                  var name = dataarray["newname"][k];
                  if (dataarray["vStateStatus"][k] == "VILLAGE") {
                    totalvcount = totalvcount + 1;

                    if (vnames !== "") {
                      vnames += ", ";
                    }

                    vnames += name + "(" + dataarray["vstatus"][k] + ")";
                    vflag = "Village(s)";
                  } else {
                    totaltcount = totaltcount + 1;

                    if (tnames !== "") {
                      tnames += ", ";
                    }

                    tnames += name + "(" + dataarray["vstatus"][k] + ")";
                    tflag = "Town(s)";
                  }
                }
                var namefromSets = JSON.parse(res[7]);
                var namefromaction = dataarray["action"][0];

                for (
                  var elementIndex = 0;
                  elementIndex < namefromSets[0].length;
                  elementIndex++
                ) {
                  createddata =
                    namefromSets[0][elementIndex]["VTName"] +
                    "-(" +
                    namefromSets[0][elementIndex]["Status"] +
                    ")" +
                    '<span class="trinspam"> - ' +
                    namefromaction +
                    "</span>";
                  fromnamenew +=
                    '<strong><span class="trinspam">' +
                    capitalizeFirstLetter(
                      namefromSets[0][elementIndex]["Level"]
                    ) +
                    ': </span></strong><strong class="trinstrong">' +
                    createddata +
                    "</strong>";
                }
              }

              //modified by sahana in village level for differentiating split and full merge 1-1 and m-1
              else if (dataarray["flag"] == "newname") {
                var fromnamenew = "";
                var namefromSets = JSON.parse(res[7]);

                var vflag, createddata;

                for (var k = 0; k < namefromSets.length; k++) {
                  var namefromaction = dataarray["action"][k];
                  for (
                    var elementIndex = 0;
                    elementIndex < namefromSets[k].length;
                    elementIndex++
                  ) {
                    createddata =
                      namefromSets[k][elementIndex]["VTName"] +
                      '<span class="trinspam"> - ' +
                      namefromaction +
                      "</span>";
                    fromnamenew +=
                      '<strong class="trinstrong">' + createddata + "</strong>";

                    if (elementIndex < namefromSets[k].length - 1) {
                      fromnamenew += ", ";
                    }
                  }
                }

                var name = dataarray["newname"][0];
                if (dataarray["vStateStatus"] == "VILLAGE") {
                  totalvcount = totalvcount + 1;
                  vnames += name + "(" + dataarray["vstatus"][0] + ")";
                  vflag = "Village(s)";
                } else {
                  totaltcount = totaltcount + 1;
                  tnames += name + "(" + dataarray["vstatus"][0] + ")";
                  tflag = "Town(s)";
                }
              }
              //modified by sahana JC_09 village level split and full merge summary.
              else {
                var namefromSets = JSON.parse(res[7]);
                var fromnamenew = "";

                for (
                  var setIndex = 0;
                  setIndex < namefromSets.length;
                  setIndex++
                ) {
                  var namefromSet = namefromSets[setIndex];
                  var namefromaction = dataarray["action"][setIndex];

                  for (
                    var elementIndex = 0;
                    elementIndex < namefromSet.length;
                    elementIndex++
                  ) {
                    var name = dataarray["newname"][0];
                    totalvcount = 1;
                    vnames = name + " (" + dataarray["vstatus"][0] + ")";
                    vflag1 = capitalizeFirstLetter(
                      dataarray["vStateStatus"][0]
                    );
                    vflag = vflag1 + "(s)";

                    fromnamenew +=
                      '<strong class="trinstrong">' +
                      namefromSet[elementIndex]["VTName"] +
                      '<span class="trinspam"> - ' +
                      namefromaction +
                      "</span></strong>";

                    if (elementIndex < namefromSet.length - 1) {
                      fromnamenew += ", ";
                    }
                  }

                  fromnamenew += " , ";
                }

                if (fromnamenew.endsWith(" , ")) {
                  fromnamenew = fromnamenew.substring(
                    0,
                    fromnamenew.length - 3
                  );
                }
              }

              //modified by sahana Split, Full Merge summary message in village level.
              if (totalvcount != 0 && totaltcount == 0) {
                if (
                  dataarray["action"].includes("Split") &&
                  dataarray["action"].includes("Full Merge")
                ) {
                  fmsg =
                    "(Total - " +
                    totalvcount +
                    ") <strong>New " +
                    vflag +
                    ' - <span class="trinstrong1">' +
                    vnames +
                    "</span></strong> <br> Created from <br> " +
                    fromnamenew;
                } else if (dataarray["action"].includes("Split")) {
                  fmsg =
                    "(Total - " +
                    totalvcount +
                    ") <strong>New " +
                    vflag +
                    ' - <span class="trinstrong1">' +
                    vnames +
                    "</span></strong> <br> Created from <br> " +
                    fromnamenew;
                } else if (dataarray["action"].includes("Full Merge")) {
                  fmsg =
                    "(Total - " +
                    totalvcount +
                    ") <strong>New " +
                    vflag +
                    ' - <span class="trinstrong1">' +
                    vnames +
                    "</span></strong> <br> Created from <br> " +
                    fromnamenew;
                }
              }

              //modified by sahana Split, Full Merge summary message in town level.
              else if (totalvcount == 0 && totaltcount != 0) {
                if (
                  dataarray["action"].includes("Split") &&
                  dataarray["action"].includes("Full Merge")
                ) {
                  fmsg =
                    "(Total - " +
                    totaltcount +
                    ") <strong>New " +
                    tflag +
                    ' - <span class="trinstrong1">' +
                    tnames +
                    "</span></strong> <br> Created from <br> " +
                    fromnamenew;
                } else if (dataarray["action"].includes("Split")) {
                  fmsg =
                    "(Total - " +
                    totaltcount +
                    ") <strong>New " +
                    tflag +
                    ' - <span class="trinstrong1">' +
                    tnames +
                    "</span></strong> <br> Created from <br> " +
                    fromnamenew;
                } else if (dataarray["action"].includes("Full Merge")) {
                  fmsg =
                    "(Total - " +
                    totaltcount +
                    ") <strong>New " +
                    tflag +
                    ' - <span class="trinstrong1">' +
                    tnames +
                    "</span></strong> <br> Created from <br> " +
                    fromnamenew;
                }
              }
              //modified by sahana creation of village one to many
              else {
                fmsg =
                  "(Total - " +
                  totalvcount +
                  ") <strong>New " +
                  vflag +
                  ' - <span class="trinstrong1">' +
                  vnames +
                  "</span></strong> <br> AND <br> (Total - " +
                  totaltcount +
                  ") <strong>New " +
                  tflag +
                  ' - <span class="trinstrong1">' +
                  tnames +
                  "</span></strong> <br> Created from <br> " +
                  fromnamenew;
              }

              // else if(totalvcount==0 && totaltcount!=0)
              // {

              // fmsg = '(Total - '+totaltcount+' ) <strong>Deleted  '+tflag+' - <span class="trinstrong1">'+tnames+'</span></strong>  <br> Deleted from <br> '+fromnamenew+'';

              // }

              // var mainaction = 'Created from '+dataarray['comefromcheck']+' <strong>'+capitalizeFirstLetter(dataarray['namefromtext'])+'</strong>';
              $("#mainaction").html("");
            }

            $("#maintitledata").html(fmsg);

            $("#viewerlast").css("display", "block");
            $("#pdf").css("display", "block");
            var filename = $("#viewerlast")
              .contents()
              .get(0)
              .location.href.replace(/^.*[\\\/]/, "");
            $("#docname").text(decodeURIComponent(filename));
            $("#viewerlaststep").attr(
              "src",
              $("#viewerlast").contents().get(0).location.href
            );
            $("#nextstep3").css("visibility", "visible");
            $("#progressbarwizard1").bootstrapWizard("next");

            return false;
          }
        } else if (res[0] == "alreadyexists") {
          Command: toastr["warning"](res[2] + " name already exists.");
          return false;
        } else if (res[0] == "duplicatenameexist") {
          Command: toastr["warning"](res[2] + " name enter duplicate entries.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#submergedata").submit(function (e) {
    ////SWAMI

    var namefromtext = $('select[name="selected_comesub[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    namefromtextlevel = $('select[name="partiallylevel0[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    myArray = namefromtext.filter((el) => !namefromtextlevel.includes(el));

    var statenew = $('select[name="stategetsub[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var districtnew = $('select[name="districtgetsub[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var sddistrictnew = $('select[name="subdistrictgetsub[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var dataform = new FormData(this);
    dataform.append("namefromtext", myArray);
    dataform.append("namefromtextall", namefromtext);
    dataform.append("namefromtextlevel", namefromtextlevel);

    dataform.append("statenewarray", statenew);
    dataform.append("districtnewarray", districtnew);
    dataform.append("sddistrictnewarray", sddistrictnew);

    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: dataform, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        var res = data.split("|");

        if (res[0] == "addsddata") {
          var dataarray = JSON.parse(res[1]);

          if (
            res[4] != 0 &&
            dataarray["comefromchecksub"] != "Village / Town"
          ) {
            $("#submergedocument .close").click();

            var tes = "";
            for (var j = 0; j <= res[4]; j++) {
              tes += "#addlinksDTID_" + j + ",";
            }
            var n = tes.replace(/,\s*$/, "");
            $("#daynamor").html("");
            $("#daynamor").html(res[3]);
            $("" + n + "").multiSelect({
              selectableHeader:
                "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
              selectionHeader:
                "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
              afterInit: function (t) {
                var e = this,
                  n = e.$selectableUl.prev(),
                  a = e.$selectionUl.prev(),
                  i =
                    "#" +
                    e.$container.attr("id") +
                    " .ms-elem-selectable:not(.ms-selected)",
                  s =
                    "#" +
                    e.$container.attr("id") +
                    " .ms-elem-selection.ms-selected";
                (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
                  if (40 === t.which) return e.$selectableUl.focus(), !1;
                })),
                  (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                    if (40 == t.which) return e.$selectionUl.focus(), !1;
                  }));
              },
              afterSelect: function (values) {
                var check = this.$container.attr("id");
                var checkdata = check.split("_");

                this.qs1.cache(), this.qs2.cache();
                var data = [];
                var $el = $("#ms-addlinksDTID_" + checkdata[1] + "");
                $("#totaldefultselected_" + checkdata[1] + "").html(
                  $el.find('[class*="ms-elem-selection ms-selected"]').length
                );
                $el
                  .find('[class*="ms-elem-selection ms-selected"]')
                  .each(function () {
                    data.push($(this).text());
                  });

                for (var m = 0; m <= res[4]; m++) {
                  if (checkdata[1] != m) {
                    $("#ms-addlinksDTID_" + m + "")
                      .find('[class*="ms-elem-selectable"]')
                      .each(function () {
                        if ($.inArray($(this).text(), data) != -1) {
                          $(this).addClass("disabled");
                        }
                      });
                  }
                }

                if (this.qs2.matchedResultsCount != 0) {
                  $("#" + checkdata[1] + "").prop("disabled", false);
                } else {
                  $("#" + checkdata[1] + "").prop("disabled", true);
                }
              },
              afterDeselect: function () {
                var check = this.$container.attr("id");
                var checkdata = check.split("_");

                var data = [];
                var $el = $("#ms-addlinksDTID_" + checkdata[1] + "");
                $("#totaldefultselected_" + checkdata[1] + "").html(
                  $el.find('[class*="ms-elem-selection ms-selected"]').length
                );
                $el
                  .find('[class*="ms-elem-selection ms-selected"]')
                  .each(function () {
                    data.push($(this).text());
                  });

                for (var m = 0; m <= idscount; m++) {
                  if (checkdata[1] != m) {
                    $("#ms-addlinksDTID_" + m + "")
                      .find('[class*="ms-elem-selectable"]')
                      .each(function () {
                        if ($.inArray($(this).text(), data) == -1) {
                          $(this).removeClass("disabled");
                        }
                      });
                  }
                }

                this.qs1.cache(), this.qs2.cache();
                if (this.qs2.matchedResultsCount != 0) {
                  $("#" + checkdata[1] + "").prop("disabled", false);
                } else {
                  $("#" + checkdata[1] + "").prop("disabled", true);
                }
              },
            });
            $(".disbut").attr("disabled", "disabled");
            $('input[name="startfrom"]').attr("disabled", "disabled");
            $("#returndata").val(res[1]);
            $("#nextstep2").css("visibility", "visible");
            $("#backbtnnew").css("visibility", "hidden");
          } else {
            $("#submergedocument .close").click();
            $(".disbut").attr("disabled", "disabled");
            $("#finaldata").val(res[1]);
            $("#clickbutton").val("submerge");
            //  console.log(dataarray);
            var totalstcount = 0;
            var totalutcount = 0;
            var totalcount = 0;
            var stflag = "";
            var utflag = "";
            var stmsgname = "";
            var utmsgname = "";
            var stmsgnameplsm = "";
            var utmsgnameplsm = "";
            var Submergedflag = "";
            var pSubmergedflag = "";
            var tSubmergedflag = "";
            var tpSubmergedflag = "";
            var namefromtext = dataarray["namefromtext"].split(",");

            var noflag = false;
            if (dataarray["comefromchecksub"] == "State") {
              for (var i = 0; i < dataarray["selected_comesub"].length; i++) {
                if (dataarray["stStatus"][i] == "ST") {
                  totalstcount = totalstcount + 1;
                  stflag = "State(s)";
                  //  stmsgname +=namefromtext[i]+', ';
                  stmsgname +=
                    '<strong class="trinstrong1">' +
                    namefromtext[i] +
                    "</strong>, ";
                } else {
                  totalutcount = totalutcount + 1;
                  utflag = "Union Territory(s)";
                  //  utmsgname +=namefromtext[i]+', ';
                  utmsgname +=
                    '<strong class="trinstrong1">' +
                    namefromtext[i] +
                    "</strong>, ";
                }
              }
            } else if (dataarray["comefromchecksub"] == "Village / Town") {
              // console.log(dataarray);

              if (dataarray["namefromtextlevel"] == "") {
                for (var i = 0; i < dataarray["selected_comesub"].length; i++) {
                  if (dataarray["vtLevel"][i] == "VILLAGE") {
                    totalstcount = totalstcount + 1;
                    stflag = "Village(s)";
                    //  stmsgname +=namefromtext[i]+', ';
                    stmsgname +=
                      '<strong class="trinstrong1">' +
                      namefromtext[i] +
                      "</strong>, ";
                  } else {
                    totalutcount = totalutcount + 1;
                    utflag = "Town(s)";
                    //  utmsgname +=namefromtext[i]+', ';
                    utmsgname +=
                      '<strong class="trinstrong1">' +
                      namefromtext[i] +
                      "</strong>, ";
                  }
                }
              } else {
                noflag = true;
                namefromtextall = dataarray["namefromtextall"].split(",");
                namefromtextlevel = dataarray["namefromtextlevel"].split(",");
                for (var i = 0; i < dataarray["selected_comesub"].length; i++) {
                  if (dataarray["vtLevel"][i] == "VILLAGE") {
                    if (
                      dataarray["partiallylevel0"].includes(
                        dataarray["selected_comesub"][i]
                      )
                    ) {
                      stmsgnameplsm +=
                        '<strong class="trinstrong1">' +
                        namefromtextall[i] +
                        "</strong>, ";
                      pSubmergedflag =
                        '<span class="trinstrong">Partially Submerged :</span>';
                    } else {
                      stmsgname +=
                        '<strong class="trinstrong1">' +
                        namefromtextall[i] +
                        "</strong>, ";
                      Submergedflag =
                        '<span class="trinstrong">Submerged :</span>';
                    }

                    totalstcount = totalstcount + 1;
                    stflag = "Village(s)";
                  } else {
                    totalutcount = totalutcount + 1;
                    utflag = "Town(s)";
                    // utmsgname +='<strong class="trinstrong1">'+namefromtextall[i]+' - ('+dataarray['vtStatus'][i]+')'+subp+'</strong>, ';

                    if (
                      dataarray["partiallylevel0"].includes(
                        dataarray["selected_comesub"][i]
                      )
                    ) {
                      utmsgnameplsm +=
                        '<strong class="trinstrong1">' +
                        namefromtextall[i] +
                        "</strong>, ";
                      tpSubmergedflag =
                        '<span class="trinstrong">Partially Submerged :</span>';
                    } else {
                      utmsgname +=
                        '<strong class="trinstrong1">' +
                        namefromtextall[i] +
                        "</strong>, ";
                      tSubmergedflag =
                        '<span class="trinstrong">Submerged :</span>';
                    }
                  }
                }
              }
            }

            stmsgname = stmsgname.slice(0, -2);
            utmsgname = utmsgname.slice(0, -2);
            utmsgnameplsm = utmsgnameplsm.slice(0, -2);
            stmsgnameplsm = stmsgnameplsm.slice(0, -2);

            if (
              dataarray["comefromchecksub"] == "State" ||
              dataarray["comefromchecksub"] == "Village / Town"
            ) {
              if (noflag) {
                if (totalutcount == 0 && totalstcount != 0) {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong>" +
                    stflag +
                    " - <br>" +
                    Submergedflag +
                    ' <span class="trinstrong1">' +
                    stmsgname +
                    "</span><br>" +
                    pSubmergedflag +
                    ' <span class="trinstrong1">' +
                    stmsgnameplsm +
                    "</span></strong> <br> into <br> Sea / River / Any Other";
                } else if (totalstcount == 0 && totalutcount != 0) {
                  fmsg =
                    "(Total - " +
                    totalutcount +
                    " ) <strong>" +
                    utflag +
                    " - <br>" +
                    tSubmergedflag +
                    ' <span class="trinstrong1">' +
                    utmsgname +
                    "</span><br>" +
                    tpSubmergedflag +
                    ' <span class="trinstrong1">' +
                    utmsgnameplsm +
                    "</span></strong> <br> into <br> Sea / River / Any Other";
                } else {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong>" +
                    stflag +
                    " - <br>" +
                    Submergedflag +
                    ' <span class="trinstrong1">' +
                    stmsgname +
                    "</span><br>" +
                    pSubmergedflag +
                    ' <span class="trinstrong1">' +
                    stmsgnameplsm +
                    "</span></strong><br> AND <br> (Total - " +
                    totalutcount +
                    " ) <strong>" +
                    utflag +
                    " - <br>" +
                    tSubmergedflag +
                    ' <span class="trinstrong1">' +
                    utmsgname +
                    "</span><br>" +
                    tpSubmergedflag +
                    ' <span class="trinstrong1">' +
                    utmsgnameplsm +
                    "</span></strong> <br> into <br> Sea / River / Any Other";
                }
              } else {
                if (totalutcount == 0 && totalstcount != 0) {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong>" +
                    stflag +
                    ' - <span class="trinstrong1">' +
                    stmsgname +
                    "</span></strong> <br> Submerged into <br> Sea / River / Any Other";
                } else if (totalstcount == 0 && totalutcount != 0) {
                  fmsg =
                    "(Total - " +
                    totalutcount +
                    " ) <strong>" +
                    utflag +
                    ' - <span class="trinstrong1">' +
                    utmsgname +
                    "</span></strong>  <br> Submerged into <br> Sea / River / Any Other";
                } else {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong>" +
                    stflag +
                    ' - <span class="trinstrong1">' +
                    stmsgname +
                    "</span></strong><br> AND <br> (Total - " +
                    totalutcount +
                    " ) <strong>" +
                    utflag +
                    ' - <span class="trinstrong1">' +
                    utmsgname +
                    "</span></strong> <br> Submerged into <br> Sea / River / Any Other";
                }
              }
            } else {
              fmsg =
                "(Total - " +
                dataarray["selected_comesub"].length +
                " ) <strong>" +
                dataarray["comefromchecksub"] +
                '(s) - <span class="trinstrong1">' +
                dataarray["namefromtext"] +
                "</span></strong> <br> Submerged into <br> Sea / River / Any Other";
            }

            //  var maintitaldata = '<strong>'+dataarray['namefromtext']+'</strong> <strong>'+dataarray['comefromchecksub']+'</strong> <strong>Split & Sub Merge as Sea / River / Any Other</strong>';

            $("#maintitledata").html(fmsg);

            $("#viewerlast").css("display", "block");
            $("#pdf").css("display", "block");
            var filename = $("#viewerlast")
              .contents()
              .get(0)
              .location.href.replace(/^.*[\\\/]/, "");
            // console.log(filename);
            $("#docname").text(decodeURIComponent(filename));
            $("#viewerlaststep").attr(
              "src",
              $("#viewerlast").contents().get(0).location.href
            );
            $("#nextstep3").css("visibility", "visible");
            $("#progressbarwizard1").bootstrapWizard("next");
          }

          return false;
        } else if (res[0] == "alreadyexists") {
          Command: toastr["warning"](res[2] + " name already exists.");
          return false;
        } else if (res[0] == "duplicatenameexist") {
          Command: toastr["warning"](res[2] + " name enter duplicate entries.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#backbtn").click(function (e) {
    $("#progressbarwizard1").bootstrapWizard("previous");
    if ($("#returndata").val() == "" && $("#flagof").val() == "false") {
      $("#remarksubmerge").val("");
      $('input[type="radio"]').attr("disabled", false);

      $('input[name="startfrom"]').prop("checked", false);
      $("#actionuse").css("display", "none");

      //  $('#progressbarwizard1').bootstrapWizard('previous');
      $("#backbtnnew").css("visibility", "visible");

      $("#adddocument").trigger("reset");

      $("#selectdocumnent").select2("val", "");
      $(".dropify-clear").trigger("click");

      $("#viewer").css("display", "none");
    } else if ($("#returndata").val() == "" && $("#flagof").val() == "true") {
      // if($('#applyon').val())
      $('input[type="radio"]').attr("disabled", false);
      $('input[type="radio"]').map(function () {
        if (this.value == $("#applyon").val()) {
          $(this).attr("disabled", false);
        } else {
          $(this).attr("disabled", true);
        }
      });

      $('input[name="startfrom"]').prop("checked", false);
      $("#actionuse").css("display", "none");

      //  $('#progressbarwizard1').bootstrapWizard('previous');
      $("#backbtnnew").css("visibility", "visible");

      $("#adddocument").trigger("reset");

      $("#selectdocumnent").select2("val", "");
      $(".dropify-clear").trigger("click");

      $("#viewer").css("display", "none");
    } else {
      $("#nextstep2").css("visibility", "visible");
    }

    // $('#progressbarwizard1').find("a[href*='#profile-tab-2']").trigger('click');
  });

  $("#backbtnnew").click(function (e) {
    $('input[type="radio"]').attr("disabled", false);

    $('input[name="startfrom"]').prop("checked", false);
    $("#actionuse").css("display", "none");

    $("#progressbarwizard1").bootstrapWizard("previous");
    $("#backbtnnew").css("visibility", "hidden");

    $("#adddocument").trigger("reset");

    $("#selectdocumnent").select2("val", "");
    $(".dropify-clear").trigger("click");

    $("#viewer").css("display", "none");

    //    $('#pdf').css("display", "none")
  });

  $("#assigndatamerge").submit(function (e) {
    var namefromtext = $('select[name="namefrommrg[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var nametotext = $('select[name="newnamemrg[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var open = [];
    var ooremove = document.getElementsByName("oremovemrg[]");
    for (var j = 0; j < ooremove.length; j++) {
      if (ooremove[j].checked == true) {
        open.push(1);
      } else {
        open.push(0);
      }
    }

    var dataform = new FormData(this);
    dataform.append("namefromtextmrg", namefromtext);
    dataform.append("nametotext", nametotext);
    dataform.append("oremovemrg", open);

    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: dataform, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        var res = data.split("|");
        // console.log(res);
        // return false;
        if (res[0] == "addstate") {
          // console.log(res[1]);
          var dataarray = JSON.parse(res[1]);

          //    console.log(dataarray);
          // return false;
          //  Command: toastr["success"]("Successfully added "+res[2]+".");

          //  setTimeout(function () { location.reload() }, 3000);
          $("#mergenewdocument .close").click();

          $(".disbut").attr("disabled", "disabled");
          // var dataarray = JSON.parse(res[1]);
          // console.log(dataarray);
          $("#finaldata").val(res[1]);
          $("#clickbutton").val("Merge");

          if (dataarray["comefromcheckmrg"] == "State") {
            var name = dataarray["nametotext"];
          } else {
            var name = dataarray["didsmrgname"];
          }

          if (dataarray["oremovemrg"] == 1) {
            var maintitaldata =
              "<strong>" +
              name +
              "</strong> " +
              dataarray["comefromcheckmrg"] +
              " " +
              dataarray["actionmrg"][0] +
              " into <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> " +
              dataarray["comefromcheckmrg"] +
              " And " +
              dataarray["comefromcheckmrg"] +
              " <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> name changed to <strong>" +
              dataarray["newnamecheck"][0] +
              "</strong>";
          } else {
            var maintitaldata =
              "<strong>" +
              name +
              "</strong> " +
              dataarray["comefromcheckmrg"] +
              " " +
              dataarray["actionmrg"][0] +
              " into <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> " +
              dataarray["comefromcheckmrg"];
          }

          $("#maintitledata").html(maintitaldata);

          $("#viewerlast").css("display", "block");
          $("#pdf").css("display", "block");
          $("#viewerlaststep").attr("src", dataarray["uploadeddocumentmrg"]);
          //  $('#uploadeddocumentmrg').val(dataarray['uploadeddocumentmrg']);
          $("#nextstep3").css("visibility", "visible");
          $("#progressbarwizard1").bootstrapWizard("next");
          return false;
        } else if (res[0] == "adddistrict") {
          var dataarray = JSON.parse(res[1]);
          var nameto = "";

          if (dataarray["didsmrgname"] == "") {
            nameto = nametotext;
          } else {
            nameto = dataarray["didsmrgname"];
          }
          $("#mergenewdocument .close").click();

          $(".disbut").attr("disabled", "disabled");
          $("#finaldata").val(res[1]);
          $("#clickbutton").val("Merge");
          if (dataarray["oremovemrg"] == 1) {
            var maintitaldata =
              "<strong> " +
              nameto +
              " </strong> " +
              dataarray["comefromcheckmrg"] +
              " " +
              dataarray["actionmrg"][0] +
              " into <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> " +
              dataarray["comefromcheckmrg"] +
              " And " +
              dataarray["comefromcheckmrg"] +
              " <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> name changed to <strong>" +
              dataarray["newnamecheck"][0] +
              "</strong>";
          } else {
            var maintitaldata =
              "<strong> " +
              nameto +
              " </strong> " +
              dataarray["comefromcheckmrg"] +
              " " +
              dataarray["actionmrg"][0] +
              " into <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> " +
              dataarray["comefromcheckmrg"];
          }

          $("#maintitledata").html(maintitaldata);

          $("#viewerlast").css("display", "block");
          $("#pdf").css("display", "block");
          $("#viewerlaststep").attr("src", dataarray["uploadeddocumentmrg"]);

          $("#nextstep3").css("visibility", "visible");
          $("#progressbarwizard1").bootstrapWizard("next");
          return false;
        } else if (res[0] == "addsubdistrict") {
          var dataarray = JSON.parse(res[1]);

          var nameto = "";

          // if(dataarray['subdistselected']!='')
          // {
          nameto = nametotext;
          // }
          // else
          // {
          //     nameto = dataarray['didsmrgname'];
          // }
          $("#mergenewdocument .close").click();

          $(".disbut").attr("disabled", "disabled");
          $("#finaldata").val(res[1]);
          $("#clickbutton").val("Merge");
          if (dataarray["oremovemrg"] == 1) {
            var maintitaldata =
              "<strong> " +
              nameto +
              " </strong> " +
              dataarray["comefromcheckmrg"] +
              " " +
              dataarray["actionmrg"][0] +
              " into <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> " +
              dataarray["comefromcheckmrg"] +
              " And " +
              dataarray["comefromcheckmrg"] +
              " <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> name changed to <strong>" +
              dataarray["newnamecheck"][0] +
              "</strong>";
          } else {
            var maintitaldata =
              "<strong> " +
              nameto +
              " </strong> " +
              dataarray["comefromcheckmrg"] +
              " " +
              dataarray["actionmrg"][0] +
              " into <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> " +
              dataarray["comefromcheckmrg"];
          }

          $("#maintitledata").html(maintitaldata);

          $("#viewerlast").css("display", "block");
          $("#pdf").css("display", "block");
          $("#viewerlaststep").attr("src", dataarray["uploadeddocumentmrg"]);

          $("#nextstep3").css("visibility", "visible");
          $("#backbtnnew").css("visibility", "hidden");
          $("#progressbarwizard1").bootstrapWizard("next");

          return false;
        } else if (res[0] == "addvtdata") {
          var dataarray = JSON.parse(res[1]);

          var nameto = "";

          // if(dataarray['subdistselected']!='')
          // {
          nameto = nametotext;
          // }
          // else
          // {
          //     nameto = dataarray['didsmrgname'];
          // }
          $("#mergenewdocument .close").click();

          $(".disbut").attr("disabled", "disabled");
          $("#finaldata").val(res[1]);
          $("#clickbutton").val("Merge");
          if (dataarray["oremovemrg"] == 1) {
            var maintitaldata =
              "<strong> " +
              nameto +
              " </strong> " +
              dataarray["comefromcheckmrg"] +
              " " +
              dataarray["actionmrg"][0] +
              " into <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> " +
              dataarray["comefromcheckmrg"] +
              " And " +
              dataarray["comefromcheckmrg"] +
              " <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> name changed to <strong>" +
              dataarray["newnamecheck"][0] +
              "</strong>";
          } else {
            var maintitaldata =
              "<strong> " +
              nameto +
              " </strong> " +
              dataarray["comefromcheckmrg"] +
              " " +
              dataarray["actionmrg"][0] +
              " into <strong>" +
              dataarray["namefromtextmrg"] +
              "</strong> " +
              dataarray["comefromcheckmrg"];
          }

          $("#maintitledata").html(maintitaldata);

          $("#viewerlast").css("display", "block");
          $("#pdf").css("display", "block");
          $("#viewerlaststep").attr("src", dataarray["uploadeddocumentmrg"]);

          $("#nextstep3").css("visibility", "visible");
          $("#backbtnnew").css("visibility", "hidden");
          $("#progressbarwizard1").bootstrapWizard("next");

          return false;
        } else if (res[0] == "alreadyexists") {
          Command: toastr["warning"](res[2] + " name already exists.");
          return false;
        } else if (res[0] == "duplicatenameexist") {
          Command: toastr["warning"](res[2] + " name enter duplicate entries.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#assigndatamergep").submit(function (e) {
    var namefromtext = $('select[name="namefrommrgp[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var nametotext = $('select[name="newnamemrgp[]"] option:selected')
      .map(function () {
        return this.text;
      })
      .get();

    var open = [];
    var ooremove = document.getElementsByName("oremovemrgp[]");
    for (var j = 0; j < ooremove.length; j++) {
      if (ooremove[j].checked == true) {
        open.push(1);
      } else {
        open.push(0);
      }
    }

    var dataform = new FormData(this);
    dataform.append("namefromtextmrgp", namefromtext);
    dataform.append("nametotextp", nametotext);
    dataform.append("oremovemrgp", open);

    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: dataform, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        var res = data.split("|");

        if (res[0] == "addsddata") {
          $("#mergenewdocumentp .close").click();

          var tes = "";
          for (var j = 0; j <= res[4]; j++) {
            tes += "#addlinksDTID_" + j + ",";
          }
          var n = tes.replace(/,\s*$/, "");
          $("#daynamor").html("");
          $("#daynamor").html(res[3]);
          $("" + n + "").multiSelect({
            selectableHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function (t) {
              var e = this,
                n = e.$selectableUl.prev(),
                a = e.$selectionUl.prev(),
                i =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selectable:not(.ms-selected)",
                s =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selection.ms-selected";
              (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
                if (40 === t.which) return e.$selectableUl.focus(), !1;
              })),
                (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                  if (40 == t.which) return e.$selectionUl.focus(), !1;
                }));
            },
            afterSelect: function (values) {
              this.qs1.cache(), this.qs2.cache();
            },
            afterDeselect: function () {
              this.qs1.cache(), this.qs2.cache();
            },
          });

          $(".disbut").attr("disabled", "disabled");
          $('input[name="startfrom"]').attr("disabled", "disabled");
          if (res[2] != "State") {
            $('input[name="startfrom"]').prop("required", false);
          } else {
            $('input[name="startfrom"]').prop("required", true);
          }

          $("#returndata").val(res[1]);
          $("#clickbuttonmid").val(res[5]);
          $("#nextstep2").css("visibility", "visible");
          $("#backbtnnew").css("visibility", "hidden");
        } else if (res[0] == "adddtdata") {
          $("#mergenewdocumentp .close").click();

          var tes = "";
          for (var j = 0; j <= res[4]; j++) {
            tes += "#addlinksDTID_" + j + ",";
          }
          var n = tes.replace(/,\s*$/, "");
          $("#daynamor").html("");
          $("#daynamor").html(res[3]);
          $("" + n + "").multiSelect({
            selectableHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            selectionHeader:
              "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
            afterInit: function (t) {
              var e = this,
                n = e.$selectableUl.prev(),
                a = e.$selectionUl.prev(),
                i =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selectable:not(.ms-selected)",
                s =
                  "#" +
                  e.$container.attr("id") +
                  " .ms-elem-selection.ms-selected";
              (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
                if (40 === t.which) return e.$selectableUl.focus(), !1;
              })),
                (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
                  if (40 == t.which) return e.$selectionUl.focus(), !1;
                }));
            },
            afterSelect: function (values) {
              this.qs1.cache(), this.qs2.cache();
            },
            afterDeselect: function () {
              this.qs1.cache(), this.qs2.cache();
            },
          });

          $(".disbut").attr("disabled", "disabled");
          $('input[name="startfrom"]').attr("disabled", "disabled");
          if (res[2] != "State") {
            $('input[name="startfrom"]').prop("required", false);
          } else {
            $('input[name="startfrom"]').prop("required", true);
          }

          $("#returndata").val(res[1]);
          $("#clickbuttonmid").val(res[5]);
          $("#nextstep2").css("visibility", "visible");
          $("#backbtnnew").css("visibility", "hidden");
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#finalsubmitdocumentdata").submit(function (e) {
    $("#FINISHDATA").prop("disabled", true);
    //  $(':input[type="submit"]').prop('disabled', true);

    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        var res = data.split("|");

        if (res[0] == "addfinish" && res[2] == true) {
          Swal.fire({
            //title: "Partially Saved Successfully",
            title: "Completed Successfully",
            //   text: "If work is pending then click on Partially Save Button",
            type: "success",
            showCloseButton: 0,
            confirmButtonColor: "#348cd4",
            confirmButtonText: "Done",
          }).then(function (t) {
            // console.log(t);
            // return false;
            if (t.value) {
              var foram = new FormData();
              foram.append("formname", "Partiallysavedata");
              foram.append("docstatus", "Partially");
              foram.append("docids", res[1]);

              $.ajax({
                url: "insert_data.php", // Url to which the request is send
                type: "POST",
                data: foram, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                success: function (
                  data // A function to be called if request succeeds
                ) {
                  if (data == "update") {
                    window.location.href = "adddocument";
                    return false;
                  } else {
                    return false;
                  }
                },
                error: function (jqXHR, exception) {
                  if (jqXHR.status === 0) {
                    Command: toastr["error"]("Not connect.n Verify Network.");
                  } else if (jqXHR.status == 404) {
                    Command: toastr["error"]("Requested page not found. [404]");
                  } else if (jqXHR.status == 500) {
                    Command: toastr["error"]("Internal Server Error [500].");
                  } else if (exception === "timeout") {
                    Command: toastr["error"]("Time out error.");
                  } else if (exception === "abort") {
                    Command: toastr["error"]("Ajax request aborted.");
                  } else {
                    Command: toastr["error"]("Uncaught Error.n");
                  }
                },
              });

              //  window.location.href="adddocument";
            } else if (t.dismiss == "close") {
              return false;
            }
          });
          //       location.reload();

          return false;
        } else if (res[0] == "addfinish" && res[2] == false) {
          var flag = "";
          if (res[3] == "Addition") {
            flag = "Add New";
          } else if (res[3] == "Rename") {
            flag = "Rename / Status changed";
          } else {
            flag = res[3] + " New";
          }

          Swal.fire({
            //  title: ""+capitalizeFirstLetter(flag)+" Successfully",
            title: "Completed Successfully",
            //   text: "All jurisdictional change as per notification / corrigendum / resolution save.",
            type: "success",
            showCloseButton: 0,
            confirmButtonColor: "#348cd4",
            confirmButtonText: "Done",
          }).then(function (t) {
            // console.log(t);
            // return false;
            if (t.value) {
              //  location.reload();
              window.location.href = "adddocument";
            } else if (t.dismiss == "close") {
              return false;
            }
          });
          //       location.reload();

          return false;
        } else if (res[0] == "mergedone") {
          if (res[3] == "Partiallysm") {
            Swal.fire({
              //   title: "Partially Split & Merge Successfully",
              title: "Completed Successfully",
              type: "success",
              confirmButtonColor: "#348cd4",
              confirmButtonText: "Done",
            }).then(function (t) {
              if (t.value) {
                window.location.href = "adddocument";
              }
            });
          } else {
            Swal.fire({
              // title: "Merged / Partially Merged Successfully",
              title: "Completed Successfully",
              type: "success",
              confirmButtonColor: "#348cd4",
              confirmButtonText: "Done",
            }).then(function (t) {
              if (t.value) {
                window.location.href = "adddocument";
              }
            });
          }

          return false;
        } else if (res[0] == "addsmfinish") {
          //    Command: toastr["error"]("Server Problem try after sometime.");

          Swal.fire({
            title: "Completed Successfully",
            //    title: "Partially Split & Merged Successfully",
            type: "success",
            confirmButtonColor: "#348cd4",
            confirmButtonText: "Done",
          }).then(function (t) {
            if (t.value) {
              window.location.href = "adddocument";
            }
          });

          return false;
        } else if (res[0] == "addsubmergesd") {
          //    Command: toastr["error"]("Server Problem try after sometime.");

          Swal.fire({
            title: "Completed Successfully",
            // title: "Split & Sub Merge into Sea / River / Any Other Successfully",
            type: "success",
            confirmButtonColor: "#348cd4",
            confirmButtonText: "Done",
          }).then(function (t) {
            if (t.value) {
              window.location.href = "adddocument";
            }
          });

          return false;
        } else if (res[0] == "addReshuffle") {
          //    Command: toastr["error"]("Server Problem try after sometime.");

          Swal.fire({
            title: "Completed Successfully",
            // title: "Moved / Reshuffled Successfully",
            type: "success",
            confirmButtonColor: "#348cd4",
            confirmButtonText: "Done",
          }).then(function (t) {
            if (t.value) {
              window.location.href = "adddocument";
            }
          });

          return false;
        } else if (res[0] == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });
  // $('#id20212').on('select2:select', function (e) {
  //     var data = e.params.data;
  //     console.log(data);
  // });

  $("#adddocumentnext").submit(function (e) {
    var form = new FormData(this);

    var returndata = $("#returndata").val();

    // return false;
    var dataarray = JSON.parse(returndata);

    if (dataarray["formname"] == "submergeform") {
      form.append("comefromcheck", dataarray["comefromchecksub"]);
    } else {
      form.append("comefromcheck", dataarray["comefromcheck"]);
    }

    var tempflag = false;

    if (dataarray.hasOwnProperty("flag")) {
      for (var j = 0; j < dataarray[dataarray["flag"]].length; j++) {
        var namefromtext = "";

        namefromtext = $(
          'select[name="addlinksDTID' + j + '[]"] option:selected'
        )
          .map(function () {
            return this.text;
          })
          .get();

        if (namefromtext.length > 0) {
          tempflag = true;
        }

        var namefromtextp = "";
        if ($('input[name="haveapartially' + j + '[]"]:checked')) {
          namefromtextp = $(
            'select[name="partiallylevel' + j + '[]"] option:selected'
          )
            .map(function () {
              return this.text;
            })
            .get();
        }

        myArray = namefromtext.filter((el) => !namefromtextp.includes(el));

        form.append("addlinksDTIDtext" + j + "", myArray);
        form.append("addpartiallyleveltext" + j + "", namefromtextp);
      }
    } else if (dataarray.hasOwnProperty("partiallylevel0")) {
      for (var j = 0; j < dataarray["partiallylevel0"].length; j++) {
        var namefromtext = $(
          'select[name="addlinksDTID' + j + '[]"] option:selected'
        )
          .map(function () {
            return this.text;
          })
          .get();

        if (namefromtext.length > 0) {
          tempflag = true;
        }

        form.append("addlinksDTIDtext" + j + "", namefromtext);
      }
    } else {
      for (var j = 0; j < dataarray["namefrom"].length; j++) {
        var namefromtext = "";

        namefromtext = $(
          'select[name="addlinksDTID' + j + '[]"] option:selected'
        )
          .map(function () {
            return this.text;
          })
          .get();

        if (namefromtext.length > 0) {
          tempflag = true;
        }

        var namefromtextp = "";
        if ($('input[name="haveapartially' + j + '[]"]:checked')) {
          namefromtextp = $(
            'select[name="partiallylevel' + j + '[]"] option:selected'
          )
            .map(function () {
              return this.text;
            })
            .get();
        }

        myArray = namefromtext.filter((el) => !namefromtextp.includes(el));

        form.append("addlinksDTIDtext" + j + "", myArray);
        form.append("addpartiallyleveltext" + j + "", namefromtextp);
      }
    }

    if (tempflag != true) {
      Command: toastr["warning"]("Select at least one record.");
      return false;
    } else {
      toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: false,
        progressBar: false,
        positionClass: "toast-top-right",
        preventDuplicates: false,
        onclick: null,
        showDuration: "300",
        hideDuration: "1000",
        timeOut: "5000",
        extendedTimeOut: "1000",
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
      };
      e.preventDefault();

      $.ajax({
        url: "insert_data.php", // Url to which the request is send
        type: "POST",
        data: form, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function (
          data // A function to be called if request succeeds
        ) {
          var res = data.split("|");
          //  console.log(res);
          //return false;
          $("#progressbarwizard1").bootstrapWizard("next");

          $("#finaldata").val(res[0]);
          $("#nextstep3").css("visibility", "visible");
          $("#viewerlaststep").attr("src", res[1]);
          var dataarray = JSON.parse(res[0]);
          var returndata = JSON.parse(dataarray["returndata"]);
          var come = "";
          if (dataarray["applyon"] == "District") {
            come = "Sub-District";
          } else if (dataarray["applyon"] == "Sub-District") {
            come = "Village(s) / Town";
          } else if (dataarray["applyon"] == "Village / Town") {
            come = "Ward";
          } else if (dataarray["applyon"] == "Ward") {
            come = "EB";
          } else {
            come = "District";
          }
          var returndata = JSON.parse(dataarray["returndata"]);

          //   console.log(returndata);

          var nameofstate = "";
          var action = "";
          var subt = "";
          var textname = "";
          var totalstcount = 0;
          var totalutcount = 0;
          var totalcount = 0;
          var stflag = "";
          var utflag = "";

          var stmsgname = "";
          var utmsgname = "";
          var stmsgname1 = "";
          var utmsgname1 = "";
          var fmsg = "";

          var flagstatusst = "";
          var flagstatusut = "";

          var fromnamenew = "";
          var fromnamenewst = "";
          var fromnamenewut = "";
          var mainaction = "";
          var fromdatacoccatename = "";
          var fromdatacoccatenamep = "";

          if (returndata.hasOwnProperty("flag")) {
            if (dataarray["applyon"] == "State") {
              mainaction +=
                '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> New Created State / UT </th><th>Assigned District(s)</th><th>Assigned Partially District(s)</th></tr></thead><tbody>';
            } else {
              mainaction +=
                '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> New Created ' +
                dataarray["applyon"] +
                "</th><th>Assigned " +
                come +
                "(s)</th><th>Assigned Partially " +
                come +
                "(s)</th></tr></thead><tbody>";
            }

            if (returndata["flag"] == "namefrom") {
              nameofstate = returndata["newname"].join(",");

              action = returndata["action"].join(",");

              namefromtext = returndata["namefromtext"].split(",");
              for (var k = 0; k < returndata["namefrom"].length; k++) {
                if (dataarray["applyon"] == "State") {
                  if (returndata["StateStatus"][0] == "ST") {
                    totalstcount = 1;
                    stflag = "State(s)";
                    sssflag = "State: "; //modified by sahana status of state summary part
                    stmsgname = returndata["newname"][0] + ", ";
                  } else {
                    totalutcount = 1;
                    utflag = "Union Territory(s)";
                    sssflag = "Union Territory: "; //modified by sahana status of state summary part

                    utmsgname = returndata["newname"][0] + ", ";
                  }

                  if (returndata["fstatus"][k] == "ST") {
                    newflagstatus = "State";
                  } else {
                    newflagstatus = "Union Territory";
                  }

                  var flagstatus = "";
                  var flagss = "";
                  if (returndata["ostate"][k] == "ST") {
                    flagstatus = "State";
                    flagstatusst = '<span class="trinspam">State(s)</span>: ';
                  } else {
                    flagstatus = "Union Territory";

                    flagstatusut =
                      '<span class="trinspam">Union Territory(s)</span>: ';
                  }

                  var finalstatus = "";
                  var finalstatus1 = "";

                  if (newflagstatus == flagstatus) {
                    finalstatus = "";
                    finalstatus1 = newflagstatus;
                  } else {
                    finalstatus =
                      '<span class="trinspam"> (Now ' +
                      newflagstatus +
                      ")</span>";
                    finalstatus1 = newflagstatus;
                  }

                  if (returndata["ostate"][k] == "ST") {
                    fromnamenewst +=
                      '<strong class="trinstrong">' +
                      namefromtext[k] +
                      " " +
                      finalstatus +
                      " </strong>, ";
                  } else {
                    fromnamenewut +=
                      '<strong class="trinstrong">' +
                      namefromtext[k] +
                      " " +
                      finalstatus +
                      "</strong>, ";
                  }

                  if (dataarray["addlinksDTIDtext" + k + ""] != "") {
                    //15-09
                    fromdatacoccatename +=
                      '<strong><span class="trinspam"> ' +
                      flagstatus +
                      ': </span></strong><strong class="trinstrong">' +
                      namefromtext[k] +
                      " - </strong>" +
                      dataarray["addlinksDTIDtext" + k + ""].replaceAll(
                        ",",
                        ", "
                      ) +
                      "<br>";
                    // fromdatacoccatename +='<strong class="trinstrong">'+namefromtext[k]+'<span class="trinspam">('+finalstatus1+')</span> - </strong>'+dataarray['addlinksDTIDtext'+k+''].replaceAll(",", ", ")+'<br>';
                  }
                  if (dataarray["addpartiallyleveltext" + k + ""] != "") {
                    fromdatacoccatenamep +=
                      '<strong><span class="trinspam">' +
                      flagstatus +
                      ': </span></strong><strong class="trinstrong">' +
                      namefromtext[k] +
                      " - </strong>" +
                      dataarray["addpartiallyleveltext" + k + ""].replaceAll(
                        ",",
                        ", "
                      ) +
                      "<br>";
                    // fromdatacoccatenamep +='<strong class="trinstrong">'+namefromtext[k]+'<span class="trinspam">('+finalstatus1+')</span> - </strong>'+dataarray['addpartiallyleveltext'+k+''].replaceAll(",", ", ")+'<br>';
                  }
                } else {
                  totalstcount = 1;
                  stmsgname = returndata["newname"][0] + ", ";
                  // fromnamenew +='<strong class="trinstrong">'+namefromtext[k]+'</strong>, ';
                  //  fromnamenew +='<strong class="trinstrong">'+namefromtext[k]+ '</strong> <span class="trinspam"><strong>-' + returndata['action'][k]+',</strong></span>';

                  //modified by sahana for SUB DISTRICT FULL MERGE AND SPLIT m-1 0509 Jc_09
                  if (k === returndata["namefrom"].length - 1) {
                    fromnamenew +=
                      '<strong class="trinstrong">' +
                      namefromtext[k] +
                      '</strong> <span class="trinspam"><strong>- ' +
                      returndata["action"][k] +
                      "</strong></span>";
                  } else {
                    fromnamenew +=
                      '<strong class="trinstrong">' +
                      namefromtext[k] +
                      '</strong> <span class="trinspam"><strong>- ' +
                      returndata["action"][k] +
                      ", &nbsp</strong></span>";
                  }

                  if (dataarray["addlinksDTIDtext" + k + ""] != "") {
                    //modified by sahana status split district 1609
                    fromdatacoccatename +=
                      '<strong class="trinstrong"><span class="trinspam">' +
                      dataarray["applyon"] +
                      ": </span>" +
                      namefromtext[k] +
                      " - </strong>" +
                      dataarray["addlinksDTIDtext" + k + ""].replaceAll(
                        ",",
                        ", "
                      ) +
                      "<br>";

                    // fromdatacoccatename +='<strong class="trinstrong">'+namefromtext[k]+'<span class="trinspam">('+dataarray['applyon']+')</span> - </strong>'+dataarray['addlinksDTIDtext'+k+''].replaceAll(",", ", ")+'<br>';
                  }
                  if (dataarray["addpartiallyleveltext" + k + ""] != "") {
                    fromdatacoccatenamep +=
                      '<strong class="trinstrong"><span class="trinspam">' +
                      dataarray["applyon"] +
                      ": </span>" +
                      namefromtext[k] +
                      " - </strong>" +
                      dataarray["addpartiallyleveltext" + k + ""].replaceAll(
                        ",",
                        ", "
                      ) +
                      "<br>";
                    // fromdatacoccatenamep +='<strong class="trinstrong">'+namefromtext[k]+'<span class="trinspam">('+dataarray['applyon']+')</span> - </strong>'+dataarray['addpartiallyleveltext'+k+''].replaceAll(",", ", ")+'<br>';
                  }
                }
              }

              if (dataarray["applyon"] == "State") {
                //  mainaction +='<tr class="trleftalign"><td><strong><span class="trinstrong1">'+returndata['newname'][0]+'</span><span class="trinspam">'+sssflag+'</span></strong></td><td>'+fromdatacoccatename+'</td><td>'+fromdatacoccatenamep+'</td></tr>';
                mainaction +=
                  '<tr class="trleftalign"><td><strong><span class="trinspam">' +
                  sssflag +
                  '</span><span class="trinstrong1">' +
                  returndata["newname"][0] +
                  "</span></strong></td><td>" +
                  fromdatacoccatename +
                  "</td><td>" +
                  fromdatacoccatenamep +
                  "</td></tr>";
              } else {
                //modified by sahana status split district 1609
                mainaction +=
                  '<tr class="trleftalign"><td><strong><span class="trinspam">' +
                  dataarray["applyon"] +
                  ': </span><span class="trinstrong1">' +
                  returndata["newname"][0] +
                  "</span></strong></td><td>" +
                  fromdatacoccatename +
                  "</td><td>" +
                  fromdatacoccatenamep +
                  "</td></tr>";
              }
            } else {
              // console.log(returndata);

              nameofstate = returndata["namefromtext"];
              action = returndata["action"].join(",");
              namefromtext = returndata["namefromtext"].split(",");

              for (var k = 0; k < returndata["newname"].length; k++) {
                if (dataarray["applyon"] == "State") {
                  if (returndata["StateStatus"][k] == "ST") {
                    totalstcount = totalstcount + 1;
                    stflag = "State(s)";
                    sssflag = "State: "; //modified by sahana status of state summary part
                    stmsgname += returndata["newname"][k] + ", ";
                  } else {
                    totalutcount = totalutcount + 1;
                    utflag = "Union Territory(s)";
                    sssflag = "Union Territory: "; //modified by sahana status of state summary part
                    utmsgname += returndata["newname"][k] + ", ";
                  }

                  var flagstatus = "";
                  var newflagstatus = "";
                  if (returndata["ostate"][0] == "ST") {
                    flagstatus = "State";
                  } else {
                    flagstatus = "Union Territory";
                  }

                  if (returndata["fstatus"][0] == "ST") {
                    newflagstatus = "State";
                  } else {
                    newflagstatus = "Union Territory";
                  }
                  var finalstatus = "";
                  var finalstatus1 = "";
                  if (newflagstatus == flagstatus) {
                    finalstatus = "(" + flagstatus + ")";
                    finalstatus1 = newflagstatus;
                  } else {
                    // finalstatus = '('+flagstatus+') now ('+newflagstatus+')';
                    finalstatus = " (Now - " + newflagstatus + ")";
                    finalstatus1 = newflagstatus;
                  }

                  fromnamenewst =
                    '<strong class="trinstrong"><span class="trinspam">' +
                    flagstatus +
                    " : </span>" +
                    namefromtext[0] +
                    '<span class="trinspam">' +
                    finalstatus +
                    "</span></strong>, ";

                  var flagof = "";
                  if (dataarray["applyon"] == "State") {
                    if (dataarray.hasOwnProperty("partiallylevel" + k + "")) {
                      //modified by sahana status split district 1609
                      flagof +=
                        '<strong class="trinstrong"><span class="trinspam">' +
                        flagstatus +
                        ": </span>" +
                        namefromtext[0] +
                        "</strong> - " +
                        dataarray["addpartiallyleveltext" + k + ""].replaceAll(
                          ",",
                          ", "
                        ) +
                        "";
                    }
                  } else {
                    if (dataarray.hasOwnProperty("partiallylevel" + k + "")) {
                      //modified by sahana status split district 1609
                      flagof +=
                        '<strong class="trinstrong"><span class="trinspam">' +
                        dataarray["applyon"] +
                        ": </span>" +
                        namefromtext[0] +
                        "</strong> - " +
                        dataarray["addpartiallyleveltext" + k + ""].replaceAll(
                          ",",
                          ", "
                        ) +
                        "";
                    }
                  }

                  mainaction +=
                    '<tr class="trleftalign"><td><strong><span class="trinspam">' +
                    sssflag +
                    '</span><span class="trinstrong1">' +
                    returndata["newname"][k] +
                    '</span></strong></td><td><strong class="trinstrong">'; //modified by sahana status of state summary part
                  if (dataarray["addlinksDTIDtext" + k + ""].length > 0) {
                    mainaction +=
                      '<span class="trinspam">' +
                      flagstatus +
                      " : </span>" +
                      namefromtext[0] +
                      " - "; //modified by sahana status of state summary part
                  }

                  mainaction +=
                    "</strong> " +
                    dataarray["addlinksDTIDtext" + k + ""].replaceAll(
                      ",",
                      ", "
                    ) +
                    "</td><td>" +
                    flagof +
                    "</td></tr>";
                  // mainaction +='<tr class="trleftalign"><td><strong><span class="trinstrong1">'+returndata['newname'][k]+'</span><span class="trinspam">'+sssflag+'</span></strong></td><td><strong class="trinstrong">'+namefromtext[0]+'<span class="trinspam">('+finalstatus1+')</span></strong> - '+dataarray['addlinksDTIDtext'+k+''].replaceAll(",", ", ")+'</td><td>'+flagof+'</td></tr>';
                } else {
                  totalstcount = totalstcount + 1;
                  stmsgname += returndata["newname"][k] + ", ";
                  var flagof = "";
                  if (dataarray.hasOwnProperty("partiallylevel" + k + "")) {
                    //modified by sahana status split district 1609
                    flagof +=
                      '<strong class="trinstrong"><span class="trinspam">' +
                      dataarray["applyon"] +
                      ": </span>" +
                      namefromtext[0] +
                      "</strong> - " +
                      dataarray["addpartiallyleveltext" + k + ""].replaceAll(
                        ",",
                        ", "
                      ) +
                      "";
                    // flagof +='<strong class="trinstrong">'+namefromtext[0]+'<span class="trinspam">('+dataarray['applyon']+')</span></strong> - '+dataarray['addpartiallyleveltext'+k+''].replaceAll(",", ", ")+'';
                  }
                  fromnamenew =
                    '<strong class="trinstrong">' +
                    namefromtext[0] +
                    "</strong>, ";

                  //modified by sahana status split district 1509
                  mainaction +=
                    '<tr class="trleftalign"><td><strong><span class="trinspam">' +
                    dataarray["applyon"] +
                    ': </span><span class="trinstrong1">' +
                    returndata["newname"][k] +
                    '</span></strong></td><td><strong class="trinstrong">';
                  if (dataarray["addlinksDTIDtext" + k + ""].length > 0) {
                    mainaction +=
                      '<strong><span class="trinspam">' +
                      dataarray["applyon"] +
                      ":</span></strong> " +
                      namefromtext[0] +
                      " - ";
                  }
                  mainaction +=
                    "</strong>" +
                    dataarray["addlinksDTIDtext" + k + ""].replaceAll(
                      ",",
                      ", "
                    ) +
                    "</td><td>" +
                    flagof +
                    "</td></tr>";
                  // mainaction +='<tr class="trleftalign"><td><strong><span class="trinstrong1">'+capitalizeFirstLetter(returndata['newname'][k])+'</span><span class="trinspam">('+dataarray['applyon']+')</span></strong></td><td><strong class="trinstrong">'+namefromtext[0]+'<span class="trinspam">('+dataarray['applyon']+')</span> - </strong>'+dataarray['addlinksDTIDtext'+k+''].replaceAll(",", ", ")+'</td><td>'+flagof+'</td></tr>';
                }
              }
            }

            mainaction += "</tbody></table>";

            stmsgname = stmsgname.slice(0, -2);
            utmsgname = utmsgname.slice(0, -2);
            fromnamenew = fromnamenew.slice(0, -2);
            fromnamenewst = fromnamenewst.slice(0, -2);
            fromnamenewut = fromnamenewut.slice(0, -2);
            subt = subt.slice(0, -4);

            if (dataarray["applyon"] == "State") {
              //modified by sahana Split, Full Merge summary message.
              if (totalutcount == 0 && totalstcount != 0) {
                fmsg =
                  "(Total - " +
                  totalstcount +
                  " ) <strong>New  " +
                  stflag +
                  ' - <span class="trinstrong1">' +
                  stmsgname +
                  "</span></strong> <br> Created from <br><strong>" +
                  flagstatusst +
                  "</strong>" +
                  fromnamenewst +
                  "<br><strong>" +
                  flagstatusut +
                  "</strong>" +
                  fromnamenewut +
                  "<br>&nbsp;Using Split Action";
              } else if (totalstcount == 0 && totalutcount != 0) {
                fmsg =
                  "(Total - " +
                  totalutcount +
                  " ) <strong>New  " +
                  utflag +
                  ' - <span class="trinstrong1">' +
                  utmsgname +
                  "</span></strong>  <br> Created from <br><strong>" +
                  flagstatusst +
                  "</strong>" +
                  fromnamenewst +
                  "<br><strong>" +
                  flagstatusut +
                  "</strong>" +
                  fromnamenewut +
                  "<br>&nbsp;Using Split Action";
              } else {
                fmsg =
                  "(Total - " +
                  totalstcount +
                  " ) <strong>New  " +
                  stflag +
                  ' - <span class="trinstrong1">' +
                  stmsgname +
                  "</span></strong><br> AND <br> (Total - " +
                  totalutcount +
                  " ) <strong>New  " +
                  utflag +
                  ' - <span class="trinstrong1">' +
                  utmsgname +
                  "</span></strong>  <br> Created from <br> " +
                  fromnamenewst +
                  "<br>&nbsp;Using Split Action";
              }
            } else {
              if (
                dataarray["applyon"] == "District" ||
                dataarray["applyon"] == "Sub-District"
              ) {
                if (returndata["namefrom"].length == 1) {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong>New  " +
                    dataarray["applyon"] +
                    '(s) - <span class="trinstrong1">' +
                    stmsgname +
                    '</span></strong>  <br> Created from <br><strong><span class="trinspam">' +
                    dataarray["applyon"] +
                    "(s) :</span></strong> " +
                    fromnamenew +
                    "<br>&nbsp;Using Split Action";
                } else {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong>New  " +
                    dataarray["applyon"] +
                    '(s) - <span class="trinstrong1">' +
                    stmsgname +
                    '</span></strong>  <br> Created from <br><strong><span class="trinspam">' +
                    dataarray["applyon"] +
                    "(s) :</span></strong> " +
                    fromnamenew;
                }
              } else {
                if (
                  returndata["action"].includes("Split") &&
                  returndata["action"].includes("Full Merge")
                ) {
                  //modified by sahana full merge in sub disrict level 0509
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong>New  " +
                    dataarray["applyon"] +
                    '(s) - <span class="trinstrong1">' +
                    stmsgname +
                    '</span></strong>  <br> Created from <br><strong><span class="trinspam">' +
                    dataarray["applyon"] +
                    "(s) :</span></strong> " +
                    fromnamenew +
                    "&nbsp;";
                } else {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong>New  " +
                    dataarray["applyon"] +
                    '(s) - <span class="trinstrong1">' +
                    stmsgname +
                    '</span></strong>  <br> Created from <br><strong><span class="trinspam">' +
                    dataarray["applyon"] +
                    "(s) :</span></strong> " +
                    fromnamenew +
                    "<br>&nbsp;Using Split Action";
                }
              }
            }

            var maintitaldata = fmsg;

            // var mainaction = 'Created from <strong>'+capitalizeFirstLetter(returndata['namefromtext'])+'</strong> '+dataarray['applyon']+'';
            // var subtitle = subt;

            $("#maintitledata").html(maintitaldata);
            $("#mainaction").html(mainaction);
            $("#clickbutton").val(dataarray["clickbuttonmid"]);
          } else {
            if (
              dataarray["applyon"] == "Sub-District" &&
              returndata["clickpopup"] == "submerge"
            ) {
              var myflag = "";
              var myflagpl = "";
              var fromnamenewpl = "";
              mainaction +=
                '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> Partially Submerged ' +
                dataarray["applyon"] +
                "</th><th>Partially Submerged " +
                come +
                "(s)</th></tr></thead><tbody>";

              namefromtext = returndata["namefromtext"].split(",");
              for (var k = 0; k < namefromtext.length; k++) {
                totalstcount = totalstcount + 1;

                fromnamenew +=
                  '<strong class="trinstrong1">' +
                  namefromtext[k] +
                  "</strong>, ";
                myflag = "Submerged";

                // if(dataarray['addlinksDTIDtext'+k+'']!='')
                // {
                // fromdatacoccatename +='<strong class="trinstrong">'+namefromtext[k]+' - </strong>'+dataarray['addlinksDTIDtext'+k+''].replaceAll(",", ", ")+'<br>';
                // }
                // if(dataarray['addpartiallyleveltext'+k+'']!='')
                // {
                //  fromdatacoccatenamep +='<strong class="trinstrong">'+namefromtext[k]+' - </strong>'+dataarray['addpartiallyleveltext'+k+''].replaceAll(",", ", ")+'<br>';
                // }
              }

              partiallylevel = returndata["namefromtextlevel"].split(",");
              for (var l = 0; l < partiallylevel.length; l++) {
                totalutcount = totalutcount + 1;
                myflagpl = "Partially Submerged";
                fromnamenewpl +=
                  '<strong class="trinstrong1">' +
                  partiallylevel[l] +
                  "</strong>, ";

                if (dataarray["addlinksDTIDtext" + l + ""] != "") {
                  mainaction +=
                    '<tr class="trleftalign"><td><strong><span class="trinstrong1">' +
                    partiallylevel[l] +
                    '</span><span class="trinspam">(' +
                    dataarray["applyon"] +
                    ')</span></strong></td><td><strong class="trinstrong">' +
                    partiallylevel[l] +
                    " - </strong>" +
                    dataarray["addlinksDTIDtext" + l + ""].replaceAll(
                      ",",
                      ", "
                    ) +
                    "</td></tr>";
                }
                // if(dataarray['addpartiallyleveltext'+k+'']!='')
                // {
                //  fromdatacoccatenameput +='<strong class="trinstrong">'+partiallylevel[l]+' - </strong>'+dataarray['addpartiallyleveltext'+l+''].replaceAll(",", ", ")+'<br>';
                // }
              }

              // mainaction +='<tr class="trleftalign"><td><strong><span class="trinstrong1">'+capitalizeFirstLetter(returndata['newname'][0])+'</span><span class="trinspam">('+dataarray['applyon']+')</span></strong></td><td>'+fromdatacoccatename+'</td><td>'+fromdatacoccatenamep+'</td></tr>';

              mainaction += "</tbody></table>";

              fromnamenew = fromnamenew.slice(0, -2);
              fromnamenewpl = fromnamenewpl.slice(0, -2);

              if (totalutcount == 0 && totalstcount != 0) {
                fmsg =
                  "(Total - " +
                  totalstcount +
                  " ) <strong><span>" +
                  dataarray["applyon"] +
                  "(s) - </span></strong>" +
                  fromnamenew +
                  ' <strong class="trinstrong1">(' +
                  myflag +
                  ")</strong>  <br> into <br> Sea / River / Any Other";
              } else if (totalstcount == 0 && totalutcount != 0) {
                fmsg =
                  "(Total - " +
                  totalutcount +
                  " ) <strong><span>" +
                  dataarray["applyon"] +
                  "(s) - </span></strong>" +
                  fromnamenewpl +
                  ' <strong class="trinstrong1">(' +
                  myflagpl +
                  ")</strong> <br> Submerged into <br> Sea / River / Any Other";
              } else {
                fmsg =
                  "(Total - " +
                  totalstcount +
                  " ) <strong><span>" +
                  dataarray["applyon"] +
                  "(s) - </span></strong>" +
                  fromnamenew +
                  ' <strong class="trinstrong1">(' +
                  myflag +
                  ")</strong><br> AND <br> (Total - " +
                  totalutcount +
                  " ) <strong><span>" +
                  dataarray["applyon"] +
                  "(s) - </span></strong>" +
                  fromnamenewpl +
                  ' <strong class="trinstrong1">(' +
                  myflagpl +
                  ")</strong><br> into <br> Sea / River / Any Other";
              }

              var maintitaldata = fmsg;

              $("#maintitledata").html(maintitaldata);
              $("#mainaction").html(mainaction);

              var filename = $("#viewerlast")
                .contents()
                .get(0)
                .location.href.replace(/^.*[\\\/]/, "");
              // console.log(filename);
              $("#docname").text(decodeURIComponent(filename));
              $("#clickbutton").val(returndata["clickpopup"]);
            } else {
              if (dataarray["applyon"] == "State") {
                mainaction +=
                  '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> Merge / Partially Merge - State / UT </th><th>Assigned District(s)</th><th>Assigned Partially District(s)</th></tr></thead><tbody>';
              } else {
                mainaction +=
                  '<table class="table table-bordered mb-0 table-hover"><thead><tr class="trhead"><th> Merge / Partially Merge - ' +
                  dataarray["applyon"] +
                  "</th><th>Assigned " +
                  come +
                  "(s)</th><th>Assigned Partially " +
                  come +
                  "(s)</th></tr></thead><tbody>";
              }

              namefromtext = returndata["namefromtext"].split(",");
              for (var k = 0; k < returndata["namefrom"].length; k++) {
                if (dataarray["applyon"] == "State") {
                  // JIGAR

                  if (returndata["ostate"][k] == "ST") {
                    totalstcount = totalstcount + 1;

                    sssflag = "(State)";
                    sssflag1 = "State";
                  } else {
                    totalutcount = totalutcount + 1;
                    //modified by sahana to recorrect status summary in partially merge
                    utsssflag = "(Union Territory)";
                    utsssflag1 = "Union Territory";
                  }

                  // JIGAR

                  if (returndata["action"][k] == "Merge") {
                    if (returndata["fstatus"][k] == "ST") {
                      if (returndata["action"][k] == "Merge") {
                        stflag = "Merged";
                      } else {
                        stflag = "";
                      }

                      newflagstatus = "State";
                    } else {
                      if (returndata["action"][k] == "Merge") {
                        stflag = "Merged";
                      } else {
                        stflag = "";
                      }

                      newflagstatus = "Union Territory";
                    }

                    var finalstatus = "";
                    var finalstatus1 = "";

                    // if(newflagstatus==sssflag1 || newflagstatus==utsssflag1)
                    // {
                    // finalstatus = '';
                    // finalstatus1 = newflagstatus;
                    // }
                    // else
                    // {
                    // finalstatus = '<span class="trinspam"> (Now '+newflagstatus+')</span>';
                    // finalstatus1 = newflagstatus;
                    // }
                    //2009
                    if (returndata["ostate"][k] == returndata["fstatus"][k]) {
                      finalstatus = "";
                      finalstatus1 = newflagstatus;
                    } else {
                      finalstatus =
                        '<span class="trinspam"> (Now ' +
                        newflagstatus +
                        ")</span>";
                      finalstatus1 = newflagstatus;
                    }

                    if (returndata["ostate"][k] == "ST") {
                      stmsgname += namefromtext[k] + finalstatus + ", ";
                    } else {
                      stmsgname1 += namefromtext[k] + finalstatus + ", ";
                    }
                  } else {
                    if (returndata["fstatus"][k] == "ST") {
                      //modified by sahana to Partially Merge same condition as merge
                      if (returndata["action"][k] == "Partially Merge") {
                        utflag = "Partially Merged";
                      } else {
                        utflag = "";
                      }
                      newflagstatus = "State";
                    } else {
                      //modified by sahana to Partially Merge same condition as merge
                      if (returndata["action"][k] == "Partially Merge") {
                        utflag = "Partially Merged";
                      } else {
                        utflag = "";
                      }
                      newflagstatus = "Union Territory";
                    }

                    var finalstatus = "";
                    var finalstatus1 = "";
                    var sssflag1; //modified by sahana to add Declaration to partially merge
                    var utsssflag1; // modified by sahana JC_41

                    //modified by sahana to partially merge summary part
                    // if(newflagstatus==sssflag1 || newflagstatus==utsssflag1)
                    // {
                    // finalstatus = '';
                    // finalstatus1 = newflagstatus;
                    // }
                    // else
                    // {
                    // finalstatus = '<span class="trinspam"> (Now '+newflagstatus+')</span>';
                    // finalstatus1 = newflagstatus;
                    // }
                    //2009
                    if (returndata["ostate"][k] == returndata["fstatus"][k]) {
                      finalstatus = "";
                      finalstatus1 = newflagstatus;
                    } else {
                      finalstatus =
                        '<span class="trinspam"> (Now ' +
                        newflagstatus +
                        ")</span>";
                      finalstatus1 = newflagstatus;
                    }

                    if (returndata["ostate"][k] == "ST") {
                      utmsgname1 += namefromtext[k] + finalstatus + ", ";
                    } else {
                      utmsgname += namefromtext[k] + finalstatus + ", ";
                    }
                  }

                  if (returndata["StateStatus"][0] == "ST") {
                    if (
                      returndata["toStatus"][0] == returndata["StateStatus"][0]
                    ) {
                      toflag = "";
                    } else {
                      toflag = "(Now State)";
                    }
                  } else {
                    if (
                      returndata["toStatus"][0] == returndata["StateStatus"][0]
                    ) {
                      toflag = "";
                    } else {
                      toflag = "(Now Union Territory)";
                    }
                  }
                  fromnamenew =
                    '<strong class="trinstrong">' +
                    returndata["nametotext"] +
                    '<span class="trinspam">' +
                    toflag +
                    "</span></strong>, ";

                  if (returndata["ostate"][k] == "ST") {
                    $statusstate = '<strong class="trinspam">State: </strong>';
                  } else {
                    $statusstate =
                      '<strong class="trinspam">Union Territory: </strong>';
                  }
                  //modified by sahana to change Partially merge table summary 01-08-2023

                  if (dataarray["addlinksDTIDtext" + k + ""] != "") {
                    fromdatacoccatename +=
                      " " +
                      $statusstate +
                      '<strong class="trinstrong">' +
                      namefromtext[k] +
                      " - </strong>" +
                      dataarray["addlinksDTIDtext" + k + ""].replaceAll(
                        ",",
                        ", "
                      ) +
                      "<br>";
                  }
                  if (dataarray["addpartiallyleveltext" + k + ""] != "") {
                    fromdatacoccatenamep +=
                      " " +
                      $statusstate +
                      '<strong class="trinstrong">' +
                      namefromtext[k] +
                      " - </strong>" +
                      dataarray["addpartiallyleveltext" + k + ""].replaceAll(
                        ",",
                        ", "
                      ) +
                      "<br>";
                  }

                  // mainaction +='<tr class="trleftalign"><td><strong><span class="trinstrong1">'+returndata['nametotext']+'</span><span class="trinspam">(State)</span></strong></td><td>'+dataarray['addlinksDTIDtext'+k+''].replaceAll(",", ", ")+'</td><td>'+dataarray['addpartiallyleveltext'+k+''].replaceAll(",", ", ")+'</td></tr>';
                } else {
                  if (returndata["action"][k] == "Merge") {
                    //modified by sahana to M/P-P/M level
                    if (returndata["ostate"][k] == "ST") {
                      totalstcount = totalstcount + 1;
                      stflag = "- Merged"; //01-08-2023
                      sssflag = "" + dataarray["applyon"] + ": "; //modified by sahana to change UI for partially merge in district level summary
                      stmsgname += namefromtext[k] + ", ";
                    } else {
                      totalutcount = totalutcount + 1;
                      utflag = "- Merged"; //01-08-2023
                      utsssflag = "" + dataarray["applyon"] + ": "; //modified by sahana to change UI for partially merge in district level summary
                      utmsgname +=
                        namefromtext[k] +
                        '<span class="trinspam">' +
                        utflag +
                        "</span> , "; //01-08-2023
                    }
                  }
                  //modified by sahana for Partially Merge functionality in district level.
                  else if (returndata["action"][k] == "Partially Merge") {
                    //modified by sahana to M/P-P/M level
                    if (returndata["ostate"][k] == "ST") {
                      totalstcount = totalstcount + 1;
                      stflag = "- Partially Merged"; //01-08-2023
                      sssflag = "" + dataarray["applyon"] + ": "; //modified by sahana to change UI for partially merge in district level summary
                      stmsgname += namefromtext[k] + ", ";
                    } else {
                      totalutcount = totalutcount + 1;
                      utflag = "- Partially Merged"; //01-08-2023
                      utsssflag = "" + dataarray["applyon"] + ": "; //modified by sahana to change UI for partially merge in district level summary
                      utmsgname +=
                        namefromtext[k] +
                        '<span class="trinspam">' +
                        utflag +
                        "</span> , "; //01-08-2023
                    }
                  } else {
                    totalutcount = totalutcount + 1;
                    utflag = "Partially split & Merged";
                    sssflag = "" + dataarray["applyon"] + ": "; //modified by sahana to change UI for partially merge in district level summary
                    utmsgname += namefromtext[k] + ", ";
                  }

                  toflag = "(" + dataarray["applyon"] + ")";

                  if (returndata["ostate"][k] == "ST") {
                    //modified by sahana to change UI for partially merge in district level summary
                    fromnamenew =
                      '<strong><span class="trinspam">' +
                      sssflag +
                      '</span></strong> <strong class="trinstrong">' +
                      returndata["nametotext"] +
                      "</strong>, ";

                    if (dataarray["addlinksDTIDtext" + k + ""] != "") {
                      //01-08-2023
                      fromdatacoccatename +=
                        '<strong class="trinstrong">' +
                        namefromtext[k] +
                        '<span class="trinspam"> ' +
                        sssflag +
                        "</span>&nbsp</strong>" +
                        dataarray["addlinksDTIDtext" + k + ""].replaceAll(
                          ",",
                          ", "
                        ) +
                        "<br>";
                    }
                    if (dataarray["addpartiallyleveltext" + k + ""] != "") {
                      //01-08-2023
                      fromdatacoccatenamep +=
                        '<strong class="trinstrong">' +
                        namefromtext[k] +
                        '<span class="trinspam"> ' +
                        sssflag +
                        "</span>&nbsp</strong>" +
                        dataarray["addpartiallyleveltext" + k + ""].replaceAll(
                          ",",
                          ", "
                        ) +
                        "<br>";
                    }
                  }
                  //Defect_JC_92, modified by sahana for partially split and merge
                  else if (
                    returndata["action"][k] == "Partially Split & Merge"
                  ) {
                    //modified by sahana to change UI for partially Split and merge in district level summary 1809
                    fromnamenew =
                      '<strong><span class="trinspam">' +
                      sssflag +
                      '</span></strong> <strong class="trinstrong">' +
                      returndata["nametotext"] +
                      "</strong>, ";
                    if (dataarray["addlinksDTIDtext" + k + ""] != "") {
                      //01-08-2023
                      fromdatacoccatename +=
                        '<strong><span class="trinspam"> ' +
                        sssflag +
                        '</span></strong><strong class="trinstrong">' +
                        namefromtext[k] +
                        "-&nbsp</strong>" +
                        dataarray["addlinksDTIDtext" + k + ""].replaceAll(
                          ",",
                          ", "
                        ) +
                        "<br>";
                    }
                    if (dataarray["addpartiallyleveltext" + k + ""] != "") {
                      //01-08-2023
                      fromdatacoccatenamep +=
                        '<strong><span class="trinspam"> ' +
                        sssflag +
                        '</span></strong><strong class="trinstrong">' +
                        namefromtext[k] +
                        "-&nbsp</strong>" +
                        dataarray["addpartiallyleveltext" + k + ""].replaceAll(
                          ",",
                          ", "
                        ) +
                        "<br>";
                    }
                  } else {
                    //modified by sahana to change UI for partially merge in district level summary // modified by sahana status partially merge disctrict 1609
                    fromnamenew =
                      '<strong><span class="trinspam">' +
                      utsssflag +
                      '</span></strong> <strong class="trinstrong">' +
                      returndata["nametotext"] +
                      "</strong>, ";

                    if (dataarray["addlinksDTIDtext" + k + ""] != "") {
                      //01-08-2023
                      fromdatacoccatename +=
                        '<strong><span class="trinspam"> ' +
                        utsssflag +
                        '</span> </strong><strong class="trinstrong">' +
                        namefromtext[k] +
                        "</strong>-" +
                        dataarray["addlinksDTIDtext" + k + ""].replaceAll(
                          ",",
                          ", "
                        ) +
                        "<br>";
                    }
                    if (dataarray["addpartiallyleveltext" + k + ""] != "") {
                      //01-08-2023
                      fromdatacoccatenamep +=
                        '<strong><span class="trinspam"> ' +
                        utsssflag +
                        '</span> </strong><strong class="trinstrong">' +
                        namefromtext[k] +
                        "</strong>-" +
                        dataarray["addpartiallyleveltext" + k + ""].replaceAll(
                          ",",
                          ", "
                        ) +
                        "<br>";
                    }
                  }
                }
              }
              var nameflag = "";
              if (returndata["oremovenewarray"] == "1") {
                nameflag = returndata["newnamecheck"][0];
              } else {
                nameflag = returndata["nametotext"];
              }

              //modified by sahana status partially merge state 1509
              if (returndata["toStatus"] == "ST") {
                toStatus = "State";
              } else {
                toStatus = "Union Territory";
              }

              if (dataarray["applyon"] == "State") {
                mainaction +=
                  '<tr class="trleftalign"><td><strong>' +
                  toStatus +
                  ': <span class="trinstrong1">' +
                  nameflag +
                  '</span>&nbsp<span class="trinspam">' +
                  toflag +
                  "</span></strong></td><td>" +
                  fromdatacoccatename.replaceAll(",", ", ") +
                  "</td><td>" +
                  fromdatacoccatenamep.replaceAll(",", ", ") +
                  "</td></tr>";
              } else {
                //modified by sahana to change Partially merge table summary 01-08-2023
                mainaction +=
                  '<tr class="trleftalign"><td><strong><span class="trinspam">' +
                  dataarray["applyon"] +
                  ': </span><span class="trinstrong1">' +
                  nameflag +
                  "</span></strong></td><td>" +
                  fromdatacoccatename.replaceAll(",", ", ") +
                  "</td><td>" +
                  fromdatacoccatenamep.replaceAll(",", ", ") +
                  "</td></tr>";
              }

              mainaction += "</tbody></table>";

              stmsgname = stmsgname.slice(0, -2);

              utmsgname = utmsgname.slice(0, -2);
              stmsgname1 = stmsgname1.slice(0, -2);

              utmsgname1 = utmsgname1.slice(0, -2);
              fromnamenew = fromnamenew.slice(0, -2);

              if (dataarray["applyon"] == "State") {
                var ji = "";
                if (stmsgname != "") {
                  //ST- merge/ partially merge
                  ji =
                    '<span class="trinstrong1">' +
                    stmsgname +
                    "</span> " +
                    stflag +
                    "";
                }

                var ji1 = "";
                if (utmsgname1 != "") {
                  //UT- merge/ partially merge
                  ji1 =
                    '<span class="trinstrong1">' +
                    utmsgname1 +
                    "</span> " +
                    utflag +
                    "";
                }

                var jji = "";
                if (utmsgname != "") {
                  //UT- merge/ partially merge
                  jji =
                    '<span class="trinstrong1">' +
                    utmsgname +
                    "</span> " +
                    utflag +
                    "";
                }

                var jji1 = "";
                if (stmsgname1 != "") {
                  //ST- merge/ partially merge
                  jji1 =
                    '<span class="trinstrong1">' +
                    stmsgname1 +
                    "</span> " +
                    stflag +
                    "";
                }

                //modified by sahana to partially merge to add tostatus in summary
                if (returndata["toStatus"] == "ST") {
                  toStatus = "State";
                } else {
                  toStatus = "Union Territory";
                }

                //modified by sahana to add tostatus in summary message
                if (totalutcount == 0 && totalstcount != 0) {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong> - <span>" +
                    sssflag1 +
                    "(s)</span> : " +
                    ji +
                    " " +
                    ji1 +
                    ' </strong> <br> into <br><strong><span class="trinspam">' +
                    toStatus +
                    " : </span></strong> " +
                    fromnamenew +
                    "";
                } else if (totalstcount == 0 && totalutcount != 0) {
                  fmsg =
                    "(Total - " +
                    totalutcount +
                    " ) <strong> - <span>" +
                    utsssflag1 +
                    "(s)</span> : " +
                    jji +
                    " " +
                    jji1 +
                    '</strong> <br> into <br><strong><span class="trinspam">' +
                    toStatus +
                    " : </span></strong> " +
                    fromnamenew +
                    "";
                } else {
                  //modified by sahana to differentiate condition on Many to one for MP/PM //0509
                  if (stmsgname && utmsgname && !utmsgname1 && !stmsgname1) {
                    fmsg =
                      "(Total - " +
                      totalstcount +
                      " ) <strong> - <span>" +
                      sssflag1 +
                      "(s)</span> : " +
                      ji +
                      " </strong></strong><br> AND <br> (Total - " +
                      totalutcount +
                      " ) <strong> - <span>" +
                      utsssflag1 +
                      "(s)</span> : " +
                      jji +
                      '</strong>  <br> into <br><strong><span class="trinspam">' +
                      toStatus +
                      " : </span></strong>" +
                      fromnamenew +
                      "";
                  } else if (
                    utmsgname1 &&
                    stmsgname1 &&
                    !stmsgname &&
                    !utmsgname
                  ) {
                    fmsg =
                      "(Total - " +
                      totalstcount +
                      " ) <strong> - <span>" +
                      sssflag1 +
                      "(s)</span> : " +
                      ji1 +
                      " </strong></strong><br> AND <br> (Total - " +
                      totalutcount +
                      " ) <strong> - <span>" +
                      utsssflag1 +
                      "(s)</span> :  " +
                      jji1 +
                      '</strong>  <br> into <br><strong><span class="trinspam">' +
                      toStatus +
                      " : </span></strong>" +
                      fromnamenew +
                      "";
                  } else if (
                    stmsgname &&
                    !utmsgname1 &&
                    utmsgname &&
                    stmsgname1
                  ) {
                    fmsg =
                      "(Total - " +
                      totalstcount +
                      " ) <strong> - <span>" +
                      sssflag1 +
                      "(s)</span> : " +
                      ji +
                      "</strong></strong><br> AND <br> (Total - " +
                      totalutcount +
                      " ) <strong> - <span>" +
                      utsssflag1 +
                      "(s)</span> : " +
                      jji +
                      " &nbsp " +
                      jji1 +
                      ' </strong>  <br> into <br><strong><span class="trinspam">' +
                      toStatus +
                      " : </span></strong>" +
                      fromnamenew +
                      "";
                  } else if (
                    !stmsgname &&
                    utmsgname1 &&
                    utmsgname &&
                    stmsgname1
                  ) {
                    fmsg =
                      "(Total - " +
                      totalstcount +
                      " ) <strong> - <span>" +
                      sssflag1 +
                      "(s)</span> : " +
                      ji1 +
                      " </strong></strong><br> AND <br> (Total - " +
                      totalutcount +
                      " ) <strong> - <span>" +
                      utsssflag1 +
                      "(s)</span> : " +
                      jji +
                      " &nbsp " +
                      jji1 +
                      '</strong>  <br> into <br><strong><span class="trinspam">' +
                      toStatus +
                      " : </span></strong>" +
                      fromnamenew +
                      "";
                  }
                  //modified by sahana 08-09-2023
                  else if (stmsgname && utmsgname1 && utmsgname && stmsgname1) {
                    fmsg =
                      "(Total - " +
                      totalstcount +
                      " ) <strong> - <span>" +
                      sssflag1 +
                      "(s)</span> : " +
                      ji +
                      " &nbsp " +
                      ji1 +
                      " </strong></strong><br> AND <br> (Total - " +
                      totalutcount +
                      " ) <strong> - <span>" +
                      utsssflag1 +
                      "(s)</span> : " +
                      jji +
                      " &nbsp " +
                      jji1 +
                      ' </strong>  <br> into <br><strong><span class="trinspam">' +
                      toStatus +
                      " : </span></strong>" +
                      fromnamenew +
                      "";
                  }
                  //modified by sahana 18-09-2023
                  else if (
                    stmsgname &&
                    utmsgname1 &&
                    utmsgname &&
                    !stmsgname1
                  ) {
                    fmsg =
                      "(Total - " +
                      totalstcount +
                      " ) <strong> - <span>" +
                      sssflag1 +
                      "(s)</span> :" +
                      ji +
                      " &nbsp " +
                      ji1 +
                      "</strong></strong><br> AND <br> (Total - " +
                      totalutcount +
                      " ) <strong> - <span>" +
                      utsssflag1 +
                      "(s)</span> : " +
                      jji +
                      '</strong>  <br> into2 <br><strong><span class="trinspam">' +
                      toStatus +
                      " : </span></strong>" +
                      fromnamenew +
                      "";
                  }
                  //modified by sahana 18-09-2023
                  else if (
                    stmsgname &&
                    utmsgname1 &&
                    utmsgname &&
                    !stmsgname1
                  ) {
                    fmsg =
                      "(Total - " +
                      totalstcount +
                      " ) <strong> - <span>" +
                      sssflag1 +
                      "(s)</span> :" +
                      ji +
                      " &nbsp " +
                      ji1 +
                      "</strong></strong><br> AND <br> (Total - " +
                      totalutcount +
                      " ) <strong> - <span>" +
                      utsssflag1 +
                      "(s)</span> : " +
                      jji +
                      '</strong>  <br> into2 <br><strong><span class="trinspam">' +
                      toStatus +
                      " : </span></strong>" +
                      fromnamenew +
                      "";
                  } else {
                    fmsg =
                      "(Total - " +
                      totalstcount +
                      " ) <strong> - <span>" +
                      sssflag1 +
                      "(s)</span> :" +
                      jji1 +
                      " &nbsp " +
                      ji1 +
                      " </strong></strong><br> AND <br> (Total - " +
                      totalutcount +
                      " ) <strong> - <span>" +
                      utsssflag1 +
                      "(s)</span> : " +
                      jji +
                      " &nbsp " +
                      jji1 +
                      '</strong>  <br> into <br><strong><span class="trinspam">' +
                      toStatus +
                      " : </span></strong>" +
                      fromnamenew +
                      "";
                  }
                }
              }
              //Defect_JC_92, modified by sahana for partially split and merge
              else if (returndata["action"][0] == "Partially Split & Merge") {
                fmsg =
                  "(Total - " +
                  totalutcount +
                  " ) <strong> - " +
                  dataarray["applyon"] +
                  '(s) : <span class="trinstrong1">' +
                  utmsgname +
                  "</span> (" +
                  utflag +
                  ")</strong>  <br> into <br> " +
                  fromnamenew +
                  "";
              } else {
                // fmsg = '(Total - '+totalstcount+' ) <strong><span class="trinstrong1">'+stmsgname+'</span> '+dataarray['applyon']+'</strong>  <br> into <br> '+fromnamenew+'';
                if (totalutcount == 0 && totalstcount != 0) {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong> - " +
                    dataarray["applyon"] +
                    '(s) : <span class="trinstrong1">' +
                    stmsgname +
                    "</span></strong> <br> into <br> " +
                    fromnamenew +
                    "";
                } else if (totalstcount == 0 && totalutcount != 0) {
                  fmsg =
                    "(Total - " +
                    totalutcount +
                    " ) <strong> - " +
                    dataarray["applyon"] +
                    '(s) : <span class="trinstrong1">' +
                    utmsgname +
                    "</span></strong>  <br> into <br> " +
                    fromnamenew +
                    "";
                } else {
                  fmsg =
                    "(Total - " +
                    totalstcount +
                    " ) <strong> - " +
                    dataarray["applyon"] +
                    '(s) : <span class="trinstrong1">' +
                    stmsgname +
                    "</span></strong><br> AND <br> (Total - " +
                    totalutcount +
                    " ) <strong> - " +
                    dataarray["applyon"] +
                    '(s) : <span class="trinstrong1">' +
                    utmsgname +
                    "</span></strong>  <br> into <br> " +
                    fromnamenew +
                    "";
                }
              }

              if (returndata["oremovenewarray"] == "1") {
                if (returndata["StateStatus"][0] == "ST") {
                  sssflag = "Now State";
                } else if (returndata["StateStatus"][0] == "UT") {
                  sssflag = "Now Union Territory";
                } else {
                  sssflag = dataarray["applyon"];
                }

                fmsg =
                  fmsg +
                  " <br> AND <br> " +
                  fromnamenew +
                  ' name changed to <strong class="trinstrong">' +
                  returndata["newnamecheck"][0] +
                  '</strong> <strong><span class="trinspam">(' +
                  returndata["comefromcheck"] +
                  ")</span></strong>"; //modified by sahana status merge state 1509
              }

              var maintitaldata = fmsg;

              $("#maintitledata").html(maintitaldata);
              $("#mainaction").html(mainaction);

              var filename = $("#viewerlast")
                .contents()
                .get(0)
                .location.href.replace(/^.*[\\\/]/, "");
              // console.log(filename);
              $("#docname").text(decodeURIComponent(filename));
              $("#clickbutton").val(returndata["clickpopup"]);

              // JIGAR
            }
          }
        },
        error: function (jqXHR, exception) {
          if (jqXHR.status === 0) {
            Command: toastr["error"]("Not connect.n Verify Network.");
          } else if (jqXHR.status == 404) {
            Command: toastr["error"]("Requested page not found. [404]");
          } else if (jqXHR.status == 500) {
            Command: toastr["error"]("Internal Server Error [500].");
          } else if (exception === "timeout") {
            Command: toastr["error"]("Time out error.");
          } else if (exception === "abort") {
            Command: toastr["error"]("Ajax request aborted.");
          } else {
            Command: toastr["error"]("Uncaught Error.n");
          }
        },
      });
    }
  });

  $("#addstate").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "adddata") {
          //  Command: toastr["success"]("Successfully added state.");
          //  setTimeout(function () { location.reload() }, 3000);
          $("#con-close-modal-add .close").click();
          Swal.fire({
            title: "Successfully added state.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });
          //       location.reload();

          return false;
        } else if (data == "statenamealready") {
          Command: toastr["warning"]("State name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#adddistricts").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "adddata") {
          // Command: toastr["success"]("Successfully added dis.");
          //  setTimeout(function () { location.reload() }, 3000);

          $("#con-close-modal-add .close").click();
          Swal.fire({
            title: "Successfully added districts.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });
          return false;
        } else if (data == "dtnamealready") {
          Command: toastr["warning"]("Districts name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#addsubdistricts").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "adddata") {
          $("#con-close-modal-add .close").click();
          Swal.fire({
            title: "Successfully added subdistricts.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });
          return false;
        } else if (data == "sdtnamealready") {
          Command: toastr["warning"]("Sub Districts name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#addvillages").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "adddata") {
          $("#con-close-modal-add .close").click();
          Swal.fire({
            title: "Successfully added village.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });
          return false;
        } else if (data == "vtnamealready") {
          Command: toastr["warning"]("Village name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#addward").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "adddata") {
          $("#con-close-modal-add .close").click();
          Swal.fire({
            title: "Successfully added ward.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });
          return false;
        } else if (data == "wdnamealready") {
          Command: toastr["warning"]("Ward name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#olddocumentselect").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();
    var form = this;

    var rows_selected = $("#alreadydoc-datatable")
      .DataTable()
      .column(0)
      .checkboxes.selected();

    if (rows_selected.length == 0) {
      Command: toastr["error"](
        "Please select at least one record to continue."
      );
      return false;
    } else {
      if (rows_selected.length > 1) {
        Command: toastr["error"]("Please select only one record to continue.");
        return false;
      } else {
        $.each(rows_selected, function (index, rowId) {
          // Create a hidden element
          $(form).append(
            $("<input>").attr("type", "hidden").attr("name", "id[]").val(rowId)
          );
        });

        var dataform = new FormData(this);
        // dataform.append('stname', namefromtext);

        $.ajax({
          url: "insert_data.php", // Url to which the request is send
          type: "POST",
          data: dataform, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
          contentType: false, // The content type used when sending data to the server.
          cache: false, // To unable request pages to be cached
          processData: false, // To send DOMDocument or non processed data file it is set to false
          success: function (
            data // A function to be called if request succeeds
          ) {
            var res = data.split("|");

            if (res[0] == "adddata") {
              $("#alreadydocument").modal("hide");

              $("#progressbarwizard1").bootstrapWizard("next");

              $("#docids").val(res[1]);
              $("#dtstname").val(res[3]);
              $("#selectstid").val(res[4]);
              $("#viewerlast").css("display", "block");
              $("#pdf").css("display", "block");
              $("#viewerlast").attr("src", res[2]);
              $("#uploadeddocument").val(res[2]);

              $("#docidsmrg").val(res[1]);
              $("#dtstnamemrg").val(res[3]);
              $("#selectstidmrg").val(res[4]);
              $("#uploadeddocumentmrg").val(res[2]);

              return false;
            } else if (res[0] == "aleradydatedata") {
              $("#alreadydocument").modal("show");
              var tablejig = $("#alreadydoc-datatable").DataTable({
                lengthMenu: [
                  [10, 25, 50, 100, -1],
                  [10, 25, 50, 100, "All"],
                ],
                processing: true,
                serverSide: true,
                bServerSide: true,
                bDestroy: true,
                ajax: {
                  url: "insert_data.php",
                  type: "POST",
                  data: function (d) {
                    d.formname = "getdocalreadyuploadlist";
                    d.STID2021 = res[1];
                    d.dateselected = res[2];
                    d.doctitle = res[3];
                  },
                },
                columnDefs: [
                  {
                    targets: 0,
                    checkboxes: {
                      selectRow: true,
                    },
                  },
                  { targets: 1, visible: false },
                  { targets: 6, className: "wrap" },
                  {
                    targets: 7,
                    render: function (dataa, type, row, meta) {
                      if (type === "display") {
                        data =
                          '<a href="Alldocuments/' +
                          res[1] +
                          "/" +
                          encodeURIComponent(dataa) +
                          '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
                      }
                      return data;
                    },
                  },
                ],

                select: {
                  style: "single",
                },
                order: [[1, "asc"]],
                initComplete: function (settings, json) {
                  if (json.data.length > 0) {
                    $("#dataids").val(json.data[0][2]);
                  }
                },
              });

              return false;
            } else if (res[0] == "fileuploadproblem") {
              Command: toastr["warning"](
                "File Upload Problem Try After Some time."
              );
              return false;
            } else if (res[0] == "error") {
              Command: toastr["error"]("Server Problem try after sometime.");
              return false;
            }
          },
          error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
              Command: toastr["error"]("Not connect.n Verify Network.");
            } else if (jqXHR.status == 404) {
              Command: toastr["error"]("Requested page not found. [404]");
            } else if (jqXHR.status == 500) {
              Command: toastr["error"]("Internal Server Error [500].");
            } else if (exception === "timeout") {
              Command: toastr["error"]("Time out error.");
            } else if (exception === "abort") {
              Command: toastr["error"]("Ajax request aborted.");
            } else {
              Command: toastr["error"]("Uncaught Error.n");
            }
          },
        });
      }
    }
  });

  //original document code. do not touch
  //     $("#adddocument").submit(function (e) {
  //         toastr.options = {
  //             "closeButton": false,
  //             "debug": false,
  //             "newestOnTop": false,
  //             "progressBar": false,
  //             "positionClass": "toast-top-right",
  //             "preventDuplicates": false,
  //             "onclick": null,
  //             "showDuration": "300",
  //             "hideDuration": "1000",
  //             "timeOut": "5000",
  //             "extendedTimeOut": "1000",
  //             "showEasing": "swing",
  //             "hideEasing": "linear",
  //             "showMethod": "fadeIn",
  //             "hideMethod": "fadeOut"
  //         }
  //         e.preventDefault();

  // $('#adddocument').find('input, textarea, button, select').removeAttr('disabled','disabled');

  //         var namefromtext = $('select[name="addSTID2021"] option:selected').map(function () {
  //                 return this.text;

  //         }).get();
  //         var dataform = new FormData(this);
  //         dataform.append('stname', encodeURIComponent(namefromtext));

  //         $.ajax({
  //             url: "insert_data.php", // Url to which the request is send
  //             type: "POST",
  //             data: dataform, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
  //             contentType: false,       // The content type used when sending data to the server.
  //             cache: false,             // To unable request pages to be cached
  //             processData: false,        // To send DOMDocument or non processed data file it is set to false
  //             success: function (data)   // A function to be called if request succeeds
  //             {
  //                 var res = data.split('|');

  //                 if (res[0] == 'adddata') {

  //                         if(res[6]==0)
  //                         {
  //                                  //modified by sahana for linked document sweetalerts
  //                                  Swal.fire({
  //                                     title: "Linked Document Uploaded Successfully Without Action",
  //                                 type: "success",
  //                                 confirmButtonColor: "#348cd4"
  //                                 }).then(function (t) {
  //                                 if (t.value) {
  //                                 window.location.href = 'document';
  //                                 }
  //                                 })

  //                         }
  //                         else
  //                         {

  //                             if(res[5]!='')
  //                             {
  //                             $('#alreadydocument').modal('hide');
  //                             }

  //                             $('#progressbarwizard1').bootstrapWizard('next');

  //                             $('#docids').val(res[1]);
  //                             $('#dtstname').val(res[3]);
  //                             $('#selectstid').val(res[4]);

  //                             $('#docidssub').val(res[1]);

  //                             $('#docidsmrg').val(res[1]);
  //                             $('#dtstnamemrg').val(res[3]);
  //                             $('#selectstidmrg').val(res[4]);
  //                             $('#uploadeddocumentmrg').val(res[2]);

  //                             $('#viewerlast').css("display", "block");
  //                             $('#pdf').css("display", "block")
  //                             $('#viewerlast').attr('src',res[2]);
  //                             $('#uploadeddocument').val(res[2]);
  //                             return false;

  //                         }

  //                 }
  //                 else if (res[0] == 'aleradydatedata') {
  //                     //  console.log(res);
  //                                  $('#alreadydocument').modal('show');
  //                                  var tablejig = $('#alreadydoc-datatable').DataTable({
  //                                  "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
  //                                  "processing": true,
  //                                  "serverSide": true,
  //                                  "bServerSide": true,
  //                                  "bDestroy": true,
  //                                  "ajax": {
  //                                  "url": "insert_data.php",
  //                                  "type": "POST",
  //                                      "data": function (d) {
  //                                      d.formname = "getdocalreadyuploadlist";
  //                                      d.STID2021 = res[1];
  //                                      d.dateselected = res[2];
  //                                       d.doctitle = res[3];
  //                                       d.oldfilename = res[4];
  //                                       d.doctype = res[5];

  //                                      }
  //                                  }, 'columnDefs': [
  //                                  {
  //                                  'targets': 0,
  //                                  'checkboxes': {
  //                                  'selectRow': true
  //                                  }
  //                                  },
  //                                  { 'targets': 1,  "visible": false, },
  //                                  { 'targets': 6, 'className': "wrap" }
  //                                  ,
  //                                  {
  //                                  'targets': 7,
  //                                  render: function (dataa, type, row, meta) {

  //                                  if (type === 'display') {
  //                                      data = '<a href="Alldocuments/' + res[1] + '/' + encodeURIComponent(dataa) + '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
  //                                  }
  //                                  return data;
  //                                  }

  //                                  }
  //                                  ],

  //                                  'select': {
  //                                  'style': 'single',
  //                                  },
  //                                  'order': [[1, 'asc']],
  //                                  "initComplete": function (settings, json) {

  //                                  if (json.data.length > 0) {
  //                                  $('#dataids').val(json.data[0][2]);
  //                                  }

  //                                  }
  //                                  });

  //                      return false;
  //                  }
  //                  else if (res[0] == 'fileuploadproblem') {
  //                      Command: toastr["warning"]("File Upload Problem Try After Some time.");
  //                      return false;
  //                  }
  //                  //modified by sahana to validated filesize fro document
  //                  else if (res[0] == 'filesizeerror') {
  //                     Command: toastr["warning"]("The Document you are trying to upload may already Exist. Please Verify...");
  //                     return false;
  //                 }
  //                  // else if (res[0] == 'error') {
  //                  //     Command: toastr["error"]("Server Problem try after sometime.");
  //                  //     return false;
  //                  // }
  //                  // modified by sahana for document not to be repeated
  //                  else if (res[0] == 'error') {
  //                     // veena toaster msg
  //                      Command: toastr["error"]("This Document number already exists. Please use an unique number");
  //                      return false;
  //                  }
  //              },
  //              error: function (jqXHR, exception) {

  //                  if (jqXHR.status === 0) {
  //                     // veena toaster msg
  //                      Command: toastr["error"]("Not connected.\n Verify Network.")

  //                  } else if (jqXHR.status == 404) {
  //                      Command: toastr["error"]("Requested page not found. [404]")

  //                  } else if (jqXHR.status == 500) {
  //                      Command: toastr["error"]("Internal Server Error [500].")

  //                  }
  //                  else if (exception === 'timeout') {
  //                      Command: toastr["error"]("Time out error.")

  //                  } else if (exception === 'abort') {
  //                      Command: toastr["error"]("Ajax request aborted.")

  //                  } else {
  //                      Command: toastr["error"]("Uncaught Error.n")

  //                  }
  //              }
  //          });
  //      });

  //modified by sahana new document code

  $(document).ready(function () {
    var isSubmitting = false;

    $("#adddocument").submit(function (e) {
      if (!isSubmitting) {
        isSubmitting = true;
        $("#submitButton").prop("disabled", true);
        console.log("Save Button is now disabled.");

        toastr.options = {
          closeButton: false,
          debug: false,
          newestOnTop: false,
          progressBar: false,
          positionClass: "toast-top-center",
          preventDuplicates: false,
          onclick: null,
          showDuration: "300",
          hideDuration: "2000",
          timeOut: "5000",
          extendedTimeOut: "1000",
          showEasing: "swing",
          hideEasing: "linear",
          showMethod: "fadeIn",
          hideMethod: "fadeOut",
          onHidden: function () {
            enableSubmitButton();
          },
        };

        e.preventDefault();

        $("#adddocument")
          .find("input, textarea, button, select")
          .removeAttr("disabled", "disabled");

        var namefromtext = $('select[name="addSTID2021"] option:selected')
          .map(function () {
            return this.text;
          })
          .get();
        var dataform = new FormData(this);
        dataform.append("stname", encodeURIComponent(namefromtext));

        $.ajax({
          url: "insert_data.php", // Url to which the request is sent
          type: "POST",
          data: dataform, // Data sent to the server, a set of key/value pairs (i.e. form fields and values)
          contentType: false, // The content type used when sending data to the server.
          cache: false, // To disable request pages caching
          processData: false, // To send DOMDocument or non-processed data file, it is set to false
          success: function (data) {
            var res = data.split("|");

            if (res[0] == "adddata") {
              if (res[6] == 0) {
                // Modified by sahana for linked document sweetalerts
                Swal.fire({
                  title: "Linked Document Uploaded Successfully Without Action",
                  type: "success",
                  confirmButtonColor: "#348cd4",
                }).then(function (t) {
                  if (t.value) {
                    window.location.href = "document";
                  }
                });
              } else {
                if (res[5] != "") {
                  $("#alreadydocument").modal("hide");
                }

                $("#progressbarwizard1").bootstrapWizard("next");
                $("#docids").val(res[1]);
                $("#dtstname").val(res[3]);
                $("#selectstid").val(res[4]);
                $("#docidssub").val(res[1]);
                $("#docidsmrg").val(res[1]);
                $("#dtstnamemrg").val(res[3]);
                $("#selectstidmrg").val(res[4]);
                $("#uploadeddocumentmrg").val(res[2]);
                $("#viewerlast").css("display", "block");
                $("#pdf").css("display", "block");
                $("#viewerlast").attr("src", res[2]);
                $("#uploadeddocument").val(res[2]);
              }
            } else if (res[0] == "aleradydatedata") {
              // console.log(res);
              $("#alreadydocument").modal("show");
              var tablejig = $("#alreadydoc-datatable").DataTable({
                lengthMenu: [
                  [10, 25, 50, 100, -1],
                  [10, 25, 50, 100, "All"],
                ],
                processing: true,
                serverSide: true,
                bServerSide: true,
                bDestroy: true,
                ajax: {
                  url: "insert_data.php",
                  type: "POST",
                  data: function (d) {
                    d.formname = "getdocalreadyuploadlist";
                    d.STID2021 = res[1];
                    d.dateselected = res[2];
                    d.doctitle = res[3];
                    d.oldfilename = res[4];
                    d.doctype = res[5];
                  },
                },
                columnDefs: [
                  {
                    targets: 0,
                    checkboxes: {
                      selectRow: true,
                    },
                  },
                  { targets: 1, visible: false },
                  { targets: 6, className: "wrap" },
                  {
                    targets: 7,
                    render: function (dataa, type, row, meta) {
                      if (type === "display") {
                        data =
                          '<a href="Alldocuments/' +
                          res[1] +
                          "/" +
                          encodeURIComponent(dataa) +
                          '" target="_blank"><i class="fas fa-file-alt fa-2x mb-2" data-toggle="tooltip" data-placement="top" title="" data-original-title=""></i></a>';
                      }
                      return data;
                    },
                  },
                ],
                select: {
                  style: "single",
                },
                order: [[1, "asc"]],
                initComplete: function (settings, json) {
                  if (json.data.length > 0) {
                    $("#dataids").val(json.data[0][2]);
                  }
                },
              });
              return false;
            } else if (res[0] == "fileuploadproblem") {
              toastr.warning("File Upload Problem Try After Some time.");
              // enableSubmitButton();
              return false;
            } else if (res[0] == "filesizeerror") {
              toastr.info(
                "The Document you are trying to upload may already Exist. Please Verify..."
              );
              // enableSubmitButton();
              return false;
            } else if (res[0] == "error") {
              // veena toaster msg
              toastr.error(
                "This Document number already exists. Please use a unique number"
              );
              // enableSubmitButton();
              return false;
            }
          },
          error: function (jqXHR, exception) {
            if (jqXHR.status === 0) {
              // veena toaster msg
              toastr.error("Please wait....Try again.");
            } else if (jqXHR.status == 404) {
              toastr.error("Requested page not found. [404]");
            } else if (jqXHR.status == 500) {
              toastr.error("Internal Server Error [500].");
            } else if (exception === "timeout") {
              toastr.error("Time out error.");
            } else if (exception === "abort") {
              toastr.error("Ajax request aborted.");
            } else {
              toastr.error("Uncaught Error.");
            }
            enableSubmitButton();
          },
        });
        return true; // Continue with the normal form submission
      } else {
        e.preventDefault(); // Prevent the form from submitting again
        return false;
      }
    });
    function enableSubmitButton() {
      isSubmitting = false;
      $("#submitButton").prop("disabled", false);
    }
  });

  $("#adduser").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();
    $.ajax({
      url: "insert_data.php",
      type: "POST",
      data: new FormData(this),
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        if (data == "addeduser") {
          $("#con-close-modal-add .close").click();
          Swal.fire({
            title: "Completed Successfully",
            type: "success",
            confirmButtonColor: "#348CD4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });
          return false;
        } else if (data == "emailalready") {
          toastr["error"]("This Email ID already exists.");
          return false;
        } else if (data == "loginidalready") {
          toastr["error"]("This Login ID already exists.");
          return false;
        } else if (data == "mobilealready") {
          toastr["error"](
            "This Mobile Number already exists. Use another to process further."
          );
          return false;
        } else if (data == "userlimitexceeded") {
          toastr["error"](
            "ORGI User Limit Exceeded, Can be upto 15 Users only."
          );
          return false;
        } else if (data == "dcouserlimitexceeded") {
          toastr["error"](
            "DCO User Limit Exceeded, Can be upto 30 Users only."
          );
          return false;
        } else if (data == "adminnameexists") {
          toastr["error"](
            "DCO Admin Login ID already exists. Cannot have more than 1 Admin."
          );
          return false;
        } else if (data == "bothemailnamealready") {
          toastr["error"]("Both Login ID & Email ID already exists.");
          return false;
        } else if (data == "bothemailnamemobilealready") {
          toastr["error"]("Login ID, Email ID, Mobile Number already exists.");
          return false;
        } else if (data == "bothemailmobilealready") {
          toastr["error"]("Both Email ID & Mobile Number already exists.");
          return false;
        } else if (data == "error") {
          toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          toastr["error"]("Not connected. Verify Network.");
        } else if (jqXHR.status == 404) {
          toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          toastr["error"]("Ajax request aborted.");
        } else {
          toastr["error"]("Uncaught Error.\n");
        }
      },
    });
  });

  $("#oremovemrgp1").change(function (event) {
    var status = event.target.checked;

    if (status == true) {
      $("#newnamecheckp").val("");
      $("#newnameshowp").css("display", "block");
      $("#newnamecheckp").prop("required", true);
    } else {
      $("#newnamecheckp").val("");
      $("#newnameshowp").css("display", "none");
      $("#newnamecheckp").prop("required", false);
    }
    return false;
  });

  $(".swi").change(function (event) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "500",
      timeOut: "2000",
      extendedTimeOut: "500",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };

    var status = event.target.checked;
    if (status) {
      var statuschange = 1;
    } else {
      var statuschange = 0;
    }
    var data = JSON.parse(event.target.dataset.todo);
    event.preventDefault();
    var formData = new FormData();
    formData.append("formname", "activedeactiveuser");
    formData.append("id", data.id);
    formData.append("status", statuschange);
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "activate") {
          Command: toastr["success"]("Successfully activated user.");
          return false;
        } else if (data == "deactivat") {
          Command: toastr["success"]("Successfully deactivated user.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });

    return false;
  });

  $("#documentlink").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "adddata") {
          //  Command: toastr["success"]("Successfully added state.");
          //  setTimeout(function () { location.reload() }, 3000);
          $("#con-close-modal-linkdc .close").click();
          Swal.fire({
            title: "Completed Successfully",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });
          //       location.reload();

          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#updatestate").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("formname", "updatestatedata");
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "updatedata") {
          //   Command: toastr["success"]("Successfully updated state.");
          // $('#con-close-modal').modal('hide');

          $("#con-close-modal .close").click();
          Swal.fire({
            title: "Completed Successfully",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });

          return false;
        } else if (data == "statenamealready") {
          Command: toastr["warning"]("State name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#updatedistricts").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("formname", "updatedistrictsdata");
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "updatedata") {
          //   Command: toastr["success"]("Successfully updated state.");
          // $('#con-close-modal').modal('hide');

          $("#con-close-modal .close").click();
          Swal.fire({
            title: "Successfully updated districts.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });

          return false;
        } else if (data == "dtnamealready") {
          Command: toastr["warning"]("Districts name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#updatesubdistricts").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("formname", "updatesubdistrictsdata");
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "updatedata") {
          //   Command: toastr["success"]("Successfully updated state.");
          // $('#con-close-modal').modal('hide');

          $("#con-close-modal .close").click();
          Swal.fire({
            title: "Successfully updated districts.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });

          return false;
        } else if (data == "dtnamealready") {
          Command: toastr["warning"]("Districts name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.\n");
        }
      },
    });
  });

  $("#updatevillages").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("formname", "updatevillagedata");
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "updatedata") {
          //   Command: toastr["success"]("Successfully updated state.");
          // $('#con-close-modal').modal('hide');

          $("#con-close-modal .close").click();
          Swal.fire({
            title: "Successfully updated village.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });

          return false;
        } else if (data == "vtnamealready") {
          Command: toastr["warning"]("Village name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.\n");
        }
      },
    });
  });

  $("#updateward").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("formname", "updatewarddata");
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "updatedata") {
          //   Command: toastr["success"]("Successfully updated state.");
          // $('#con-close-modal').modal('hide');

          $("#con-close-modal .close").click();
          Swal.fire({
            title: "Successfully updated Ward.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });

          return false;
        } else if (data == "wdnamealready") {
          Command: toastr["warning"]("Ward name already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.\n");
        }
      },
    });
  });

  $("#updatedocuments").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("formname", "updatedocumentsdata");
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "updatedata") {
          //   Command: toastr["success"]("Successfully updated state.");
          // $('#con-close-modal').modal('hide');

          $("#con-close-modal .close").click();
          Swal.fire({
            title: "Successfully updated documents.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });

          return false;
        }
        // else if(data == 'dtnamealready')
        // {
        //    Command: toastr["warning"]("Districts name already exists.");
        // return false;
        // }
        else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.\n");
        }
      },
    });
  });
  $("#users-units-datatable tbody").on(
    "click",
    "tr td.btnresetpass",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);
      // alert(data.id);
      $("#userids").val(data.id);
    }
  );

  //modified by sahana to freez important dates validation
  $("#saveimportantdate").submit(function (e) {
    e.preventDefault();

    // Validate the form data here

    var formData = new FormData(this);
    formData.append("formname", "saveimpdate");

    // Get the values of the 'previousdate' and 'documentdate' fields
    var previousdate = $("#ipreviousdate").val();
    var documentdate = $("#idocumentdate").val();

    // Append the values to the form data
    formData.append("previousdate", previousdate);
    formData.append("documentdate", documentdate);

    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "savequery") {
          Command: toastr["success"]("Important Dates Freezed Successfully.");

          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.\n");
        }
      },
    });
  });

  $("#resetupdateusers").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("formname", "resetupdateusersdata");
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "changepassword") {
          Command: toastr["success"]("Reset Password Successfully.");
          $("#con-close-modal").modal("hide");

          $("#resetcon-close-modal .close").click();
          $("#resetcon-close-modal").find("form").parsley().reset();
          $("#resetcon-close-modal").find("form")[0].reset();
          $("#resetcon-close-modal")
            .find("form select")
            .select2()
            .trigger("change");

          return false;
        } else if (data == "passwordvarification") {
          Command: toastr["warning"](
            "Password should be at least 8 to 16 characters in length and should include at least one upper case letter, one lower case letter, one number, and one special character."
          );
          return false;
        } else if (data == "samepass") {
          Command: toastr["warning"](
            "New password is similar to the last 2 passwords.Kindly use unique one."
          );
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  $("#updateusers").submit(function (e) {
    toastr.options = {
      closeButton: false,
      debug: false,
      newestOnTop: false,
      progressBar: false,
      positionClass: "toast-top-right",
      preventDuplicates: false,
      onclick: null,
      showDuration: "300",
      hideDuration: "1000",
      timeOut: "5000",
      extendedTimeOut: "1000",
      showEasing: "swing",
      hideEasing: "linear",
      showMethod: "fadeIn",
      hideMethod: "fadeOut",
    };
    e.preventDefault();

    var formData = new FormData(this);
    formData.append("formname", "updateusersdata");
    $.ajax({
      url: "insert_data.php", // Url to which the request is send
      type: "POST",
      data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
      contentType: false, // The content type used when sending data to the server.
      cache: false, // To unable request pages to be cached
      processData: false, // To send DOMDocument or non processed data file it is set to false
      success: function (
        data // A function to be called if request succeeds
      ) {
        if (data == "updatedata") {
          //   Command: toastr["success"]("Successfully updated state.");
          // $('#con-close-modal').modal('hide');

          $("#con-close-modal .close").click();
          Swal.fire({
            title: "Successfully updated user.",
            type: "success",
            confirmButtonColor: "#348cd4",
          }).then(function (t) {
            if (t.value) {
              location.reload();
            }
          });

          return false;
        } else if (data == "emailalready") {
          Command: toastr["warning"]("Email already exists.");
          return false;
        } else if (data == "error") {
          Command: toastr["error"]("Server Problem try after sometime.");
          return false;
        }
      },
      error: function (jqXHR, exception) {
        if (jqXHR.status === 0) {
          Command: toastr["error"]("Not connect.\n Verify Network.");
        } else if (jqXHR.status == 404) {
          Command: toastr["error"]("Requested page not found. [404]");
        } else if (jqXHR.status == 500) {
          Command: toastr["error"]("Internal Server Error [500].");
        } else if (exception === "timeout") {
          Command: toastr["error"]("Time out error.");
        } else if (exception === "abort") {
          Command: toastr["error"]("Ajax request aborted.");
        } else {
          Command: toastr["error"]("Uncaught Error.n");
        }
      },
    });
  });

  var userstable = $("#users-units-datatable").DataTable({
    order: [[0, "desc"]],
    scrollX: "100%",
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });

  // $('#users-units-datatable tbody').on('click', 'tr td .swi', function (event) {
  //     console.log(event.target.dataset.todo);

  //     var data = JSON.parse(event.target.dataset.todo);

  //     return false;
  // });

  function generatePassword(passwordLength) {
    var numberChars = "0123456789";
    var upperChars = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
    var lowerChars = "abcdefghijklmnopqrstuvwxyz";
    var specialchars = "!";
    var allChars = numberChars + upperChars + lowerChars + specialchars;
    var randPasswordArray = Array(passwordLength);
    randPasswordArray[0] = numberChars;
    randPasswordArray[1] = upperChars;
    randPasswordArray[2] = lowerChars;
    randPasswordArray[3] = specialchars;
    randPasswordArray = randPasswordArray.fill(allChars, 4);
    return shuffleArray(
      randPasswordArray.map(function (x) {
        return x[Math.floor(Math.random() * x.length)];
      })
    ).join("");
  }

  function shuffleArray(array) {
    for (var i = array.length - 1; i > 0; i--) {
      var j = Math.floor(Math.random() * (i + 1));
      var temp = array[i];
      array[i] = array[j];
      array[j] = temp;
    }
    return array;
  }

  var circularstable = $("#circulars-units-datatable").DataTable({
    order: [[0, "desc"]],
    scrollX: "100%",
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });

  var documents = $("#documents-units-datatable").DataTable({
    order: [[0, "desc"]],
    scrollX: "100%",
    fixedHeader: true,
    pageLength: -1,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });

  var table = $("#units-datatable").DataTable({
    order: [],
    scrollX: "100%",
    fixedHeader: true,
    pageLength: -1,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });

  var tablestate = $("#tST-datatable").DataTable({
    order: [],
    scrollX: "100%",
    fixedHeader: true,
    pageLength: -1,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });
  var tabledist = $("#tDT-datatable").DataTable({
    order: [],
    scrollX: "100%",
    fixedHeader: true,
    pageLength: -1,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });
  var tablesdist = $("#tSD-datatable").DataTable({
    order: [],
    scrollX: "100%",
    fixedHeader: true,
    pageLength: -1,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });
  // var tablevt = $("#tVT-datatable").DataTable({ "order": [], "scrollX": "100%","fixedHeader": true,"pageLength": -1, "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]] });

  var tableindex = $("#index-datatable").DataTable({
    order: [],
    scrollX: "100%",
    fixedHeader: true,
    pageLength: -1,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });
  $("#index-datatable tbody").on("click", "tr td span", function (event) {
    var data = JSON.parse(event.target.dataset.todo);
    window.location.href = "adddocument?ids=" + btoa(event.target.dataset.todo);
    return false;
  });

  var tablelink = $("#unitslink-datatable").DataTable({
    order: [],
    scrollX: "100%",
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });

  $("#units-datatable tbody").on(
    "click",
    "tr td:last-child a.dropdown-toggle",
    function () {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnEditnew",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);
      var formData = new FormData();
      formData.append("formname", "get_forread_updatedata");
      formData.append("STID2021", $(this).data("id"));
      $.ajax({
        url: "insert_data.php", // Url to which the request is send
        type: "POST",
        data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function (
          data1 // A function to be called if request succeeds
        ) {
          var res = data1.split("|");
          $("#update_ids").val(data.STID2021);
          $("#STName2011").val(data.STName2011);
          $("#Short_ST2011").val(data.Short_ST2011);
          $("#MDDS_ST2011").val(data.MDDS_ST2011);
          $("#STName2021").val(data.STName2021);
          $("#Short_ST2021").val(data.Short_ST2021);
          $("#MDDS_ST2021").val(data.MDDS_ST2021);
          $("#upStatus2021").select2().select2("val", data.Status2021);
          $(".field_wrapper1").html("");
          $(".field_wrapper1").append(res[0]);
          $("#getrecords").val(res[1]);
          $("select.form-select").select2({
            maximumInputLength: 20, // only allow terms up to 20 characters long
          });
          $("#con-close-modal").modal("show");
        },
        error: function (jqXHR, exception) {
          if (jqXHR.status === 0) {
            Command: toastr["error"]("Not connect.\n Verify Network.");
          } else if (jqXHR.status == 404) {
            Command: toastr["error"]("Requested page not found. [404]");
          } else if (jqXHR.status == 500) {
            Command: toastr["error"]("Internal Server Error [500].");
          } else if (exception === "timeout") {
            Command: toastr["error"]("Time out error.");
          } else if (exception === "abort") {
            Command: toastr["error"]("Ajax request aborted.");
          } else {
            Command: toastr["error"]("Uncaught Error.\n");
          }
        },
      });

      // $('#update_ids').val($(this).data('id'));
      // $('#STName2011').val(data.STName2011);
      // $('#Short_ST2011').val(data.Short_ST2011);
      // $('#MDDS_ST2011').val(data.MDDS_ST2011);
      // $('#STName2021').val(data.STName2021);
      // $('#Short_ST2021').val(data.Short_ST2021);
      // $('#MDDS_ST2021').val(data.MDDS_ST2021);
      // $("#upStatus2021").select2().select2('val', data.Status2021);

      // $('#con-close-modal').modal('show');
      return false;
    }
  );

  $("#add_users").on("click", function (event) {
    // $('#addpassword').val(generatePassword(8));
    $("#con-close-modal-add123").modal("show");
    return false;
  });

  $("#districts-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnlink",
    function (event) {
      return false;
    }
  );

  $("#users-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.deletetablerow",
    function (event) {
      var data = event.target.id;

      Swal.fire({
        title: "Are you sure?",

        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#348cd4",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
      }).then(function (t) {
        if (t.value) {
          var formData = new FormData();
          formData.append("formname", "Deletion");
          formData.append("deletedids", data);

          $.ajax({
            url: "insert_data.php", // Url to which the request is send
            type: "POST",
            data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (
              data // A function to be called if request succeeds
            ) {
              if (data == "deletedata") {
                // Swal.fire("Deleted!", "Your record has been deleted.", "success")
                Swal.fire({
                  title: "Deleted",
                  text: "Your record has been deleted.",
                  type: "success",
                }).then(function (t) {
                  location.reload();
                });

                return false;
              } else if (data == "error") {
                Command: toastr["error"]("Server Problem try after sometime.");
                return false;
              }
            },
            error: function (jqXHR, exception) {
              if (jqXHR.status === 0) {
                Command: toastr["error"]("Not connect.\n Verify Network.");
              } else if (jqXHR.status == 404) {
                Command: toastr["error"]("Requested page not found. [404]");
              } else if (jqXHR.status == 500) {
                Command: toastr["error"]("Internal Server Error [500].");
              } else if (exception === "timeout") {
                Command: toastr["error"]("Time out error.");
              } else if (exception === "abort") {
                Command: toastr["error"]("Ajax request aborted.");
              } else {
                Command: toastr["error"]("Uncaught Error.\n");
              }
            },
          });
        }
      });
      return false;
    }
  );

  $("#units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.deletetablerow",
    function (event) {
      var data = event.target.id;

      Swal.fire({
        title: "Are you sure?",

        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#348cd4",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
      }).then(function (t) {
        if (t.value) {
          var formData = new FormData();
          formData.append("formname", "deletestate");
          formData.append("deletedids", data);

          $.ajax({
            url: "insert_data.php", // Url to which the request is send
            type: "POST",
            data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (
              data // A function to be called if request succeeds
            ) {
              if (data == "deletedata") {
                // Swal.fire("Deleted!", "Your record has been deleted.", "success")
                Swal.fire({
                  title: "Deleted",
                  text: "Your record has been deleted.",
                  type: "success",
                }).then(function (t) {
                  location.reload();
                });

                return false;
              } else if (data == "error") {
                Command: toastr["error"]("Server Problem try after sometime.");
                return false;
              }
            },
            error: function (jqXHR, exception) {
              if (jqXHR.status === 0) {
                Command: toastr["error"]("Not connect.\n Verify Network.");
              } else if (jqXHR.status == 404) {
                Command: toastr["error"]("Requested page not found. [404]");
              } else if (jqXHR.status == 500) {
                Command: toastr["error"]("Internal Server Error [500].");
              } else if (exception === "timeout") {
                Command: toastr["error"]("Time out error.");
              } else if (exception === "abort") {
                Command: toastr["error"]("Ajax request aborted.");
              } else {
                Command: toastr["error"]("Uncaught Error\n");
              }
            },
          });
        }
      });
      return false;
    }
  );

  $("#units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.noaction",
    function (event) {
      Swal.fire({
        title: "Not authorized to access",
        text: "You are not authorized to access",
        type: "warning",
        confirmButtonColor: "#348cd4",
      });
      return false;
    }
  );

  $("#units-datatable tbody").on("click", "tr td a.noaction", function (event) {
    Swal.fire({
      title: "Not authorized to access",
      text: "You are not authorized to access",
      type: "warning",
      confirmButtonColor: "#348cd4",
    });
    return false;
  });

  $("#districts-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.noaction",
    function (event) {
      Swal.fire({
        title: "Not authorized to access",
        text: "You are not authorized to access",
        type: "warning",
        confirmButtonColor: "#348cd4",
      });
      return false;
    }
  );
  $("#districts-units-datatable tbody").on(
    "click",
    "tr td a.noaction",
    function (event) {
      Swal.fire({
        title: "Not authorized to access",
        text: "You are not authorized to access",
        type: "warning",
        confirmButtonColor: "#348cd4",
      });
      return false;
    }
  );
  $("#subdistricts-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.noaction",
    function (event) {
      Swal.fire({
        title: "Not authorized to access",
        text: "You are not authorized to access",
        type: "warning",
        confirmButtonColor: "#348cd4",
      });
      return false;
    }
  );
  $("#subdistricts-units-datatable tbody").on(
    "click",
    "tr td a.noaction",
    function (event) {
      Swal.fire({
        title: "Not authorized to access",
        text: "You are not authorized to access",
        type: "warning",
        confirmButtonColor: "#348cd4",
      });
      return false;
    }
  );

  $("#villages-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.noaction",
    function (event) {
      Swal.fire({
        title: "Not authorized to access",
        text: "You are not authorized to access",
        type: "warning",
        confirmButtonColor: "#348cd4",
      });
      return false;
    }
  );

  $("#villages-units-datatable tbody").on(
    "click",
    "tr td a.noaction",
    function (event) {
      Swal.fire({
        title: "Not authorized to access",
        text: "You are not authorized to access",
        type: "warning",
        confirmButtonColor: "#348cd4",
      });
      return false;
    }
  );

  $("#wards-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.noaction",
    function (event) {
      Swal.fire({
        title: "Not authorized to access",
        text: "You are not authorized to access",
        type: "warning",
        confirmButtonColor: "#348cd4",
      });
      return false;
    }
  );

  $("#wards-units-datatable tbody").on(
    "click",
    "tr td a.noaction",
    function (event) {
      Swal.fire({
        title: "Not authorized to access",
        text: "You are not authorized to access",
        type: "warning",
        confirmButtonColor: "#348cd4",
      });
      return false;
    }
  );

  $("#units-datatable tbody").on("click", "tr", function () {
    var rowdata = table.row(this).data();

    var ids = "";
    if (rowdata[7] != "") {
      ids = rowdata[6];
    } else {
      ids = rowdata[0];
    }
    //    console.log(ids);
    // return false;
    window.location.href = "districts?ids=" + btoa("321**" + ids + "**123");
  });

  var table1 = $("#districts-units-datatable").DataTable({
    ordering: false,
    scrollX: "100%",
    pageLength: -1,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });

  $("#districts-units-datatable tbody").on(
    "click",
    "tr td:last-child a.dropdown-toggle",
    function () {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#districts-units-datatable tbody").on(
    "click",
    "tr td span",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);
      window.location.href =
        "adddocument?ids=" + btoa(event.target.dataset.todo);
      return false;
    }
  );

  $("#subdistricts-units-datatable tbody").on(
    "click",
    "tr td span",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);
      window.location.href =
        "adddocument?ids=" + btoa(event.target.dataset.todo);
      return false;
    }
  );

  $("#villages-units-datatable tbody").on(
    "click",
    "tr td span",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);
      window.location.href =
        "adddocument?ids=" + btoa(event.target.dataset.todo);
      return false;
    }
  );

  // SWAMI

  $("#users-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnEditnew",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);
      //   console.log(data);

      $("#update_ids").val(data.id);
      $("#stids").val(data.stids);

      $("#STID2021").select2().select2("val", data.stids);

      if (data.adminassigntype == "DT") {
        $("#STID2021").select2().trigger("change");
      }

      // $('#STID2021').val(data.STID2021);
      $("#email").val(data.admin_email);

      $("#con-close-modal").modal("show");
      return false;

      // modified by sahana highlighed user reset password Prevent the click event from bubbling up to the row click event
      event.stopPropagation();
    }
  );

  //modified by sahana to highlighed user reset password
  $("#users-units-datatable tbody").on("click", "tr", function () {
    if ($(this).hasClass("selected")) {
      $(this).removeClass("selected");
    } else {
      $("#users-units-datatable tbody tr.selected").removeClass("selected");
      $(this).addClass("selected");
    }
  });

  //modified by sahana to highlighed user reset password
  $(document).ready(function () {
    $('button[name="btnresetpass"]').on("click", function () {
      var tdId = $(this).data("tdid");
      var tdElement = $("#" + tdId);
      tdElement.toggleClass("selected");
    });
  });

  $("#districts-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnEditnew",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);

      $("#STID2021").select2().trigger("change");

      $("#update_ids").val($(this).data("id"));
      $("#STID2021").select2().select2("val", data.STID2021);
      // $('#STID2021').val(data.STID2021);
      $("#DTName2011").val(data.DTName2011);
      $("#Short_DT2011").val(data.Short_DT2011);
      $("#MDDS_DT2011").val(data.MDDS_DT2011);
      $("#DTName2021").val(data.DTName2021);
      $("#Short_DT2021").val(data.Short_DT2021);
      $("#MDDS_DT2021").val(data.MDDS_DT2021);
      $("#con-close-modal").modal("show");
      return false;
    }
  );

  $("#districts-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.deletetablerow",
    function (event) {
      var data = event.target.id;

      Swal.fire({
        title: "Are you sure?",

        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#348cd4",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
      }).then(function (t) {
        if (t.value) {
          var formData = new FormData();
          formData.append("formname", "deletedt");
          formData.append("deletedids", data);

          $.ajax({
            url: "insert_data.php", // Url to which the request is send
            type: "POST",
            data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (
              data // A function to be called if request succeeds
            ) {
              if (data == "deletedata") {
                // Swal.fire("Deleted!", "Your record has been deleted.", "success")
                Swal.fire({
                  title: "Deleted",
                  text: "Your record has been deleted.",
                  type: "success",
                }).then(function (t) {
                  location.reload();
                });

                return false;
              } else if (data == "error") {
                Command: toastr["error"]("Server Problem try after sometime.");
                return false;
              }
            },
            error: function (jqXHR, exception) {
              if (jqXHR.status === 0) {
                Command: toastr["error"]("Not connect.\n Verify Network.");
              } else if (jqXHR.status == 404) {
                Command: toastr["error"]("Requested page not found. [404]");
              } else if (jqXHR.status == 500) {
                Command: toastr["error"]("Internal Server Error [500].");
              } else if (exception === "timeout") {
                Command: toastr["error"]("Time out error.");
              } else if (exception === "abort") {
                Command: toastr["error"]("Ajax request aborted.");
              } else {
                Command: toastr["error"]("Uncaught Error.\n");
              }
            },
          });
        }
      });
      return false;
    }
  );

  $("#districts-units-datatable tbody").on("click", "tr", function () {
    var rowdata = table1.row(this).data();

    // console.log(rowdata);

    var idsdata = table1.row(this).id();
    var dd = idsdata.split("*****");

    var ids = "";
    if (dd[0] != "") {
      ids = dd[0];
    } else {
      ids = dd[1];
    }
    window.location.href =
      "subdistricts?ids=" +
      btoa("321**" + ids + "**123**" + atob($("#ids").val()));
  });

  var subdistrictstable = $("#subdistricts-units-datatable").DataTable({
    order: [[0, "asc"]],
    pageLength: -1,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });

  $("#subdistricts-units-datatable tbody").on(
    "click",
    "tr td:last-child a.dropdown-toggle",
    function () {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#subdistricts-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnEditnew",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);

      $("#STID2021").select2().trigger("change");
      // $('#DTID2021').select2().trigger('change');
      $("#update_ids").val($(this).data("id"));
      $("#STID2021").select2().select2("val", data.STID2021);
      // $("#DTID2021").select2().select2('val',data.DTID2021);

      $("#SDName2011").val(data.SDName2011);
      $("#Short_DT2011").val(data.Short_SD2011);
      $("#MDDS_SD2011").val(data.MDDS_SD2011);
      $("#SDName2021").val(data.SDName2021);
      $("#Short_SD2021").val(data.Short_SD2021);
      $("#MDDS_SD2021").val(data.MDDS_SD2021);
      $("#con-close-modal").modal("show");

      $("#DTID2021").val("").trigger("change");
      $("#DTID2021").children().remove();
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "insert_data.php",
        data: "formname=getdistlist&STID2021=" + data.STID2021,
      }).done(function (result) {
        $("#DTID2021").append(
          $("<option>", {
            value: "",
            text: "Select Districts Name",
          })
        );
        $(result).each(function () {
          $("#DTID2021").append(
            $("<option>", {
              value: this.DTID2021,
              text: this.DTName2021,
            })
          );
        });
        $("#DTID2021").select2().select2("val", data.DTID2021);
      });

      return false;
    }
  );

  $("#subdistricts-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.deletetablerow",
    function (event) {
      var data = event.target.id;

      Swal.fire({
        title: "Are you sure?",

        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#348cd4",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
      }).then(function (t) {
        if (t.value) {
          var formData = new FormData();
          formData.append("formname", "deletesd");
          formData.append("deletedids", data);

          $.ajax({
            url: "insert_data.php", // Url to which the request is send
            type: "POST",
            data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (
              data // A function to be called if request succeeds
            ) {
              if (data == "deletedata") {
                // Swal.fire("Deleted!", "Your record has been deleted.", "success")
                Swal.fire({
                  title: "Deleted",
                  text: "Your record has been deleted.",
                  type: "success",
                }).then(function (t) {
                  location.reload();
                });

                return false;
              } else if (data == "error") {
                Command: toastr["error"]("Server Problem try after sometime.");
                return false;
              }
            },
            error: function (jqXHR, exception) {
              if (jqXHR.status === 0) {
                Command: toastr["error"]("Not connect.\n Verify Network.");
              } else if (jqXHR.status == 404) {
                Command: toastr["error"]("Requested page not found. [404]");
              } else if (jqXHR.status == 500) {
                Command: toastr["error"]("Internal Server Error [500].");
              } else if (exception === "timeout") {
                Command: toastr["error"]("Time out error.");
              } else if (exception === "abort") {
                Command: toastr["error"]("Ajax request aborted.");
              } else {
                Command: toastr["error"]("Uncaught Error.\n");
              }
            },
          });
        }
      });
      return false;
    }
  );

  $("#subdistricts-units-datatable tbody").on("click", "tr", function () {
    var rowdata = subdistrictstable.row(this).data();

    var idsdata = subdistrictstable.row(this).id();
    var dd = idsdata.split("*****");

    var ids = "";
    if (dd[0] != "") {
      ids = dd[0];
    } else {
      ids = dd[1];
    }
    window.location.href =
      "villages?ids=" + btoa("321**" + ids + "**123**" + atob($("#ids").val()));
  });

  var villagestable = $("#villages-units-datatable").DataTable({
    order: [[3, "asc"]],
    pageLength: -1,
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });

  $("#villages-units-datatable tbody").on(
    "click",
    "tr td:last-child a.dropdown-toggle",
    function () {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#villages-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnEditnew",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);

      var level = $.trim(data.Level2021);

      $("#STID2021").select2().trigger("change");
      // $('#DTID2021').select2().trigger('change');
      $("#update_ids").val($(this).data("id"));
      $("#STID2021").select2().select2("val", data.STID2021);
      // $("#DTID2021").select2().select2('val',data.DTID2021);

      $("#SDName2011").val(data.SDName2011);
      $("#VTName2011").val(data.VTName2011);
      $("#Short_DT2011").val(data.Short_SD2011);
      $("#MDDS_SD2011").val(data.MDDS_SD2011);
      $("#Pop2011").val(data.Pop2011);
      $("#Area2011").val(data.Area2011);
      $("#SDName2021").val(data.SDName2021);
      $("#VTName2021").val(data.VTName2021);
      $("#Short_VT2021").val(data.Short_VT2021);
      $("#MDDS_VT2021").val(data.MDDS_VT2021);
      $("#Level2021").select2().trigger("change");
      $("#Level2021").select2().select2("val", level);
      $("#Pop2021").val(data.Pop2021);
      $("#Area2021").val(data.Area2021);
      $("#Remark1").val(data.Remark1);
      $("#Remark2").val(data.Remark2);
      $("#con-close-modal").modal("show");

      $("#DTID2021").val("").trigger("change");
      $("#DTID2021").children().remove();

      $("#SDID2021").val("").trigger("change");
      $("#SDID2021").children().remove();

      if (level != "VILLAGE") {
        $("#Status2021").prop("disabled", false);

        $.ajax({
          type: "POST",
          dataType: "json",
          url: "insert_data.php",
          data: "formname=getstatus&Level2021=" + level,
        }).done(function (result) {
          $("#Status2021").append(
            $("<option>", {
              value: "",
              text: "Select Status",
            })
          );
          $(result).each(function () {
            $("#Status2021").append(
              $("<option>", {
                value: this.Status2021.trim(),
                text: this.Status2021.trim(),
              })
            );
          });
          $("#Status2021").select2().select2("val", data.Status2021.trim());
        });

        $("#Status2021").prop("required", true);
      }

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "insert_data.php",
        data: "formname=getdistlist&STID2021=" + data.STID2021,
      }).done(function (result) {
        $("#DTID2021").append(
          $("<option>", {
            value: "",
            text: "Select Districts Name",
          })
        );
        $(result).each(function () {
          $("#DTID2021").append(
            $("<option>", {
              value: this.DTID2021,
              text: this.DTName2021,
            })
          );
        });
        $("#DTID2021").select2().select2("val", data.DTID2021);
      });

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "insert_data.php",
        data: "formname=getsubdistlist&DTID2021=" + data.DTID2021,
      }).done(function (result) {
        $("#SDID2021").append(
          $("<option>", {
            value: "",
            text: "Select Sub Districts Name",
          })
        );
        $(result).each(function () {
          $("#SDID2021").append(
            $("<option>", {
              value: this.SDID2021,
              text: this.SDName2021,
            })
          );
        });
        $("#SDID2021").select2().select2("val", data.SDID2021);
      });

      return false;
    }
  );

  $("#villages-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.deletetablerow",
    function (event) {
      var data = event.target.id;

      Swal.fire({
        title: "Are you sure?",

        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#348cd4",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
      }).then(function (t) {
        if (t.value) {
          var formData = new FormData();
          formData.append("formname", "deletevt");
          formData.append("deletedids", data);

          $.ajax({
            url: "insert_data.php", // Url to which the request is send
            type: "POST",
            data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (
              data // A function to be called if request succeeds
            ) {
              if (data == "deletedata") {
                // Swal.fire("Deleted!", "Your record has been deleted.", "success")
                Swal.fire({
                  title: "Deleted",
                  text: "Your record has been deleted.",
                  type: "success",
                }).then(function (t) {
                  location.reload();
                });

                return false;
              } else if (data == "error") {
                Command: toastr["error"]("Server Problem try after sometime.");
                return false;
              }
            },
            error: function (jqXHR, exception) {
              if (jqXHR.status === 0) {
                Command: toastr["error"]("Not connect.\n Verify Network.");
              } else if (jqXHR.status == 404) {
                Command: toastr["error"]("Requested page not found. [404]");
              } else if (jqXHR.status == 500) {
                Command: toastr["error"]("Internal Server Error [500].");
              } else if (exception === "timeout") {
                Command: toastr["error"]("Time out error.");
              } else if (exception === "abort") {
                Command: toastr["error"]("Ajax request aborted.");
              } else {
                Command: toastr["error"]("Uncaught Error.\n");
              }
            },
          });
        }
      });
      return false;
    }
  );

  $("#villages-units-datatable tbody").on("click", "tr", function () {
    var rowdata = villagestable.row(this).data();
    //     console.log(rowdata);
    // return false;
    var ids = "";
    if (rowdata[7] != "") {
      ids = rowdata[6];
    } else {
      ids = rowdata[0];
    }

    if (rowdata[8] == "TOWN") {
      window.location.href =
        "wards?ids=" + btoa("321**" + ids + "**123**" + atob($("#ids").val()));
    }
  });

  $("#documents-units-datatable tbody").on(
    "click",
    "tr td:last-child a.dropdown-toggle",
    function () {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#documents-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.documentlinklink",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);
      // console.log(data);
      $("#con-close-modal-linkdc").modal("show");
      $("#docidsdata").val(data.docids);
      // run callbacks
      $("#linkSTID2021").multiSelect({
        selectableHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        selectionHeader:
          "<input type='text' class='form-control search-input' autocomplete='off' placeholder='search...'>",
        afterInit: function (t) {
          var e = this,
            n = e.$selectableUl.prev(),
            a = e.$selectionUl.prev(),
            i =
              "#" +
              e.$container.attr("id") +
              " .ms-elem-selectable:not(.ms-selected)",
            s =
              "#" + e.$container.attr("id") + " .ms-elem-selection.ms-selected";
          (e.qs1 = n.quicksearch(i).on("keydown", function (t) {
            if (40 === t.which) return e.$selectableUl.focus(), !1;
          })),
            (e.qs2 = a.quicksearch(s).on("keydown", function (t) {
              if (40 == t.which) return e.$selectionUl.focus(), !1;
            }));
        },
        afterSelect: function (values) {
          this.qs1.cache(), this.qs2.cache();
        },
        afterDeselect: function () {
          this.qs1.cache(), this.qs2.cache();
        },
      });

      return false;
    }
  );

  $("#documents-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnEditnew",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);
      console.log(data);
      var dd = data.docdate.split("-");
      var datefinal = dd[2] + "-" + dd[1] + "-" + dd[0];
      var datefinal1 = dd[2] + "/" + dd[1] + "/" + dd[0];
      $("#docdate").datepicker("setDate", datefinal1);

      $("#docdate").datepicker().val(datefinal).trigger("change");

      $("#docstid").select2().trigger("change");
      $("#doctype").select2().trigger("change");
      $("#update_ids").val($(this).data("id"));
      $("#docstid").select2().select2("val", data.docstid);
      $("#doctype").select2().select2("val", data.doctype);
      $("#docstid").val(data.docstid);
      $("#doctype").val(data.doctype);
      // $('#docdate').val(datefinal);
      $("#doctitle").val(data.doctitle);
      $("#docdescription").val(data.docdescription);
      $("#upploaded_doc").attr(
        "href",
        "Alldocuments/" + data.docstid + "/" + data.docnotification + ""
      );

      // $('#Short_SD2021').val(data.Short_SD2021);
      // $('#MDDS_SD2021').val(data.MDDS_SD2021);
      $("#con-close-modal").modal("show");

      $("#DTID2021").val("").trigger("change");
      $("#DTID2021").children().remove();
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "insert_data.php",
        data: "formname=getdistlist&STID=" + data.docstid,
      }).done(function (result) {
        $("#DTID2021").append(
          $("<option>", {
            value: "",
            text: "Select Districts Name",
          })
        );
        $(result).each(function () {
          $("#DTID2021").append(
            $("<option>", {
              value: this.DTID2021,
              text: this.DTName2021,
            })
          );
        });
        $("#DTID2021").select2().select2("val", data.DTID2021);
      });

      // modified by sahana highlighed document Prevent the click event from bubbling up to the row click event
      event.stopPropagation();

      return false;
    }
  );

  //modified by sahana to highlighed user reset password
  $("#documents-units-datatable tbody").on("click", "tr", function () {
    if ($(this).hasClass("selected")) {
      $(this).removeClass("selected");
    } else {
      $("#documents-units-datatable tbody tr.selected").removeClass("selected");
      $(this).addClass("selected");
    }
  });

  //modified by sahana to highlighed user reset password
  $(document).ready(function () {
    $('button[name="reuse"]').on("click", function () {
      var tdId = $(this).data("tdid");
      var tdElement = $("#" + tdId);
      tdElement.toggleClass("selected");
    });
  });

  $("#documents-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.deletetablerow",
    function (event) {
      var data = event.target.id;

      Swal.fire({
        title: "Are you sure?",

        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#348cd4",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
      }).then(function (t) {
        if (t.value) {
          var formData = new FormData();
          formData.append("formname", "deletedoc");
          formData.append("deletedids", data);

          $.ajax({
            url: "insert_data.php", // Url to which the request is send
            type: "POST",
            data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (
              data // A function to be called if request succeeds
            ) {
              if (data == "deletedata") {
                // Swal.fire("Deleted!", "Your record has been deleted.", "success")
                Swal.fire({
                  title: "Deleted",
                  text: "Your record has been deleted.",
                  type: "success",
                }).then(function (t) {
                  location.reload();
                });

                return false;
              } else if (data == "error") {
                Command: toastr["error"]("Server Problem try after sometime.");
                return false;
              }
            },
            error: function (jqXHR, exception) {
              if (jqXHR.status === 0) {
                Command: toastr["error"]("Not connect.\n Verify Network.");
              } else if (jqXHR.status == 404) {
                Command: toastr["error"]("Requested page not found. [404]");
              } else if (jqXHR.status == 500) {
                Command: toastr["error"]("Internal Server Error [500].");
              } else if (exception === "timeout") {
                Command: toastr["error"]("Time out error.");
              } else if (exception === "abort") {
                Command: toastr["error"]("Ajax request aborted.");
              } else {
                Command: toastr["error"]("Uncaught Error.\n");
              }
            },
          });
        }
      });
      return false;
    }
  );

  var wardstable = $("#wards-units-datatable").DataTable({
    order: [[3, "asc"]],
    lengthMenu: [
      [10, 25, 50, 100, -1],
      [10, 25, 50, 100, "All"],
    ],
  });

  $("#wards-units-datatable tbody").on(
    "click",
    "tr td:last-child a.dropdown-toggle",
    function () {
      $("a.dropdown-toggle").dropdown();
      return false;
    }
  );

  $("#wards-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.btnEditnew",
    function (event) {
      var data = JSON.parse(event.target.dataset.todo);

      $("#STID2021").select2().trigger("change");
      // $('#DTID2021').select2().trigger('change');
      $("#update_ids").val($(this).data("id"));
      $("#STID2021").select2().select2("val", data.STID2021);
      // $("#DTID2021").select2().select2('val',data.DTID2021);

      $("#SDName2011").val(data.SDName2011);
      $("#WDName2011").val(data.WDName2011);
      $("#Short_WD2011").val(data.Short_WD2011);
      $("#MDDS_WD2011").val(data.MDDS_WD2011);
      $("#Pop2011").val(data.Pop2011);
      $("#Area2011").val(data.Area2011);
      $("#WDName2021").val(data.WDName2021);
      // $('#VTName2021').val(data.VTName2021);
      $("#Short_WD2021").val(data.Short_WD2021);
      $("#MDDS_WD2021").val(data.MDDS_WD2021);
      $("#Pop2021").val(data.Pop2021);
      $("#Area2021").val(data.Area2021);
      $("#Remark1").val(data.Remark1);
      $("#Remark2").val(data.Remark2);
      $("#con-close-modal").modal("show");

      $("#DTID2021").val("").trigger("change");
      $("#DTID2021").children().remove();

      $("#SDID2021").val("").trigger("change");
      $("#SDID2021").children().remove();

      $("#VTID2021").val("").trigger("change");
      $("#VTID2021").children().remove();

      $("#Level2021").select2().trigger("change");
      $("#Level2021").select2().select2("val", data.Level2021.trim());
      // $("#Level2021").children().remove();

      $("#Status2021").val("").trigger("change");
      $("#Status2021").children().remove();

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "insert_data.php",
        data: "formname=getdistlist&STID2021=" + data.STID2021,
      }).done(function (result) {
        $("#DTID2021").append(
          $("<option>", {
            value: "",
            text: "Select Districts Name",
          })
        );
        $(result).each(function () {
          $("#DTID2021").append(
            $("<option>", {
              value: this.DTID2021,
              text: this.DTName2021,
            })
          );
        });
        $("#DTID2021").select2().select2("val", data.DTID2021);
      });

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "insert_data.php",
        data: "formname=getsubdistlist&DTID2021=" + data.DTID2021,
      }).done(function (result) {
        $("#SDID2021").append(
          $("<option>", {
            value: "",
            text: "Select Sub Districts Name",
          })
        );
        $(result).each(function () {
          $("#SDID2021").append(
            $("<option>", {
              value: this.SDID2021,
              text: this.SDName2021,
            })
          );
        });
        $("#SDID2021").select2().select2("val", data.SDID2021);
      });

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "insert_data.php",
        data: "formname=getvtlist&SDID2021=" + data.SDID2021,
      }).done(function (result) {
        $("#VTID2021").append(
          $("<option>", {
            value: "",
            text: "Select Village / Town",
          })
        );
        $(result).each(function () {
          $("#VTID2021").append(
            $("<option>", {
              value: this.VTID2021,
              text: this.VTName2021,
            })
          );
        });
        $("#VTID2021").select2().select2("val", data.VTID2021);
      });

      $.ajax({
        type: "POST",
        dataType: "json",
        url: "insert_data.php",
        data: "formname=getstatuswd&Level2021=" + data.Level2021.trim(),
      }).done(function (result) {
        $("#Status2021").append(
          $("<option>", {
            value: "",
            text: "Select Status",
          })
        );
        $(result).each(function () {
          $("#Status2021").append(
            $("<option>", {
              value: this.Status2021.trim(),
              text: this.Status2021.trim(),
            })
          );
        });
        $("#Status2021").select2().select2("val", data.Status2021.trim());
      });

      return false;
    }
  );

  $("#wards-units-datatable tbody").on(
    "click",
    "tr td .dropdown ul.dropdown-menu a.deletetablerow",
    function (event) {
      var data = event.target.id;

      Swal.fire({
        title: "Are you sure?",

        type: "warning",
        showCancelButton: !0,
        confirmButtonColor: "#348cd4",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
      }).then(function (t) {
        if (t.value) {
          var formData = new FormData();
          formData.append("formname", "deletewd");
          formData.append("deletedids", data);

          $.ajax({
            url: "insert_data.php", // Url to which the request is send
            type: "POST",
            data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
            contentType: false, // The content type used when sending data to the server.
            cache: false, // To unable request pages to be cached
            processData: false, // To send DOMDocument or non processed data file it is set to false
            success: function (
              data // A function to be called if request succeeds
            ) {
              if (data == "deletedata") {
                // Swal.fire("Deleted!", "Your record has been deleted.", "success")
                Swal.fire({
                  title: "Deleted",
                  text: "Your record has been deleted.",
                  type: "success",
                }).then(function (t) {
                  location.reload();
                });

                return false;
              } else if (data == "error") {
                Command: toastr["error"]("Server Problem try after sometime.");
                return false;
              }
            },
            error: function (jqXHR, exception) {
              if (jqXHR.status === 0) {
                Command: toastr["error"]("Not connect.\n Verify Network.");
              } else if (jqXHR.status == 404) {
                Command: toastr["error"]("Requested page not found. [404]");
              } else if (jqXHR.status == 500) {
                Command: toastr["error"]("Internal Server Error [500].");
              } else if (exception === "timeout") {
                Command: toastr["error"]("Time out error.");
              } else if (exception === "abort") {
                Command: toastr["error"]("Ajax request aborted.");
              } else {
                Command: toastr["error"]("Uncaught Error.\n");
              }
            },
          });
        }
      });
      return false;
    }
  );

  // $('#villages-units-datatable tbody').on( 'click', 'tr', function () {
  //   var rowdata =  villagestable.row( this ).data();
  //   //   console.log(rowdata.DTID2011);
  // window.location.href='wards?ids='+btoa('321**'+rowdata.SDID2011+'**123');
  // // atob(encodedStringAtoB);
  // } );
});
