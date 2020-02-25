//load bootstrap pop over
$(function(){
    $('.pop').popover();
});



//duplicate robots file option
function duplicate(){
    $( "#copy").clone().appendTo( "#rob").removeAttr('id');
}

//select generated text fro robots.txt
function select_text(id){
    $('#' + id).select();
}

//send request for robots.txt to be generated
function submit_rob(){
    var form = $('form#robots_form').serialize();
   
    $.post('includes/robots.php',form).done(function(data){
            $('#robots-result').val(data);
            if(data.length > 2){
                 $("#download").show();
            }
      
    });
    
}



//load file from files directory(competitord)
function addFile(id){
    $('#jresults').load('includes/files/' + id);
}


//refresh page
function refresh(){
    window.location = window.location.href;
}




$(document).ready(function(){
    if($('textarea[name="textr"]').val().length > 1){
       $("#download").show;
    }else{
        $("#download").hide();
    }
    
});
