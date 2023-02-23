function droppableSala() {
  var topSala = $("#sala").offset().top;
  var leftSala = $("#sala").offset().left;
  $("#sala").droppable({
    drop: function (ev, ui) {
      var mesa = ui.draggable;
      var left = parseInt(ui.offset.left - leftSala);
      var top = parseInt(ui.offset.top - topSala);
      let width = mesa.width();
      let height = mesa.height();

      let pos1 = [left, left + width, top, top + height];

      let mesaYa = $("#sala .mesa");
      let valido = true;
      $.each(mesaYa, function (key, mesa2) {
        if (mesa2.id != mesa.get(0).id) {
          let posX = parseInt(mesa2.offsetLeft - leftSala);
          let posY = parseInt(mesa2.offsetTop - topSala);
          let anchura = mesa2.offsetWidth;
          let altura = mesa2.offsetHeight;
          let pos2 = [posX, posX + anchura, posY, posY + altura];

          if (
            ((pos1[0] > pos2[0] && pos1[0] < pos2[1]) ||
              (pos1[1] > pos2[0] && pos1[1] < pos2[1]) ||
              (pos1[0] <= pos2[0] && pos1[1] >= pos2[1])) &&
            ((pos1[2] > pos2[2] && pos1[2] < pos2[3]) ||
              (pos1[3] > pos2[2] && pos1[3] < pos2[3]) ||
              (pos1[2] <= pos2[2] && pos1[3] >= pos2[3]))
          ) {
            alert("Choca!!");
            valido = false;
          }
        }
      });

      if (valido) {
        var position = {
          x: ui['position'].left-leftSala,
          y: ui['position'].top-topSala
        };
        $.ajax({
          method: "PUT",
          url: "/api/mesa/update/"+mesa[0].id,
          dataType: "json",
          async: false,
          data: JSON.stringify(position)
        }).done(function (data) {
          location.reload()
        });
      }
    },
  });
}
