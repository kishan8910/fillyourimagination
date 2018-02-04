<script type="text/javascript">
	function save_new_password(url,div)
	{
		var old_password = $("#old_password").val();
		var new_password = $("#new_password").val();
		var confirm_new_password = $("#confirm_new_password").val();
		var data = "old_password="+old_password+"&new_password="+new_password+"&confirm_new_password="+confirm_new_password;

		if ((new_password != confirm_new_password) || confirm_new_password == "") 
		{
			Materialize.toast('Password not matching!', 3000, 'rounded')
			return false;
		}

		$.ajax({
            type: "POST",
            url: "cp/"+url,
            data: data,
            success: function(response)
            {

            	if (response == 1) 
            	{
            		Materialize.toast('Password not matching!', 3000, 'rounded')	
            	}
            	else
            	{
                    
                    Materialize.toast('Password changed successfully!', 2000,'',function(){

                        window.location.href = "?u=home&b=user_home";

                    });
        
            	}
                
            }
          });  
 

	}

</script>

<div class="container">
<div class="row">
<div class="col s10 offset-s2">
            <blockquote>
                <h5>Change Password</h5>
            </blockquote>
<div class="input-field col s5 validation">
    <i class="material-icons prefix">security</i>
     <input id='old_password' type='password' size='30' class="required regx_general" >
    <label for="icon_prefix">Old Password</label>
</div>

<div class="input-field col s5 validation">
    <i class="material-icons prefix">security</i>
     <input id='new_password' type='password' size='30' class="required regx_general" >
    <label for="icon_prefix">New Pasword</label>
</div>

<div class="input-field col s5 validation">
    <i class="material-icons prefix">security</i>
     <input id='confirm_new_password' type='password' size='30' class="required regx_general" >
    <label for="icon_prefix">Confrm New Password</label>
</div>

<div class="input-field col s5">

     <input name="submit" type="button" class="btn" id="" value="Submit"  onclick="save_new_password('ajax_save_new_password.php', 'successmsg');" >
</div>

</div>
</div>
</div>

<div id="successmsg"></div>