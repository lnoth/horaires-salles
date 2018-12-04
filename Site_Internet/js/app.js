//prevent the page refresh
$("#researchForm").submit(function(e) {
    e.preventDefault();
});

//Do something when the user tries to submit the form
$(document).on('click','#submitButton',function(){

    let idStartHour = $("#startHour").children(":selected").attr("id");
    let idEndHour = $("#endHour").children(":selected").attr("id");
    let numberSelectedStartHour = idStartHour.split("_")[1];
    let numberSelectedEndHour = idEndHour.split("_")[1];

    if (numberSelectedStartHour >= numberSelectedEndHour){
        $("#submitError").text("Veuillez selectionner des heures cohérentes");
        $("#submitError").css("display","block");
    }else {
        $("#containerLoader").css("display","block");

    }
});