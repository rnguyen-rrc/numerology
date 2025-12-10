
$(function() {
    $(".error").addClass("hidden");

    $("#numCalculate").on("click", function (){
        const nameIsEmpty   = ($("#fullName").val() === "");
        const nickName      = ($("#nickName").val() === "");
        const dobIsEmpty    = ($("#dob").val() === "");
        const emailIsEmpty  = ($("#email").val() === "");
        const phoneIsEmpty  = ($("#telephone").val() === "");

        if(nameIsEmpty){
            $(".fullname-error").removeClass("hidden");
        }else{
            $(".fullname-error").addClass("hidden");
        }

        if(nickName){
            $(".nickname-error").removeClass("hidden");
        }else{
            $(".nickname-error").addClass("hidden");
        }
        if(dobIsEmpty){
            $(".dob-error").removeClass("hidden");
        }else{
            $(".dob-error").addClass("hidden");
        }
        if(emailIsEmpty && phoneIsEmpty){
            $(".email-phone-error").removeClass("hidden");
        }else{
            $(".email-phone-error").addClass("hidden");
        }

        if(nameIsEmpty || nickName || dobIsEmpty || (emailIsEmpty && phoneIsEmpty)){
            return false;
        }
    });
});