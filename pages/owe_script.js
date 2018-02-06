function main()
{
    //Hide Items
    $("#positive_add_form, #negative_add_form").hide();
    $('.positive_edit_form').hide();
    $('.negative_edit_form').hide();
    
    //**Show after click positive
   $('#positive_add_show').on('click', function(){
   $("#positive_add_form").slideToggle();    
});
    
    //Show after click negative
   $('#negative_add_show').on('click', function(){
   $("#negative_add_form").slideToggle();    
});
    
    //**Add someone positive
    $('#positive_add_confirm').on('click', function(){
    var msg = "";
    if(document.form_positive_add.positive_money.value == "") msg += "\nWrite The money please!";
    if(document.form_positive_add.positive_person.value == "") msg += "\nWrite The Person's name please!";    
    if(msg != "") alert(msg);
    else document.form_positive_add.submit();
});
    
    //Add someone negative
    $('#negative_add_confirm').on('click', function(){
        var msg = "";
    if(document.form_negative_add.negative_money.value == "") msg += "\nWrite The money please!";
    if(document.form_negative_add.negative_person.value == "") msg += "\nWrite The Person's name please!";    
    if(msg != "") alert(msg);
    else document.form_negative_add.submit();
});
    
    //Delete SomeOne positive
    $('#positive_delete').on('click', function(){
    document.form_positive_delete.submit();   
});
    
    //Delete SomeOne negative
    $('#negative_delete').on('click', function(){
    document.form_negative_delete.submit();   
});
    
    //**Delete ALL positive
    $('#positive_delete_all').on('click', function(){
    document.form_positive_delete_all.submit();   
});
   
    //Delete ALL negative
    $('#negative_delete_all').on('click', function(){
    document.form_negative_delete_all.submit();   
});
    
    //**Show after Edit click positive
   $('.btn-primary').on('click', function(){
       $(".btn-primary").hide();
   $(".positive_edit_form").slideToggle();    
});
    
    //**Show after Edit click negative
   $('.btn-warning').on('click', function(){
   $('.btn-warning').hide();
   $(".negative_edit_form").slideToggle();    
});
    
    //About Us
    $('#about_us').on('click', function(){
    alert("The creator of Mizania's website: \nLt. Raouf, called Zooma! \nMake sure to check our products on www.zooma.com.") ;
});
}
$(document).ready(main);