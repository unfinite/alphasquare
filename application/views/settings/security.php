<p>Here are the 50 latest events that have to do with your account.</p>
<p>See any suspicious activity? <a href="#" id="report-events-link">Report it to Alphasquare...</a></p>

<div id="report-events" class="panel panel-default" style="display:none;">
  <div class="panel-body">
    <h3 style="margin-top:0;">Report suspicious activity</h3>
    <p>Please tick the checkboxes next to the suspicious events and then click <b>Report</b>.</p>
    <button class="btn btn-warning" id="report">Report</button>
    <button class="btn btn-default cancel">Cancel</button>
  </div>
</div>

<table class="table table-bordered table-striped">
  <tr>
    <th class="check hidden"></th>
    <th>Event</th>
    <th>When</th>
    <th>IP address</th>
  </tr>

  <? foreach($events as $event): ?>
  <tr>
    <td class="check hidden text-center">
      <input type="checkbox" value="<?=$event['id']?>" />
    </td>
    <td>
      <?=$event['object'].'.'.$event['event']?>
      <? if($event['value']): ?>
      <br /><small>(<?=$event['value']?>)</small>
      <? endif; ?>
    </td>
    <td><span class="timeago" title="<?=date('c', $event['time'])?>"><?=date('c', $event['time'])?></span></td>
    <td>
      <?=$event['ip']?>
      <? if($event['ip'] == $_SERVER['REMOTE_ADDR']):?>
      <small>(you)</small>
      <? endif; ?>
    </td>
  </tr>
  <? endforeach; ?>
</table>