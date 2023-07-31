function showSuggestions(str) {   
    if (str.length == 0) {
        document.getElementById("suggestions").innerHTML = "";
        return;
    } else {
        var url = "../library/getSuggestions.php?r=all&q=" + str;
        $.ajax({url: url, success: function(result) {
            $("#suggestions").html(result);
        }});
    }
}

function showReviewedEmployerSuggs(str) {
    if (str.length == 0) {
        document.getElementById("suggestions").innerHTML = "";
        return;
    } else {
        var url = "../library/getSuggestions.php?q=" + str;
        $.ajax({url: url, success: function(result) {
            $("#suggestions").html(result);
        }});
    }
}