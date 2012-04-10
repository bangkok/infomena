<style type="text/css">
#fixedright{position:fixed;right:0px;}
#fixedright .block{width:279px; text-align:left;  background-color:#fff; }
#rightpanel{position:fixed;right:0;width:20px;height:450px; background:url(/images/blocks/blue/bok-panel-cat.png) repeat-y right;display:block; cursor:pointer;}
</style>
<div id="rightpanel" onclick="$('#fixedright').toggle('normal');$(this).toggle('normal');"></div>
<div id="fixedright" style="display:none;">
<div style="position:fixed; right:0px; height:30px;color:#fff" onclick="$('#rightpanel').toggle('normal');$('#fixedright').toggle('normal');"></div>
<?=$this->load->view('block/right-panel-block')?>
</div>



