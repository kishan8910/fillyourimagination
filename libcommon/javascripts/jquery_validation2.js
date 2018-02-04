<script type="text/javascript">

jQuery.fn.jquery_validation  = function()
{
    $(".errors").remove();
    var check_list = {};
    
    check_list.name = /^[A-Za-z\s.]+$/;
    check_list.general = /^[A-Za-z0-9\s.\-\/]{2,20}$/;
    check_list.email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    check_list.digit = /^[+]?[0-9\s]+$/;
    check_list.mark = /^[+]?[0-9]+(\.[0-9]+)?$/; 
    check_list.username = /^[a-z0-9_-]{3,16}$/;
    check_list.password = /^[a-z0-9_-]{6,18}$/;
    var error_flag = 0;
    
    $('div .validation .required').each(function(index, element)
    {
        var data = $.trim(this.value);  
        var elemid = this.id;
        $.each($(this).attr('class').split(/\s+/), function(i, v)
        {
            if(check_list[v] != undefined )
            {
                if(!(check_list[v]).test(data))
                {
                    $('div .validation #'+elemid).after("<span class='errors' style='margin: 0 10px; font-style: italic; font-size: 14px; color:red;'>Invalid Entry</div>"); 
                    error_flag = 1;
                }
            }           
        });
    }); 
    
    return error_flag;   
};

</script>
