/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

var App = {
  addTab: function (title, target) {
    if ($("#app_tab").tabs("exists", title)) {
      $("#app_tab").tabs("select", title);
    } else {
      $("#app_tab").tabs("add", {
        title: title,
        href: base_url + target,
        closable: true,
        fit: true,
        closed: true,
        cache: true,
        tabHeight: 20,
      });
    }
    $(window).resize();
  },
  serializeObject: function ($el) {
    var o = {};
    var a = $($el).serializeArray();
    $.each(a, function () {
      if (o[this.name]) {
        if (!o[this.name].push) {
          o[this.name] = [o[this.name]];
        }
        o[this.name].push(this.value || "");
      } else {
        o[this.name] = this.value || "";
      }
    });
    console.log(o);
    return o;
  },
  formatPrice: function (num, row) {
    //        console.log('num: ', num);
    if (num !== null && num !== undefined) {
      var x = "" + num;
      var parts = x.toString().split(".");
      return (
        parts[0].replace(/\B(?=(\d{3})+(?=$))/g, ",") +
        (parts[1] ? "." + parts[1] : "")
      );
    } else {
      return "";
    }
  },
  formatDateDDMMYYYY: function (_date, row) {
    if (_date !== null) {
      var ss = _date.split("-");
      var y = parseInt(ss[0], 10);
      var m = parseInt(ss[1], 10);
      var d = parseInt(ss[2], 10);
      return (d < 10 ? "0" + d : d) + "-" + (m < 10 ? "0" + m : m) + "-" + y;
    } else {
      return "";
    }
  },
  formatDateTimeDDMMYYYYHHII: function (_date, row) {
    if (_date !== null) {
      var dt = _date.split(" ");
      var ss = dt[0].split("-");
      var y = parseInt(ss[0], 10);
      var m = parseInt(ss[1], 10);
      var d = parseInt(ss[2], 10);
      return (
        (d < 10 ? "0" + d : d) +
        "-" +
        (m < 10 ? "0" + m : m) +
        "-" +
        y +
        " " +
        dt[1]
      );
    } else {
      return "";
    }
  },
  dateFormatter: function (date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    return y + "-" + (m < 10 ? "0" + m : m) + "-" + (d < 10 ? "0" + d : d);
  },
  dateParser: function (s) {
    if (!s) return new Date();
    var ss = s.split("-");
    var y = parseInt(ss[0], 10);
    var m = parseInt(ss[1], 10);
    var d = parseInt(ss[2], 10);
    if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
      return new Date(y, m - 1, d);
    } else {
      return new Date();
    }
  },
  dateTimeFormatter: function (date) {
    var y = date.getFullYear();
    var m = date.getMonth() + 1;
    var d = date.getDate();
    var h = date.getHours();
    var i = date.getMinutes();
    //return m+'/'+d+'/'+y+' '+h+':'+mm;
    return (
      y +
      "-" +
      (m < 10 ? "0" + m : m) +
      "-" +
      (d < 10 ? "0" + d : d) +
      " " +
      h +
      ":" +
      (i < 10 ? "0" + i : i)
    );
  },
  dateTimeParser: function (s) {
    if (!s) return new Date();

    var dt = s.split(" ");
    var ss = dt[0].split("-");
    var y = parseInt(ss[0], 10);
    var m = parseInt(ss[1], 10);
    var d = parseInt(ss[2], 10);

    var t = dt[1].split(":");
    var h = parseInt(t[0]);
    var i = parseInt(t[1]);

    if (!isNaN(y) && !isNaN(m) && !isNaN(d) && !isNaN(h) && !isNaN(i)) {
      return new Date(y, m - 1, d, h, i);
    } else {
      return new Date();
    }
  },
  dateMdyToYmd: function (dateString, delimitterSource, delimitterTarget) {
    var ss = dateString.split(delimitterSource);
    return ss[2] + delimitterTarget + ss[0] + delimitterTarget + ss[1];
  },
  itemComboboxFormat: function (record) {
    return (
      '<span style="font-weight:bold;">Item Code: </span> <span">' +
      record.item_code +
      "</span><br/>" +
      '<span style="font-weight:bold;">Item Description: </span> <span">' +
      record.item_description +
      "</span><br/>" +
      '<span style="font-weight:bold;">Type: </span> <span">' +
      record.type +
      "</span><br/>" +
      '<span style="font-weight:bold;">Serial Number: </span> <span">' +
      record.serial_number +
      "</span><br/>"
    );
  },
  customerComboboxFormat: function (record) {
    return (
      '<span style="font-weight:bold;">' +
      record.code +
      "</span><br/>" +
      '<span">' +
      record.name +
      "</span><br/>"
    );
  },
  openTarget: function (method, url, data, target) {
    var form = document.createElement("form");
    form.action = url;
    form.method = method;
    form.target = target || "_self";
    if (data) {
      for (var key in data) {
        var input = document.createElement("textarea");
        input.name = key;
        input.value =
          typeof data[key] === "object" ? JSON.stringify(data[key]) : data[key];
        form.appendChild(input);
      }
    }
    form.style.display = "none";
    document.body.appendChild(form);
    form.submit();
  },
  createContainer: function ($elId) {
    if ($("#" + $elId).length === 0) {
      $("body").append("<div id='" + $elId + "'></div>");
    }
  },
  changePassword: function () {
    if ($("#change_password_dialog")) {
      $("body").append("<div id='change_password_dialog'></div>");
    }
    $("#change_password_dialog").dialog({
      title: "CHANGE PASSWORD",
      width: 400,
      height: "auto",
      href: base_url + "Home/changePassword",
      modal: true,
      resizable: true,
      top: 60,
      buttons: [
        {
          text: "Save",
          iconCls: "icon-save",
          handler: function () {
            $("#change_password_form").form("submit", {
              url: base_url + "configuration/User/changePassword",
              onSubmit: function () {
                return $(this).form("validate");
              },
              success: function (content) {
                //            alert(content);
                var result = eval("(" + content + ")");
                if (result.success) {
                  $("#change_password_dialog").dialog("close");
                  $.messager.show({
                    title: "Change Password",
                    msg: "Change Password Success",
                    timeout: 5000,
                    showType: "slide",
                  });
                } else {
                  $.messager.alert("Error", result.msg, "error");
                }
              },
            });
          },
        },
        {
          text: "Close",
          iconCls: "icon-remove",
          handler: function () {
            $("#change_password_dialog").dialog("close");
          },
        },
      ],
      onLoad: function () {
        $(this).dialog("center");
      },
    });
  },
  openProgressBar: function () {
    $.messager.progress({
      msg: "Connecting to server",
      interval: 0,
    });
    var bar = $.messager.progress("bar");
    bar.progressbar({
      text: "Please waiting...",
    });
  },
  closeProgressBar: function () {
    $.messager.progress("close");
  },
  showConnectionError: function () {
    $.messager.alert(
      "Connection Error",
      "Cannot connect to server.<br/>Please check your network connection or maybe server status is down.",
      "error"
    );
  },
  openLoginDialog: function () {
    $("#login_dialog").dialog("open").dialog("setTitle", " Login").dialog({
      resizable: false,
    });
    $("#login_form").form("clear");
  },
  doLogin: function () {
    $("#login_form").form("submit", {
      url: base_url + "Home/login",
      onSubmit: function (param) {
        if ($(this).form("validate")) {
          param.type = "ajax";
          App.openProgressBar();
        } else {
          return false;
        }
      },
      success: function (content) {
        if (content === "") {
          App.closeProgressBar();
          App.showConnectionError();
        } else {
          App.closeProgressBar();
          var result = eval("(" + content + ")");
          if (result.success) {
            $("#login_dialog").dialog("close");
            login_dialog_open = false;
            startCheckSession();
          } else {
            $.messager.alert("Error", result.msg, "error");
          }
        }
      },
    });
  },
  treeChildFormat: function (rows) {
    var nodes = [];
    // get the top level nodes
    for (var i = 0; i < rows.length; i++) {
      var row = rows[i];
      if (!row._parentId) {
        nodes.push(row);
        rows.splice(i, 1);
        i--;
      }
    }
    var toDo = [];
    for (var i = 0; i < nodes.length; i++) {
      toDo.push(nodes[i]);
    }
    while (toDo.length) {
      var node = toDo.shift(); // the parent node
      // get the children nodes
      for (var i = 0; i < rows.length; i++) {
        var row = rows[i];
        if (row._parentId === node.id) {
          if (node.children) {
            node.children.push(row);
          } else {
            node.children = [row];
          }
          toDo.push(row);
          rows.splice(i, 1);
          i--;
        }
      }
    }
    return nodes;
  },
};
function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}
function format_nomor_anggota(val, row) {
  return (
    '<span style="color:red;">' +
    row.no_anggota +
    " " +
    row.kode_perusahaan +
    "</span>"
  );
}
function formatter1(date) {
  if (!date) {
    return "";
  }
  return $.fn.datebox.defaults.formatter.call(this, date);
}
function parser1(s) {
  if (!s) {
    return null;
  }
  return $.fn.datebox.defaults.parser.call(this, s);
}
function formatter2(date) {
  if (!date) {
    return "";
  }
  var y = date.getFullYear();
  var m = date.getMonth() + 1;
  return y + "-" + (m < 10 ? "0" + m : m);
}
function parser2(s) {
  if (!s) {
    return null;
  }
  var ss = s.split("-");
  var y = parseInt(ss[0], 10);
  var m = parseInt(ss[1], 10);
  if (!isNaN(y) && !isNaN(m)) {
    return new Date(y, m - 1, 1);
  } else {
    return new Date();
  }
}
function myformatter(date) {
  var y = date.getFullYear();
  var m = date.getMonth() + 1;
  var d = date.getDate();
  return y + "-" + (m < 10 ? "0" + m : m) + "-" + (d < 10 ? "0" + d : d);
}
function myparser(s) {
  if (!s) return new Date();
  var ss = s.split("-");
  var y = parseInt(ss[0], 10);
  var m = parseInt(ss[1], 10);
  var d = parseInt(ss[2], 10);
  if (!isNaN(y) && !isNaN(m) && !isNaN(d)) {
    return new Date(y, m - 1, d);
  } else {
    return new Date();
  }
}

