/*! Isaac Alejandro López Castrejón | 2018 */
$(document).ready(function()
{
//    altura($(window).height());
//    $(window).resize(function()
//    {
//        altura($(window).height());
//    });
//
//    function altura(alto)
//    {
//        $("#chat").attr("style","height:"+alto+"px;");
//    }

    $(".list-group-item").click(function()
    {
        $(".list-group-item").removeClass("active");
        $(this).addClass("active");
    });
});