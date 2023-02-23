function obtenerMesasReservas() {
  $.ajax({
    method: "GET",
    url: "/api/mesa/getAll",
    dataType: "json",
    async: false,
  }).done(function (data) {
    $.each(data, function (key, mesa) {
      newMesaReserva(
        mesa.object.id,
        mesa.object.anchura,
        mesa.object.altura,
        mesa.object.x,
        mesa.object.y
      );
    });
  });
}

function newMesaReserva(id, anchura, altura, x, y) {
  var topSala = $("#salaReservas").offset().top;
  var leftSala = $("#salaReservas").offset().left;
  const newMesa = new Mesa(id, anchura, altura, x, y);

  if (
    !(
      (newMesa.x == null && newMesa.y == null) ||
      (newMesa.x == -1 && newMesa.y == -1)
    )
  ) {
    $("<div>")
      .addClass("mesa")
      .attr("id", id)
      .css("width", newMesa.anchura)
      .css("height", newMesa.altura)
      .attr("data-x", newMesa.x)
      .attr("data-y", newMesa.y)
      .css({
        position: "absolute",
        top: newMesa.y + topSala,
        left: newMesa.x + leftSala,
      })
      .appendTo("#salaReservas");
  }
}

function mostrarReservas() {
  
}

$("document").ready(function () {
  obtenerMesasReservas();
  $(".mesa").click(function (ev) {
    console.log(ev.target);
  });
});
