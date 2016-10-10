<script type="text/javascript">
    <!--//
    change(val) {
        document.scriptform.action = "http://www.mysite.com/newad.php?do=newad&cat="+val;
    }
    //-->
    </script>

    <form name="scriptform" method="post" action=http://www.mysite.com/newad.php?do=newad&cat=" target="_self">"
    <div class="blocked">
    <select name="catselect" onChange="change(this.value)">
    <option value="0">Please select a Category</option>
    <optgroup label="Cars"></optgroup>
    <option value="14" class="">BMW</option>
    <option value="23" class="">Porsche</option>
    </select>
    </div>
    </form>




    <form name="scriptform" method="post" action=http://www.mysite.com/newad.php?do=newad&cat=<?php urlencode($_POST['catselect']); ?>" target="_self">"
<div class="blocked">
<select name="catselect">
<option value="0">Please select a Category</option>
<optgroup label="Cars"></optgroup>
<option value="14" class="">BMW</option>
<option value="23" class="">Porsche</option>
