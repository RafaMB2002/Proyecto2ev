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

function obtenerReservas() {
  $.ajax({
    method: "GET",
    url: "/api/reserva/getAll",
    dataType: "json",
    async: false,
  }).done(function (data) {
    $.each(data, function (key, reserva) {
      console.log(reserva)
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

function mostrarReservas() { }

function obtenerTramos() {
  $.ajax({
    method: "GET",
    url: "/api/tramo/getAll",
    dataType: "json",
    async: false,
  }).done(function (data) {
    $.each(data, function (key, tramo) {
      var tramoInicio = tramo.object.inicio.date;
      tramoInicio = tramoInicio.split(" ")[1];
      tramoInicio = tramoInicio.substr(0, 8);
      tramoInicio = $.trim(tramoInicio);

      var tramoFin = tramo.object.fin.date;
      tramoFin = tramoFin.split(" ")[1];
      tramoFin = tramoFin.substr(0, 8);
      tramoFin = $.trim(tramoFin);

      var idTramo = tramo.object.id;

      $("<option>")
        .html(tramoInicio + " - " + tramoFin)
        .attr("id", idTramo)
        .appendTo($("#tramosReservas"));
    });
  });
}

$("document").ready(function () {
  $(function () {
    $("#datepicker").datepicker({
      closeText: 'Cerrar',
      prevText: '< Ant',
      nextText: 'Sig >',
      currentText: 'Hoy',
      monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
      monthNamesShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
      dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
      dayNamesShort: ['Dom', 'Lun', 'Mar', 'Mié', 'Juv', 'Vie', 'Sáb'],
      dayNamesMin: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sá'],
      weekHeader: 'Sm',
      dateFormat: 'dd/mm/yy',
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: ''
    });
  });
  obtenerTramos();
  $("#botonReservas").click(function () {
    obtenerMesasReservas();
    obtenerReservas();
  });
  $(".mesa").click(function (ev) {
    console.log(ev.target);
    mostrarReservas();
  });
  $("#btnModal").click(function(){
    $("#miModal").modal()
  })
});
