$("#test").click(function() {
    jQuery.ajax({
            url: "http://localhost/horaires-salles/ajax_result.php",
            type: "GET",
            data: {
                "f": "6",
                "l": "7",
                "wd": "7",
            },
        })
            .done(function(data, textStatus, jqXHR) {
                let result = JSON.parse(data);
                result.forEach(function(element){
                    $("#result_table").append("<tr><td>" + element["name"] +"</td></tr>")
                });
                $("#result_table").show();
            })
            .fail(function(jqXHR, textStatus, errorThrown) {

            })
            .always(function() {
                /* ... */
            })
    }
);







