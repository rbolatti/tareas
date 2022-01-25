
$(document).ready(function () {
    $('#table').DataTable( {
        "order": [[ 0, "desc" ]],
        "createdRow": function( row, data, dataIndex ) {
         if ( data["11"] == "<label>Si</label>" ) {
          
             $( row ).css( "background-color", "#ffcdd2  " );
             
         }
     },
    } );
  });

// SCRIPT PARA JALAR DATOS Y ABRIR MODAL PARA EDITAR USUARIO

$(document).ready(function () {
    $('.VerModalTareaDesglosada').click(function () {
      var TaskIDShowHistoTarAsig = $(this).attr("id");
      $('#ModalTareaCompleta').modal("show");
      $.ajax({
          data: { TaskIDShowHistoTarAsig: TaskIDShowHistoTarAsig },
          url: 'Classes/Querys.php',
          type: 'post',
          dataType: 'JSON',
          success: function (data) {
            $('#txtUserAsignadorDeTareaShow').val(data[0].Asignador);
            $('#txtTituloShow').val(data[0].TituloTarea);
            $('#txtDescripcionShow').val(data[0].Descripcion);
            $('#txtAsignadoShow').val(data[0].Asignado);
            $('#txtFechaLimiteShow').val(data[0].FechaLimite);
          }
        });
    });
  });
