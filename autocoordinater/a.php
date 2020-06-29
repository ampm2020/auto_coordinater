<form name="form" method="GET">
<input type="checkbox" name="aaa" onClick="AllChecked();" /> 全選択

<input type="checkbox" name="type[]" />
<input type="checkbox" name="type[]" />
<input type="checkbox" name="type[]" />

</form>
<script language="JavaScript" type="text/javascript">
<!--
function AllChecked(){
  var check =  document.form.aaa.checked;

  for (var i=0; i<document.form.elements['type[]'].length; i++){
    document.form.elements['type[]'][i].checked = check;
  }
}
//-->
</script>