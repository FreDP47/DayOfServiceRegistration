$(document).ready(function () {

    function loadLocationData(html) {
        $("#locSection").html(html);
        if (html.startsWith("<label style")) {
            $('#btnSubmit').css("display", "none");
            $('#btnQueue').css("display", "inline-block");
        }
        else {
            $('#btnSubmit').css("display", "inline-block");
            $('#btnQueue').css("display", "none");
        }
        $(".overlay").hide();
    }

    //displaying submit btn and hiding queue btn
    function resetSubmitBtn() {
        $('#btnSubmit').css("display", "inline-block");
        $('#btnQueue').css("display", "none");
    }

    //disabling the other city name field by default
    $('#otherCityName').attr("disabled", "disabled");

    //loading region section when bhubaneswar is selected  
    $('#cityDrpDwn').on('change', function () {
        $(".overlay").show();
        resetSubmitBtn();

        //storing city name in hidden field to use in php
        $('#cityName').val($('#cityDrpDwn option:selected').text());
        if (this.value == 12) {
            $('#otherCitySection').css("display", "none");
            $('#otherCityName').attr("disabled", "disabled");
            var cityString = "city=" + this.value;
            $.ajax({
                type: "POST",
                url: "getRegions.php",
                data: cityString,
                success: function (html) {
                    $("#regSection").html(html);
                    $(".overlay").hide();

                    //loading location when a region is selected
                    $('#regDrpDwn').on('change', function () {
                        resetSubmitBtn();
                        $(".overlay").show();
                        var groupNo = $('#groupNo').val() === "" ? 0 : $('#groupNo').val();
                        if (this.value != 'none') {

                            //storing region name in hidden field to use in php
                            $('#regionName').val($('#regDrpDwn option:selected').text());
                            var regionString = "region=" + this.value + "&groupNo=" + groupNo;
                            $.ajax({
                                type: "POST",
                                url: "getLocations.php",
                                data: regionString,
                                success: function (html) {
                                    loadLocationData(html);

                                    if ($('#locDrpDwn').val() != undefined && $('#locDrpDwn').val() != "none") {
                                        $('#locDrpDwn').on('change', function () {
                                            if (this.value != 'none') {

                                                //storing location name in hidden field to use in php
                                                $('#locationName').val($('#locDrpDwn option:selected').text());
                                            }
                                        });
                                    }
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

    //hiding feedback section if the user selects no for have you voluntereed before quetion
    $('#volDosOption .radio-inline').click(function () {
        if ($(this)[0].innerText == 'No') {
            $('#feedback').attr("disabled", "disabled");
            $('#feedbackSection').css("display", "none");
        }
        else {
            $('#feedback').removeAttr("disabled", "disabled");
            $('#feedbackSection').css("display", "block");
        }
    });

    //disabling the group no. field by default
    $('#groupNo').attr("disabled", "disabled");

    //Hiding group no. field if single user
    $('#groupUser .radio-inline').click(function () {
        if ($(this)[0].innerText == 'Group') {
            $('#groupNo').removeAttr("disabled", "disabled");
            $('#groupNoSection').css("display", "block");
            $('#singleUserSkillSection').css("display", "none");
            $('#groupUserSkillSection').css("display", "block");
        }
        else {
            $('#groupNo').attr("disabled", "disabled");
            $('#groupNoSection').css("display", "none");
            $('#singleUserSkillSection').css("display", "block");
            $('#groupUserSkillSection').css("display", "none");
            $('#groupDetailRegion').empty();
            $('#groupNo').val('');
            $('#groupDetailSection').css("display", "none");
        }
    });

    //adding appropriate no. of rows to take group user input
    $('#groupNo').change(function () {
        var groupNo = this.value;
        if (groupNo > 1) {
            $('#groupDetailRegion').empty();
            $('#groupDetailSection').css("display", "block");
            for (var index = 0; index < groupNo-1; index++) {
                var nameId = "groupUserName" + index;
                var emailId = "groupEmailId" + index;
                var phoneId = "groupUserPhone" + index;
                var institutionId = "groupUserInstitution" + index;
                var ageId = "groupUserAge" + index;
                var localLangComfortId = "groupUserlocalLangComfort" + index;
                var element = '';
                if(index + 1 == groupNo-1){
                    element = $('<div class="row lastGroupMemberDetailRow">' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + nameId + '">Name* :</label>' +
                    '<input type="text" class="form-control" id="' + nameId + '" placeholder="John Doe" name="' + nameId + '" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + emailId + '">Email* :</label>' +
                    '<input type="email" class="form-control" id="' + emailId + '" placeholder="someone@example.com" name="' + emailId + '" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + phoneId + '">Phone* :</label>' +
                    '<input type="tel" class="form-control" id="' + phoneId + '" placeholder="xxxxxxxxxx" name="' + phoneId + '" pattern="[0-9]{10}" title="Phone No. should be 10 digits" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + institutionId + '">Organization* :</label>' +
                    '<input type="text" class="form-control" id="' + institutionId + '" placeholder="Type Here......" name="' + institutionId + '" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + ageId + '">Age* :</label>' +
                    '<input type="text" class="form-control" id="' + ageId + '" placeholder="Type Here......" name="' + ageId + '" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + localLangComfortId + '">Local Language* :</label>' +
                    '<select name="' + localLangComfortId + '" id="' + localLangComfortId + '" class="form-control" required>' +
                    '<option value="" selected>---Select---</option>' +
                    '<option value="very good">Very Good</option>' +
                    '<option value="good">Good</option>' +
                    '<option value="average">Average</option>' +
                    '<option value="poor">Poor</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>');
                }
                else{
                    element = $('<div class="row groupMemberDetailRow">' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + nameId + '">Name* :</label>' +
                    '<input type="text" class="form-control" id="' + nameId + '" placeholder="John Doe" name="' + nameId + '" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + emailId + '">Email* :</label>' +
                    '<input type="email" class="form-control" id="' + emailId + '" placeholder="someone@example.com" name="' + emailId + '" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + phoneId + '">Phone* :</label>' +
                    '<input type="tel" class="form-control" id="' + phoneId + '" placeholder="xxxxxxxxxx" name="' + phoneId + '" pattern="[0-9]{10}" title="Phone No. should be 10 digits" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + institutionId + '">Organization* :</label>' +
                    '<input type="text" class="form-control" id="' + institutionId + '" placeholder="Type Here......" name="' + institutionId + '" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + ageId + '">Age* :</label>' +
                    '<input type="text" class="form-control" id="' + ageId + '" placeholder="Type Here......" name="' + ageId + '" required>' +
                    '</div>' +
                    '<div class="form-group col-lg-2">' +
                    '<label for="' + localLangComfortId + '">Local Language* :</label>' +
                    '<select name="' + localLangComfortId + '" id="' + localLangComfortId + '" class="form-control" required>' +
                    '<option value="" selected>---Select---</option>' +
                    '<option value="very good">Very Good</option>' +
                    '<option value="good">Good</option>' +
                    '<option value="average">Average</option>' +
                    '<option value="poor">Poor</option>' +
                    '</select>' +
                    '</div>' +
                    '</div>');
                }
                $('#groupDetailRegion').append(element);
            }

            if ($('#regDrpDwn').val() != undefined && $('#regDrpDwn').val() != "none") {
                $(".overlay").show();
                var regionString = "region=" + $('#regDrpDwn').val() + "&groupNo=" + groupNo;
                $.ajax({
                    type: "POST",
                    url: "getLocations.php",
                    data: regionString,
                    success: function (html) {
                        loadLocationData(html);
                    }
                });
            }
        }
        else {
            $('#groupDetailRegion').empty();
            $('#groupDetailSection').css("display", "none");
            $('#btnSubmit').css("display", "inline-block");
            $('#btnQueue').css("display", "none");
        }
    });

    $('#volForm').submit(function (e) {
        $(".overlay").show();
        e.preventDefault();
        $form = $(this);

        var btnQueueStyle = $(btnQueue).css("display");
        if(btnQueueStyle == 'inline-block'){//Queuing the form
            $.ajax({
                type: "POST",
                url: 'queue_page.php',
                data: $form.serialize(),
                success: after_form_submitted,
                error: error_form_submitted
            });
        }
        else{//submitting the form
            $.ajax({
                type: "POST",
                url: 'registration_page.php',
                data: $form.serialize(),
                success: after_form_submitted,
                error: error_form_submitted
            });
        }
    });

    function after_form_submitted() {
        var city = $('#cityDrpDwn').val() != undefined && $('#cityDrpDwn').val() != "none" ? ($('#cityDrpDwn').val() != "other" ? $('#cityDrpDwn option:selected').text() : $('#otherCityName').val()) : '';
        var region = $('#regDrpDwn').val() != undefined && $('#regDrpDwn').val() != "none" ? $('#regDrpDwn option:selected').text() : '';
        var time = $("#locDrpDwn").val() != undefined && $('#locDrpDwn').val() != "none" ? $('#locDrpDwn option:selected').text() : '';
        var email = $("#email").val();
        var phone = $("#phone").val();
        $(".overlay").hide();

        var btnQueueStyle = $(btnQueue).css("display");
        if(btnQueueStyle == 'inline-block'){
            window.location = 'http://localhost/DOSRegistration/success.php?city=' + city + '&region=' + region + '&time=' + time + '&email=' + email + '&phone=' + phone + '&confirmation=q';
        }
        else{
            window.location = 'http://localhost/DOSRegistration/success.php?city=' + city + '&region=' + region + '&time=' + time + '&email=' + email + '&phone=' + phone + '&confirmation=u';
        }
        
    }

    function error_form_submitted() {
        $(".overlay").hide();
        window.location = 'http://localhost/DOSRegistration/error.php';
    }
});