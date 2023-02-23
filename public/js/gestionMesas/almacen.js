function droppableAlmacen() {
  $("#almacen").droppable({
    drop: function (ev, ui) {
      let mesa = ui.draggable;
      /* mesa.css({position: "", top: 0, left: 0})
      $(this).append(mesa); */
      var position = {
        x: -1,
        y: -1
      };
      $.ajax({
        method: "PUT",
        url: "/api/mesa/update/"+mesa[0].id,
        dataType: "json",
        async: false,
        data: JSON.stringify(position)
      }).done(function () {
        location.reload();
      });
    },
  });
}

