<script type="text/javascript">

jQuery.fn.jquery_validation  = function(id)
{
    $(".errors").remove();
    var list = [];
    var name = /^[A-Za-z\s.]+$/;
    var general = /^[A-Za-z0-9\s.\-\/]{2,20}$/;
    var email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    var digit = /^[+]?[0-9\s]+$/;
    var mark = /^[0-9]+(\.[0-9]+)?$/; 
    list.push('name');
    list.push('general');
    list.push('email');
    list.push('digit');
    list.push('mark');
    //list.push();
    alert(list);
    $('div .validation .validate').each(function(index, element)
    {
        var data = $.trim(this.value);  
        //alert(data);
        //alert(this.id);
        var objid = this.id;
        $.each($(this).attr('class').split(/\s+/), function(i, v)
        {
            //alert(v);
            if ($.inArray(v, list) !== -1)
            {
                //alert("yes");
                //alert(eval(v));
                if(!(eval(v)).test(data))
                {
                    alert('no ,'+objid+', '+data);
                    //var e = $("<span class='errors' style='color:#F00;'>Invalid Entry</span>");
                    $("#"+objid).after("<span class='errors' style='color:red;'>Invalid Entry</span>"); 
                    //$("#"+objid).val("errors");
                }
            }           
        //alert(this.value);
        //$(this).css("background-color", "#FF0");
        //$(this).hide();
       //$(element).append("bar");
        });
    });  
};

</script>
