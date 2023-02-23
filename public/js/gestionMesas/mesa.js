class Mesa {
  constructor(id, anchura, altura, x, y) {
    this.id = id;
    this.anchura = anchura;
    this.altura = altura;
    this.x = x;
    this.y = y;
  }
}

function newMesa(id, anchura, altura, x, y) {
  var topSala = $("#sala").offset().top;
  var leftSala = $("#sala").offset().left;
  const newMesa = new Mesa(id, anchura, altura, x, y);

  if (
    (newMesa.x == null && newMesa.y == null) ||
    (newMesa.x == -1 && newMesa.y == -1)
  ) {
    $("<div>")
      .addClass("mesa")
      .attr("id", id)
      .css("width", newMesa.anchura)
      .css("height", newMesa.altura)
      .attr("data-x", newMesa.x)
      .attr("data-y", newMesa.y)
      .appendTo("#almacen");
  } else {
    $("<div>")
      .addClass("mesa")
      .attr("id", id)
      .css("width", newMesa.anchura)
      .css("height", newMesa.altura)
      .attr("data-x", newMesa.x)
      .attr("data-y", newMesa.y)
      .css({
        position: "absolute",
        top: newMesa.y+topSala,
        left: newMesa.x+leftSala,
      })
      .appendTo("#sala");
  }

  draggableMesa();
}

function draggableMesa() {
  $(".mesa").draggable({
    start: function (ev, ui) {
      //lo guardo en obj mesa
      $(this).attr("data-y", ui.offset.top);
      $(this).attr("data-x", ui.offset.left);
    },
    revert: true,
    revertDuration: 0,
    helper: "clone",
    accept: "#almacen, #sala",
  });
}

function obtenerMesas() {
  $.ajax({
    method: "GET",
    url: "/api/mesa/getAll",
    dataType: "json",
    async: false,
  }).done(function (data) {
    $.each(data, function (key, mesa) {
      newMesa(
        mesa.object.id,
        mesa.object.anchura,
        mesa.object.altura,
        mesa.object.x,
        mesa.object.y
      );
    });
  });
}
