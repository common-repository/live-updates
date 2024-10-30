function update() {
    $.get("/wp-content/plugins/live-updates/messages.php", function(data) {
    $("#messages").html(data);
    window.setTimeout(update, 10000);
  });
  
}

update();