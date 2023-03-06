function obtenerMesasReservas() {
  var respuesta;
  var inputFecha = $("#datepicker").val();
  inputFecha = inputFecha.split("/");
  inputFecha = inputFecha[2] + "-" + inputFecha[1] + "-" + inputFecha[0];
  var inputTramo = $("#tramosReservas :selected")[0].id
  var inputJuego = $("#selectJuegos :selected")[0].id
  var datos11 = {
    fecha: inputFecha,
    tramo: inputTramo,
    juego: inputJuego
  };
  $.ajax({
    method: "POST",
    url: "/api/mesa/getAllMesaFiltros",
    dataType: "json",
    async: false,
    data: JSON.stringify(datos11),
    success: function (data) {
      respuesta = data;
    }
  });

  return respuesta;
}

function getAllMesas() {
  var respuesta;
  $.ajax({
    method: "GET",
    url: "/api/mesa/getAll",
    dataType: "json",
    async: false,
    success: function (data) {
      respuesta = data;
    }
  })
  return respuesta;/* .done(function (data) {
    $.each(data, function (key, mesa) {
      $.each(mesasFiltro, function(key, mesaFiltro){
        if (mesaFiltro.object.id != mesaSinfiltro.object.id) {
          console.log(mesaSinFiltro);
        }
      })
      newMesaReserva(
        mesa.object.id,
        mesa.object.anchura,
        mesa.object.altura,
        mesa.object.x,
        mesa.object.y
      );
    });
  }); */
}

function obtenerAllMesas() {
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
      console.log(reserva);
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

function obtenerJuegos() {
  $.ajax({
    method: "GET",
    url: "/api/juego/getAll",
    dataType: "json",
    async: false,
  }).done(function (data) {
    $.each(data, function (key, juego) {

      var idJuego = juego.object.id;
      var nombreJuego = juego.object.nombre;
      var anchoJuego = juego.object.ancho;
      var altoJuego = juego.object.alto;
      $("<option>")
        .html(nombreJuego)
        .attr("id", idJuego)
        .attr("data-ancho", anchoJuego)
        .attr("data-alto", altoJuego)
        .appendTo($("#selectJuegos"));
    });
  });
}

function getUser() {
  var respuesta;
  $.ajax({
    method: "GET",
    url: "/api/user",
    dataType: "json",
    async: false,
    success: function (data) {
      respuesta = data;
    }
  })
  return respuesta;
}

function crearReserva(fecha, mesa, usuario, juego, tramo) {
  inputFecha = fecha.split("/");
  inputFecha = inputFecha[2] + "-" + inputFecha[1] + "-" + inputFecha[0];
  datos = {
    fecha_inicio: inputFecha,
    mesa_id: mesa,
    user_id: usuario,
    juego_id: juego,
    tramo_id: tramo
  }

  $.ajax({
    method: "POST",
    url: "/api/reserva/add",
    dataType: "json",
    async: false,
    data: JSON.stringify(datos)
  })
}

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
      closeText: "Cerrar",
      prevText: "< Ant",
      nextText: "Sig >",
      currentText: "Hoy",
      monthNames: [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ],
      monthNamesShort: [
        "Ene",
        "Feb",
        "Mar",
        "Abr",
        "May",
        "Jun",
        "Jul",
        "Ago",
        "Sep",
        "Oct",
        "Nov",
        "Dic",
      ],
      dayNames: [
        "Domingo",
        "Lunes",
        "Martes",
        "Miércoles",
        "Jueves",
        "Viernes",
        "Sábado",
      ],
      dayNamesShort: ["Dom", "Lun", "Mar", "Mié", "Juv", "Vie", "Sáb"],
      dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sá"],
      weekHeader: "Sm",
      dateFormat: "dd/mm/yy",
      firstDay: 1,
      isRTL: false,
      showMonthAfterYear: false,
      yearSuffix: "",
    });
  });
  obtenerTramos();
  obtenerJuegos();
  $("#botonReservas").click(function () {
    var allMesas = getAllMesas();
    var mesasReservas = obtenerMesasReservas();
    $.each(allMesas, function (key, mesaNoFiltro) {
      if (mesasReservas == -1) {
        newMesaReserva(
          mesaNoFiltro.object.id,
          mesaNoFiltro.object.anchura,
          mesaNoFiltro.object.altura,
          mesaNoFiltro.object.x,
          mesaNoFiltro.object.y
        );
      } else {
        $.each(mesasReservas, function (key, mesaFiltro) {
          if (mesaNoFiltro.object.id != mesaFiltro.object.id) {
            if ($("#selectJuegos :selected")[0].dataset.ancho <= mesaNoFiltro.object.anchura && $("#selectJuegos :selected")[0].dataset.alto <= mesaNoFiltro.object.altura) {
              newMesaReserva(
                mesaNoFiltro.object.id,
                mesaNoFiltro.object.anchura,
                mesaNoFiltro.object.altura,
                mesaNoFiltro.object.x,
                mesaNoFiltro.object.y
              );
            }

          }
        });
      }

    });
    $(".mesa").click(function (ev) {
      $("#labelIdMesa").html(ev.target.id);
      $("#labelCampoFecha").html($("#datepicker").val());
      $("#labelCampoUser").html(getUser().object.nombreCompleto).attr('data-id', getUser().object.id);
      $("#labelIdTramo").html($("#tramosReservas :selected")[0].innerHTML).attr('data-id', $("#tramosReservas :selected")[0].id);
      $("#labelIdJuego").html($("#selectJuegos :selected")[0].innerHTML).attr('data-id', $("#selectJuegos :selected")[0].id);
      $("#miModal").dialog();
    });
  });
  $("#btnModal").click(function () {
    $("#miModal").dialog({
      /* title: "Crear reserva",
      classes: {
        "ui-dialog-titlebar": "modal-header"
      },
      buttons: [
        {
          text: "ok",
          click: function(){
            $(this).dialog("close");
          }
        },
      ], */
    });
  });
  $("#btnCancelar").click(function () {
    $("#miModal").dialog("close");
  })
  $("#btnCrear").click(function () {
    crearReserva($("#labelCampoFecha")[0].innerHTML, $("#labelIdMesa")[0].innerHTML, $("#labelCampoUser")[0].dataset.id, $("#labelIdJuego")[0].dataset.id, $("#labelIdTramo")[0].dataset.id);
  })
});
