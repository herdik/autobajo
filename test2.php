<?php 
echo phpversion();
?>
<!DOCTYPE html>
<html>
<head>
    <title></title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <style>
  #options{
    display: none;
    height: 300px;
    text-align: center;
    border: 1px solid black;
    overflow-y:scroll;
  }
  #options>p{
    margin-top: 10px;
    margin-bottom: 10px;
    cursor: pointer;
  }
    </style>
</head>
<body>
<form action="demo_form.asp" method="get">

  <input list="browsers" name="browser">

  <datalist id="browsers">

  <option disabled=true value="a"></option>
  <option disabled=true value="b"></option>
  <option disabled=true value="c"></option>
  <option disabled=true value="d"></option>
  <option disabled=true value="e"></option>
  <option disabled=true value="f"></option>
  <!-- <option value="g"></option>
  <option value="h"></option>
  <option value="i"></option>
  <option value="j"></option>
  <option value="k"></option>
  <option value="l"></option>
  <option value="m"></option>
  <option value="n"></option>
  <option value="o"></option>
  <option value="p"></option>
  <option value="q"></option>
  <option value="r"></option>
  <option value="s"></option>
  <option value="t"></option>
  <option value="u"></option>
  <option value="v"></option>
  <option value="w"></option>
  <option value="x"></option>
  <option value="y"></option>
  <option value="z"></option> -->

  </datalist>

  <input type="submit">

  <div id="options">
  </div>

</form>
<div class="med_rec"></div>
<script>
$('#browsers option').each(function(){
  $('#options').append('<p>'+$(this).val()+'</p>');
})

$('#options').css({'width':$('input[name="browser"]').width()});
    $('input[name="browser"]').click(function(){
         $('#options').show();
    });
  $('input[name="browser"]').keyup(function(){
    $('#options').hide();
  });
  $('#options p').click(function(){
    $('input[name="browser"]').val($(this).text());
    $('#options').hide();
  })
</script>
</body>
</html>