function droppableAlmacen() {
  $("#almacen").droppable({
    drop: function (ev, ui) {
      let mesa = ui.draggable;
      mesa.attr("style", "");
      $(this).append(mesa);
    },
  });
}

