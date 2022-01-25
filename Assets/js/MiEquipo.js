$(document).ready(function () {
  $('#table22').DataTable( {
      "order": [[ 0, "desc" ]],
      "createdRow": function( row, data, dataIndex ) {
       if ( data["9"] == "<label>Si</label>" ) {
        
           $( row ).css( "background-color", "#ffcdd2  " );
           
       }
        if ( data["10"] == "<label>Si</label>" ) {
        
           $( row ).css( "background-color", "#ccff90  " );
           
       }
        
   },
  } );
});
$(document).ready(function () {
  $('#table23').DataTable( {
      "order": [[ 0, "desc" ]],
      "createdRow": function( row, data, dataIndex ) {
      
         if ( data["9"] == "<label>Si</label>" ) {
        
           $( row ).css( "background-color", "#ffcdd2  " );
           
       }
          if ( data["10"] == "<label>Si</label>" ) {
        
           $( row ).css( "background-color", "#ccff90  " );
           
       }
   },
  } );
});


  

// SCRIPT PARA JALAR DATOS Y ABRIR MODAL PARA EDITAR USUARIO

$(document).ready(function () {
    $('.VerModalTareaDesglosada').click(function () {
      var TaskIDShow = $(this).attr("id");
      $('#ModalTareaCompleta').modal("show");
      $.ajax({
          data: { TaskIDShow: TaskIDShow },
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

  