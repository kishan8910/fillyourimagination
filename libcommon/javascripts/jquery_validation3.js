<script type="text/javascript">

jQuery.fn.jquery_validation  = function()
{
    $(".errors").remove();
    var check_list = {};
    
    check_list.regx_name = /^[A-Za-z\s.]+$/;
    check_list.regx_general = /^[A-Za-z0-9\s.\-\/]{2,20}$/;
    check_list.regx_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;
    check_list.regx_digit = /^[+]?[0-9\s]+$/;
    check_list.regx_mark = /^[+]?[0-9]+(\.[0-9]+)?$/; 
    check_list.regx_username = /^[a-z0-9_-]{3,16}$/;
    check_list.regx_password = /^[a-z0-9_-]{6,18}$/;
    var error_flag = 0;
    
    $('div .validation .required').each(function(index, element)
    {
        var elem = $(this);
        //var htmlType = $(this).prop('tagName');
        var htmlType = $(this).attr('type');
        var data = $.trim(this.value);
        alert(htmlType);  
        $.each($(this).attr('class').split(/\s+/), function(i, v)
        {
            if(check_list[v] != undefined )
            {
                if(!(check_list[v]).test(data))
                {
                    elem.after("<span class='errors' style='margin: 0 10px; font-style: italic; font-size: 14px; color:red;'>Invalid Entry</div>");
                    error_flag = 1;
                }
            }
            else
            {
                /*if(htmlType == "radio" || htmlType == "checkbox")
                {
                    alert(htmlType);
                    if(elem.prop('checked') == false)
                    {
                        elem.after("<span class='errors' style='margin: 0 10px; font-style: italic; font-size: 14px; color:red;'>Invalid Entry</div>");
                    }
                    
                }*/ 
            }           
        });
    }); 
    
    return error_flag;   
};

</script>
