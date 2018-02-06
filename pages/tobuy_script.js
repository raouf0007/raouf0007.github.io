function main()
{
    //Hide Items
    $("#tobuy_add_form, .tobuy_edit_form").hide();
    
    //**Show Add after click tobuy
   $('#tobuy_add_show').on('click', function(){
   $("#tobuy_add_form").slideToggle();    
});
    
    //**Show Edit after click tobuy
   $('.btn-danger').on('click', function(){
   $('.btn-danger').hide();
   $(".tobuy_edit_form").slideToggle("1000");    
});
    
    //**Add someone tobuy
    $('#tobuy_add_confirm').on('click', function(){
        var msg = "";
    if(document.form_tobuy_add.tobuy_cost.value == "") msg += "\nWrite The money please!";
    if(document.form_tobuy_add.tobuy_item.value == "") msg += "\nWrite The item's name please!";    
    if(msg != "") alert(msg);
    else document.form_tobuy_add.submit();
});
    
    //**Delete ALL tobuy
    $('#tobuy_delete_all').on('click', function(){
    document.form_tobuy_delete_all.submit();   
});
    
    //Delete
    $('#tobuy_delete').on('click', function(){
    document.form_tobuy_delete.submit();   
});
    
    //Edit
    $('#tobuy_edit').on('click', function(){
    var msg = "";
    if(document.form_tobuy_edit.tobuy_edit_cost.value == "") msg += "\nWrite The money please!";
    if(msg != "") alert(msg);
    else document.form_tobuy_edit.submit();   
});
    
    //About Us
    $('#about_us').on('click', function(){
    alert("The creator of Mizania's website: \nLt. Raouf, called Zooma! \nMake sure to check our products on www.zooma.com.") ;
});
}
$(document).ready(main);