function addCmdToTable(_cmd) {
  if (!isset(_cmd)) {
    var _cmd = { configuration: {} };
  }
  if (!isset(_cmd.configuration)) {
    _cmd.configuration = {};
  }

  if (init(_cmd.type) == "info") {
    
    var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '" >';
    tr += "<td>";
    tr += '<span class="cmdAttr" data-l1key="id"></span>';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" placeholder="{{Nom}}"></td>';
    tr += "</td>";
    tr += "<td>";
    tr += '<a class="cmdAction btn btn-default btn-sm" data-l1key="chooseIcon"><i class="fa fa-flag"></i> Icone</a>';
    tr += '<span class="cmdAttr cmdAction" data-l1key="display" data-l2key="icon" style="margin-left : 10px;"></span>';
    tr += "</td>";
    tr += '<td class="expertModeVisible">';
    tr += '<input class="cmdAttr form-control type input-sm" data-l1key="type" value="action" disabled style="margin-bottom : 5px;" />';
    tr += '<span class="cmdAttr subType" subType="' + init(_cmd.subType) + '"></span>';
    tr += '<input type=hidden class="cmdAttr form-control input-sm" data-l1key="unite" value="">';
    tr += "</td>";
    tr += "<td>";
    tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="isHistorized"/> {{Historiser}}<br/></span>';
    tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/> {{Afficher}}<br/></span>';
    tr += "</td>";
    //		tr += '<td><i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>';
    tr += "<td>";
    if (is_numeric(_cmd.id)) {
      tr += '<a class="btn btn-default btn-xs cmdAction expertModeVisible" data-action="configure"><i class="fa fa-cogs"></i></a> ';
    }
    tr += "</td>";
    table_cmd = "#table_cmd";
    if ($(table_cmd + "_" + _cmd.eqType).length) {
      table_cmd += "_" + _cmd.eqType;
    }
    $(table_cmd + " tbody").append(tr);
    $(table_cmd + " tbody tr:last").setValues(_cmd, ".cmdAttr");
  }
  if (init(_cmd.type) == "action") {
    var tr = '<tr class="cmd" data-cmd_id="' + init(_cmd.id) + '">';
    tr += "<td>";
    tr += '<span class="cmdAttr" data-l1key="id"></span>';
    tr += '<input class="cmdAttr form-control input-sm" data-l1key="name" placeholder="{{Nom}}">';
    tr += "</td>";
    tr += "<td>";
    tr += '<a class="cmdAction btn btn-default btn-sm" data-l1key="chooseIcon"><i class="fa fa-flag"></i> Icone</a>';
    tr += '<span class="cmdAttr cmdAction" data-l1key="display" data-l2key="icon" style="margin-left : 10px;"></span>';
    tr += "</td>";
    tr += "<td>";
    tr += '<input class="cmdAttr form-control type input-sm" data-l1key="type" value="action" disabled style="margin-bottom : 5px;" />';
    tr += '<span class="subType" subType="' + init(_cmd.subType) + '"></span>';
    tr += "</td>";
    tr += "<td>";
    tr += '<span><input type="checkbox" class="cmdAttr" data-l1key="isVisible" checked/> {{Afficher}}<br/></span>';
    tr += "</td>";
    tr += "<td>";
    if (is_numeric(_cmd.id)) {
      tr += '<a class="btn btn-default btn-xs cmdAction expertModeVisible" data-action="configure"><i class="fa fa-cogs"></i></a> ';
      tr += '<a class="btn btn-default btn-xs cmdAction" data-action="test"><i class="fa fa-rss"></i> {{Tester}}</a>';
    }
    //		tr += '<td><i class="fa fa-minus-circle pull-right cmdAction cursor" data-action="remove"></i></td>';
    tr += "</tr>";

    table_cmd = "#table_cmd";
    if ($(table_cmd + "_" + _cmd.eqType).length) {
      table_cmd += "_" + _cmd.eqType;
    }
    $(table_cmd + " tbody").append(tr);
    $(table_cmd + " tbody tr:last").setValues(_cmd, ".cmdAttr");
    var tr = $(table_cmd + " tbody tr:last");
    jeedom.eqLogic.builSelectCmd({
      id: $(".li_eqLogic.active").attr("data-eqLogic_id"),
      filter: { type: "info" },
      error: function (error) {
        $("#div_alert").showAlert({ message: error.message, level: "danger" });
      },
      success: function (result) {
        tr.find(".cmdAttr[data-l1key=value]").append(result);
        tr.setValues(_cmd, ".cmdAttr");
      },
    });
  }
}

$("#table_cmd").sortable({
  axis: "y",
  cursor: "move",
  items: ".cmd",
  placeholder: "ui-state-highlight",
  tolerance: "intersect",
  forcePlaceholderSize: true,
});

$(function () {
  $("input[type=radio][name=mode]").change(function () {
    if ($(this).val() == "Icmp") {
      $("#port").hide();
      $("#ip").show();
      $("#mac").hide();
      $("#interface").hide();
    } else if ($(this).val() == "Arp") {
      $("#port").hide();
      $("#ip").hide();
      $("#mac").show();
      $("#interface").show();
    } else {
      $("#ip").show();
      $("#mac").hide();
      $("#port").show();
      $("#interface").hide();
    }
  });
});

function saveEqLogic(_eqLogic) {
  _eqLogic.configuration.mode = $("input[type=radio][name=mode]:checked").val();
  return _eqLogic;
}

function printEqLogic(_eqLogic) {
  if (isset(_eqLogic.configuration) && isset(_eqLogic.configuration.mode) && _eqLogic.configuration.mode != "") {
    $("input[type=radio][name=mode][value=" + _eqLogic.configuration.mode + "]").prop("checked", true);
    if (_eqLogic.configuration.mode == "Icmp") {
      $("#port").hide();
      $("#ip").show();
      $("#mac").hide();
      $("#interface").hide();
    } else if (_eqLogic.configuration.mode == "Arp") {
      $("#port").hide();
      $("#ip").hide();
      $("#mac").show();
      $("#interface").show();
    } else {
      $("#ip").show();
      $("#mac").hide();
      $("#port").show();
      $("#interface").hide();
    }
  } else {
    $("input[type=radio][name=mode][value=Tcp]").prop("checked", true);
    $("#ip").show();
    $("#mac").hide();
    $("#port").show();
    $("#interface").hide();
  }
}

$("#bt_DetectBin").on("click", function () {
  $.ajax({
    // fonction permettant de faire de l'ajax
    type: "POST", // methode de transmission des données au fichier php
    url: "plugins/ping/core/ajax/ping.ajax.php", // url du fichier php
    data: {
      action: "DetectBin",
    },
    dataType: "json",
    error: function (request, status, error) {
      handleAjaxError(request, status, $("#div_DetectBin"));
    },
    success: function (data) {
      // si l'appel a bien fonctionné
      if (data.state != "ok") {
        $("#div_DetectBin").showAlert({
          message: data.result,
          level: "danger",
        });
      } else {
        $("#div_DetectBin").showAlert({
          message: data.result,
          level: "success",
        });
      }
      jeedom.config.load({
        configuration: $("#config").getValues(".configKey")[0],
        plugin: "ping",
        error: function (error) {
          $("#div_alert").showAlert({
            message: error.message,
            level: "danger",
          });
        },
        success: function (data) {
          $("#config").setValues(data, ".configKey");
          modifyWithoutSave = false;
          $("#div_alert").showAlert({
            message: "{{Sauvegarde réussie}}",
            level: "success",
          });
        },
      });
    },
  });
});
