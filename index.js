function filterDateTime() {
  // Get input value
  var dateTimeInput = $("#searchClockTime");
  var dateTimeFilter = dateTimeInput.val();
  // Get table rows
  var rows = $("tr");
  // Loop through rows and hide those that don't match the search query
  rows.each(function() {
      var id = $(this).attr("id");
      if (id && id.startsWith("row_")) {
          var datetime = $(this).find(".datetime-column").text();
          if (datetime.includes(dateTimeFilter)) {
              $(this).removeClass("d-none");
          } else {
              $(this).addClass("d-none");
          }
      }
  });
}

$(document).ready(function() {
  const $inputAction = $('#inputAction');
  $inputAction.on('change', filterClockAction);

  function filterClockAction() {
    const $table = $('#clockTable');
    const $rows = $table.find('tr');
    const selectedAction = $inputAction.val();

    $rows.each(function(index) {
      if (index !== 0) {
        const $row = $(this);
        const $actionCell = $row.find('td').eq(1);
        const actionText = $actionCell.text().toLowerCase();

        if (selectedAction === '' || selectedAction === actionText) {
          $row.show();
        } else {
          $row.hide();
        }
      }
    });
  }

  filterClockAction();
});

function filterIDTime() {
  // Get input value
  var userInput = $("#searchUser");
  var userFilter = userInput.val().toUpperCase();
  var allDateTimeInput = $("#searchAllClockTime");
  var allDateTimeFilter = allDateTimeInput.val();
  // Get table rows
  var rows = $("tr");
  // Loop through rows and hide those that don't match the search query
  rows.each(function() {
    var id = $(this).attr("id");
    if (id && id.startsWith("allRow_")) {
      id = id.substr(4);
      var allDatetime = $(this).find(".allDatetime-Column").text();
      if (id.toUpperCase().indexOf(userFilter) > -1 && allDatetime.includes(allDateTimeFilter)) {
        $(this).removeClass("d-none");
      } else {
        $(this).addClass("d-none");
      }
    }
  });
}

$(document).ready(function() {
  const $inputAllAction = $('#inputAllAction');
  $inputAllAction.on('change', filterAllClockAction);

  function filterAllClockAction() {
    const $allTable = $('#allClockTable');
    const $allRows = $allTable.find('tr');
    const selectedAllAction = $inputAllAction.val();

    $allRows.each(function(index) {
      if (index !== 0) {
        const $allRow = $(this);
        const $allActionCell = $allRow.find('td').eq(1);
        const allActionText = $allActionCell.text().toLowerCase();

        if (selectedAllAction === '' || selectedAllAction === allActionText) {
          $allRow.show();
        } else {
          $allRow.hide();
        }
      }
    });
  }

  filterAllClockAction();
});