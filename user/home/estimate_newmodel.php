<?php require_once("config.php"); ?>

<?php if ($_SERVER['REQUEST_METHOD'] != "POST"){ ?>
<html>
<head>
<title></title>

<script>

    
 

function addAnotherFileUploadElement(){
    //document.getElementById('fileUploadElements').innerHTML += '<input type=file name=stlFiles[]>';
    var theDiv = document.getElementById("fileUploadElements");
    var newNode = document.createElement('span');      
    newNode.innerHTML = "<input type=file name=stlFiles[] multiple>";
    theDiv.appendChild(newNode);
}

window.onload = function(){
    var rad = document.customQuote.color;
    for(var i = 0; i < rad.length; i++) {
        rad[i].onclick = function() {
            document.getElementsByName("material")[0].value = this.className;
        };
    }
}

</script>

</head>


<script type="text/javascript">

  
function validateMaterial(material) 
    {
        if (material == "ABS" || material == "PLA") 
        {
            return true;
        }
        else
        {
            Materialize.toast('Error occurred ! Choose valid material.'+material, 2000,'');
            return false;
        }
    }

    function validateLayerHeight(layerHeight)
    {
        if (layerHeight <= 0 || layerHeight > 0.4 || layerHeight == "") 
        {
            Materialize.toast('Error occurred ! Try again with different layer height.', 2000,'');
            return false;
        }
        else
        {
            return true;
        }
    }

    function validateInfill(infill)
    {
        if (infill < 0 || infill > 100 || infill == "") 
        {
            Materialize.toast('Error occurred ! Try again with different infill percentage.', 2000,'');
            return false;
        }
        else
        {
            return true;
        }
    }

    function validateColor(color)
    {

        if (color == "" || color == undefined) 
        {
            Materialize.toast('Error occurred ! Select a color.', 2000,'');
            return false;
        }
        else
        {
            return true;
        }
    }

    function submitEstimation()
    {
        var material = $("input[name='material']:checked").val();
        var layerHeight = $("#layerHeight").val();
        var infill = $("#infillPercentage").val();
        var filament_color = $("#filament_color").val();
        
        // alert(filament_color);
        
        if (validateMaterial(material) && validateLayerHeight(layerHeight) && validateInfill(infill) && validateColor(filament_color)) 
        {
            $("#customQuote").submit();
        }
        else
        {

        }

    }

</script>

<div class="container">
<div class="row">
<div class="col s10 offset-s2">
            <blockquote>
                <h5>Upload Model</h5>
            </blockquote>
<script type="text/javascript">
    $(document).ready(function() {
        $('select').material_select();
      });
</script>

<form action="#" method="POST" enctype="multipart/form-data" name="customQuote" id="customQuote">
<body>
    <div class="container">
<div class="row">
     <div class="input-field col s10">
     
    </div>

    <div class="input-field col s8">
        <!-- <i class="material-icons prefix">file_upload</i>
          <span id="fileUploadElements"><input type="file" name="stlFiles[]" class="btn" multiple></span>
          <label for="icon_prefix"></label> -->
          <div class="file-field input-field">
          <div class="btn">
            <span>File</span>
            <span id="fileUploadElements"><input type="file" name="stlFiles[]" multiple></span>
          </div>
          <div class="file-path-wrapper">
            <input class="file-path validate" type="text">
          </div>
        </div>
     </div>

     <div class="col s8" style="padding: 10px;" >
       <input name="material" type="radio" checked id="ABS" value="ABS" />
      <label for="ABS">ABS (Acrylonitrile Butadiene Styrene)</label>
     </div>
     <div class="col s8" style="padding: 10px;">
         <input  name="material" type="radio"  id="PLA" value="PLA" />
      <label for="PLA">PLA (Polylactic acid)</label>
      </div>

  <div class="col s8" style="padding: 10px;"></div>

   <div class="input-field col s8">        
          <!-- <input type='text' size='40' class="validate" id="middle_name" placeholder="middle name" name='middle_name' value='<?=$middle_name?>'> -->
          <select name="layerHeight" id="layerHeight">
                        <option value="" disabled selected>Select</option>
                        <option value="0.1">0.1 mm</option>
                        <option value="0.2">0.2 mm</option>
                    </select>
                
                    <label>Choose Layer Height</label>
    </div>

   <div class="input-field col s8">
    
  </div>
  <input type="hidden" name="infillPercentage" id="infillPercentage" value="30">
  <!-- <div class="input-field col s8">        
          
        <input type="number" step="1" id="infillPercentage" name="infillPercentage" value="30">
        <label for="icon_prefix">Infill Percentage (0 to 100%)</label>
    </div> -->

   <!-- <div class="input-field col s8">
    
  </div> -->

<div class="col s8 input-field" >
  
    <select name="color" id="filament_color">
      <option value="" disabled selected>Choose your option</option>
       <?

      $query = "SELECT * FROM filament_color";
      $result = sql_query($query,$connect);

      if (sql_num_rows($result)) {
        while ($row = sql_fetch_array($result)) {
          echo '<option value="'.$row[id].'" >'.$row[color].'</option>';

        }
      }

    ?> 
     
    </select>
    <label>Choose color</label>
  </div>


   <div class="input-field col s8">
    
  </div>


    <div class="input-field col s8"> 

        <input type="button" value="Submit" onclick="submitEstimation();" class="btn" name="submit-btn"> 
    </div>

   <!--  <div class="input-field col s10">
        <i class="material-icons prefix">home</i>
          <input type="text"  class="input-large mandatory regx_general validate" placeholder="Street No" name='address_street_no' id='address_street_no' value='<?echo $address_street_no?>'>
          <label for="icon_prefix">Street No</label>
     </div> -->

     
</div>
</div>
 

</form>


</div>
</div>
</div>

</body>
</html>
<?php }

include 'estimation_process.php';

 ?>


