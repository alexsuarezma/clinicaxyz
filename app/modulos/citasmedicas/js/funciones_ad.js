
    function enviar_dato(id) {
        
        $.ajax({
            type:'POST',
            url: "generar_pdf.php",
            data: 'id='+id,

            success:function(data){
                
                $("#panel_selector").html(data);
                     }
            
            
        })
       
    }
      

    function enviar_datos(id) {
        
        $.ajax({
            type:'POST',
            url: "generar_receta.php",
            data: 'id='+id,

            success:function(data){
                
                $("#panel_selector").html(data);
                     }
            
            
        })
       
    }
      