function main()
{
   $(".fuck").hide();
   $('#show').on('click', function(){
   $(".fuck").slideToggle();   // Change the color of the button    
});
    
    //About Us
    $('#about_us').on('click', function(){
    alert("The creator of Mizania's website: \nLt. Raouf, called Zooma! \nMake sure to check our products on www.zooma.com.") ;
});
}
$(document).ready(main);