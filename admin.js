$(document).ready(function(){
    $('#cityDrpDwn').on('change', function () {
        $(".overlay").show();

        //storing city name in hidden field to use in php
        $('#cityName').val($('#cityDrpDwn option:selected').text());
        if (this.value == 12) {
            $('#otherCitySection').css("display", "none");
            $('#otherCityName').attr("disabled", "disabled");
            var cityString = "city=" + this.value;
            $.ajax({
                type: "POST",
                url: "getAdminPageRegions.php",
                data: cityString,
                success: function (html) {
                    $("#regSection").html(html);
                    $(".overlay").hide();

                    //loading location when a region is selected
                    $('#regDrpDwn').on('change', function () {
                        $(".overlay").show();
                        var groupNo = $('#groupNo').val() === "" ? 0 : $('#groupNo').val();
                        if (this.value != 'none') {

                            //storing region name in hidden field to use in php
                            $('#regionName').val($('#regDrpDwn option:selected').text());
                            var regionString = "region=" + this.value + "&groupNo=" + groupNo;
                            $.ajax({
                                type: "POST",
                                url: "getAdminPageLocations.php",
                                data: regionString,
                                success: function (html) {
                                    $("#locSection").html(html);
                                    $(".overlay").hide();
                                }
                            });
                        }
                        else {
                            $("#locSection").empty();
                            $(".overlay").hide();
                        }
                    });
                }
            });
        }
        else if (this.value == "other") {
            $('#otherCitySection').css("display", "block");
            $('#otherCityName').removeAttr("disabled", "disabled");
            $("#regSection").empty();
            $("#locSection").empty();
            $(".overlay").hide();
        }
        else {
            $('#otherCitySection').css("display", "none");
            $('#otherCityName').attr("disabled", "disabled");
            $("#regSection").empty();
            $("#locSection").empty();
            $(".overlay").hide();
        }
    });

    $('form').submit(function (e) {
        var val = $("button[type=submit][clicked=true]").text();
        $(".overlay").show();
        e.preventDefault();

        if(val == "Search"){
            $form = $(this);
            $.ajax({
                type: "POST",
                url: "getUserTable.php",
                data: $form.serialize(),
                success: function (html) {
                    $('#tableSection').empty();
                    $('#tableSection').html(html);
                    $(".overlay").hide();
                },
                error:function(html){
                    alert("Some error occurred.");
                    console.log(html);
                    $(".overlay").hide();
                }
            });
        }
        else if(val == "Mail"){
            $form = $(this);
            $.ajax({
                type: "POST",
                url: "sendMail.php",
                data: $form.serialize(),
                success: function (html) {
                    alert("All EMail Sent Successfully");
                    console.log(html);
                    $(".overlay").hide();
                },
                error:function(html){
                    alert("Some error occurred.");
                    console.log(html);
                    $(".overlay").hide();
                }
            });
        }
        else {
            $form = $(this);
            $.ajax({
                type: "POST",
                url: "sendSms.php",
                data: $form.serialize(),
                success: function (html) {
                    alert("All SMS Sent Successfully");
                    console.log(html);
                    $(".overlay").hide();
                },
                error:function(html){
                    alert("Some error occurred.");
                    console.log(html);
                    $(".overlay").hide();
                }
            });
        }
        
    });

    $("form button[type=submit]").click(function() {
        $("button[type=submit]", $(this).parents("form")).removeAttr("clicked");
        $(this).attr("clicked", "true");
    });

    $('#emailBody').keyup(function(){
        if(this.value != "" && this.value != undefined){
            $('#btnEmail').removeAttr('disabled');
        }
        else{
            $('#btnEmail').attr('disabled','disabled');
        }
    });

    $('#smsBody').keyup(function(){
        if(this.value != "" && this.value != undefined){
            $('#btnSms').removeAttr('disabled');
        }
        else{
            $('#btnSms').attr('disabled','disabled');
        }
    });
});